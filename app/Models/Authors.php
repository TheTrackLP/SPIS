<?php

namespace App\Models;

use App\Traits\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $guarded = [];

    use ActivityLog;

    public function logLabel(){
        return trim($this->authorlastname . ', ' . $this->authorfirstname . ' ' . $this->authormiddlename);
    }

    public function eventTypes(){
        return [];
    }

    public function loggableFields(){
        return [
            'authorfirstname' => 'First Name',
            'authormiddlename' => 'Middle Name',
            'authorlastname' => 'Last Name',
            'authorbirtdate' => 'Birth Date',
        ];
    }
}
