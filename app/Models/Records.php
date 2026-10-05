<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel() {
        return $this->title;
    }
    
    public function eventTypes() {
        return [];
    }

    public function loggableFields() {
        return [
            'sptermid' => 'SP Term',
            'type' => 'Type',
            'resono' => 'No.',
            'session_date' => 'Session Date',
            'title' => 'Title',
            'status' => 'Status',
            'authorname' => 'Author Name/s',
            'coauthorname' => 'Co Author/s',
            'mainclassname' => 'Main Classifications',
            'subclassname' => 'Sub Classifications',
            'sectorname' => 'Sector Name',
            'filepath' => 'File Path',
        ];
    }
}
