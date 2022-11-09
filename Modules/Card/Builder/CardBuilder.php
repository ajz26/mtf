<?php
namespace App\Builder;

use App\Builder\EloquentModelBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CardBuilder extends EloquentModelBuilder  {
 
    
    public function whereCategory($category){
        return $this->whereCategory($category);
    }

}