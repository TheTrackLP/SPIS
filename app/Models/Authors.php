<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel(){
        return $this->fullname;
    }

    public function eventTypes(){
        return [];
    }
}
