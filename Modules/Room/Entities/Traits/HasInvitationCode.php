<?php 
namespace Modules\Room\Entities\Traits;

use App\Helpers;
use Illuminate\Support\Str;

trait  HasInvitationCode {


    protected static function bootHasInvitationCode(){


        static::creating(function ($model) {
            $token = Helpers::crc32b_hash($model->id);
            $model->invitation_code = Str::upper($token);
        });


    }

}