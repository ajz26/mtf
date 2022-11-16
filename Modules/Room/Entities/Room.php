<?php

namespace Modules\Room\Entities;

use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Spatie\ModelStates\HasStates;
use Wildside\Userstamps\Userstamps;
use App\Builder\EloquentModelBuilder;
use Illuminate\Database\Eloquent\Model;
use Modules\Room\States\RoomState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Room\Entities\Traits\HasInvitationCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory , HasUuids, HasInvitationCode, HasStates;

    protected $fillable = [
        'id',
        'private',
        'max_users',
        'max_attempts',
        'category',
        'state',
        'hot_level',
        'started_at',
        'finished_at',
        'invitation_code',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'started_at',
        'finished_at',
    ];



    protected $casts = [
        'private' => 'boolean',
        'max_users' => 'integer',
        'state' => RoomState::class,

    ];


    use Userstamps {
        getUserClass as _getUserClass;
    }

    public function getUserClass(){
        return User::class;
    }
    
    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\RoomFactory::new();
    }


    public function newEloquentBuilder($builder) { 
        return new EloquentModelBuilder($builder); 
    }


    public function users(){
        return $this->belongsToMany(User::class);
    }
}
