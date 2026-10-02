<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class SubClassifications extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel() {
        return $this->subname;
    }

    public function eventTypes(){
        return [];
    }
}
