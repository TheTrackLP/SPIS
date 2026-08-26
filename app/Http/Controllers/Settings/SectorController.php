<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function SectorDashboard(){
        return inertia('Backend/Settings/Sector');
    }
}
