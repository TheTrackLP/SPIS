<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel() 
    { 
        return $this->name; 
    }
    
    public function eventTypes() {
        return [];
    }

    public function loggableFields(){
        return [
            'name' => 'Sector Name',
            'desc' => 'Sector Description',
        ];
    }
}
