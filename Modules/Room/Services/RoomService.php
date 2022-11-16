<?php
namespace Modules\Room\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Room\Entities\Room;
use Modules\Room\States\Started;
use App\Services\EloquentService;
use Modules\Room\States\Finished;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Room\Exceptions\MaxUsersExceded;
use Illuminate\Validation\ValidationException;
use Modules\Room\Exceptions\RoomCantBeStarted;
use Modules\Room\Exceptions\MinimumUsersNotCompleted;
use Modules\Room\States\Pending;

class RoomService extends EloquentService {


    protected $model;

    public function __construct(Room $model){
        parent::__construct($model);
    }



    public function create(array $payload): ? Room {

        $validator = Validator::make($payload,[
            'private'       =>  ['required','boolean'],
            'max_users'     =>  ['required','integer'],
            'max_attempts'  =>  ['nullable','integer'],
            'category'      =>  ['nullable'],
            'hot_level'     =>  ['required','integer'],
        ]);

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $model = parent::create($payload);

        $invitation_code = $model->invitation_code;

        $this->subscribe_user($model->id,Auth::user()->id,$invitation_code);

        return $model;
    }


    public function subscribe_user($room_id,$user_id,$invitation_code = null){ 

        $room         = $this->findById($room_id,['*'],['users']);


        if($room->state->equals(Started::class,Finished::class)){
            throw new Exception("You cant subscribe to this room becose has ben {$room->state}");
        }


        $user         = $room->users->where('id',$user_id)->first();

        if($user){
           throw new Exception('user previously subscribed');
        }

        if($room->private && !$invitation_code){
           throw new Exception('you need an invitation code for access access to this room');
        }

        if($room->private && ( $room->invitation_code !== $invitation_code)){
           throw new Exception('your invitation code is invalid');

        }

        $maxUsers     = $room->max_users ?? INF;
        $currentUsers = $room->users->count();

        if($currentUsers >= $maxUsers){
            throw new MaxUsersExceded();
        }

        return $room->users()->syncWithPivotValues($user_id,[
            'added_at' => Carbon::now()
        ],false);

    }


    public function unsubscribe_user($room_id,$user_id,$force_unsuscribe = false){
        
        $room         = $this->findById($room_id,['*'],['users']);


        $user   = $room->users();
        
        if(!$force_unsuscribe){
            $user = $user->withPivot('removed_at')->wherePivot('removed_at','==',null);
        }
        $user   = $user->where('id',$user_id)->first();

        if(!$user){
           throw new Exception('user not subscribed');
        }


        if($force_unsuscribe){
            return $room->users()->detach($user_id,true);
        }

        return $room->users()->syncWithPivotValues($user_id,[
            'removed_at' => Carbon::now(),
            'removed_by' => Auth::user()->id
        ]);

    }

    public function start($id){

        $room = $this->findById($id,['*'],['users']);

        if($room->users->count() <= 1){
            throw new MinimumUsersNotCompleted();
        }

        if(!$room->state->canTransitionTo(Started::class)){
            throw new RoomCantBeStarted();
        }


        $room->state->transitionTo(Started::class);


        $updated = $this->update($room->id,[
            'started_at' => Carbon::now() 
        ]);

        return $updated;

        if(!$updated){
            return throw new Exception('Model cant be updated');
        }

        return $updated;

    }



    public function finish($id){

        $room = $this->findById($id,['*'],['users']);

        if(!$room->state->canTransitionTo(Finished::class)){
            throw new RoomCantBeStarted();
        }

        $room->state->transitionTo(Finished::class);

        return $this->update($room->id,[
            'finished_at' => Carbon::now() 
        ]);

    }

}