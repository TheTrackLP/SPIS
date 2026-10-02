<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel() { return $this->record_no; }

    public function eventTypes() {
        return [
            'sptermno' => 'sptermno_changed',
            'termfrom' => 'termfrom_changed',
            'termto' => 'termto_modified',
        ];
    }
}
