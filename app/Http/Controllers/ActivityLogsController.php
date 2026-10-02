<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function LogsDashboard(){
        return inertia('Backend/Logs', [
            'logs'=>LogActivity::select(
                'log_activities.*',
                'users.username',
            )
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
            ->get(),
        ]);
    }
}
