<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class AuthorTerms extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel(){
        return $this->authorid;
    }
    
    public function eventTypes() {
        return [];
    }

    public function loggableFields() {
        return [
            'authorid' => '',
            'authortermid' => '',
            'authortermno' => '',
            'authorposition' => '',
            'remarks' => '',
        ];
    }
}
