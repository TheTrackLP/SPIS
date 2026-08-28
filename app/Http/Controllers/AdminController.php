<?php

namespace App\Http\Controllers;

use App\Models\Records;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard(){
        return inertia('Admin/Dashboard', [
            'records'=>Records::select('*')->orderby('resono', 'desc')->get(),
        ]);
    }
}
