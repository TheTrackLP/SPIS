<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function ReportsDashboard(){
        return inertia('Backend/Reports');
    }
}
