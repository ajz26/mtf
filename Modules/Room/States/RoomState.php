<?php
namespace Modules\Room\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;


class RoomState extends State{



    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Started::class)
            ->allowTransition(Started::class, Finished::class);
    }
    
}