<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $guarded = [];

    use ActivityLog;

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
