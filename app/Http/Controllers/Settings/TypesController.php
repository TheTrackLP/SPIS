<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function TypesDashboard(){
        return inertia('Backend/Settings/Sector');
    }
}
