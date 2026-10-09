<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $guarded = [];

    public function logLabel(){ return $this->type_name; }
    
    public function eventTypes(){
        return [];
    }

    public function loggableFields(){
        return [
            'type_name' => 'Type Name',
            'type_desc' => 'Type Description',
        ];
    }
}
