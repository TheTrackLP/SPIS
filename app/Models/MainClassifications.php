<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class MainClassifications extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel(){
        return $this->mainname;
    }

    public function eventTypes(){
        return [];
    }
    public function loggableFields(){
        return [
            'mainname' => 'Main Class',
        ];
    }
}
