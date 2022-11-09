<?php
namespace Modules\Card\Services;

use Modules\Card\Entities\Card;
use App\Services\EloquentService;

class CardService extends EloquentService {


    protected $model;


    public function __construct(Card $model){
        parent::__construct($model);
    }



}