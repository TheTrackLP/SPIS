<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel() {
        return $this->resno;
    }
    
    public function eventTypes() {
        return [];
    }
}
