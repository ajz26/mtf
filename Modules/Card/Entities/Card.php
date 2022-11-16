<?php

namespace Modules\Card\Entities;

use Wildside\Userstamps\Userstamps;
use Modules\Card\Enums\CardTypeEnum;
use App\Builder\EloquentModelBuilder;
use Illuminate\Database\Eloquent\Model;
use Modules\Card\Enums\ResponseTypeEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Employee\Entities\Employee;

class Card extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
   
    use Userstamps {
        getUserClass as _getUserClass;
    }

    public function getUserClass(){
        return Employee::class;
    }

    protected $fillable = [
        'title',
        'content',
        'category',
        'response_type',
        'card_type',
        'hot_level',
    ];

    protected $casts = [
        'response_type' => ResponseTypeEnum::class,
        'card_type'     => CardTypeEnum::class,
    ];
    
    protected static function newFactory(){
        return \Modules\Card\Database\factories\CardFactory::new();
    }


    public function newEloquentBuilder($builder) { 
       return new EloquentModelBuilder($builder); 
    }
}
