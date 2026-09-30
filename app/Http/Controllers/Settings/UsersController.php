<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function UsersDashboard(){
        return inertia('Backend/Settings/Users', [
            'authors'=>Authors::select(
                '*',
                DB::raw("CONCAT(authorlastname, ', ', authorfirstname, ' ', authormiddlename) as fullname")
            )
            ->get(),
            'users'=>User::select(
                'users.*',
                DB::raw("CONCAT(authorlastname, ', ', authorfirstname, ' ', authormiddlename) as fullname"),
            )
            ->leftJoin('authors', 'authors.id', '=', 'users.authorid')
            ->get(),
        ]);
    }

    public function UsersStore(Request $request){
        $valid = Validator::make($request->all(), [
            'email' => 'required',
            'role' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('users.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        if($request->password != $request->confirmPass){
            return redirect()->route('users.dash')->with(
                'error', 'Error, Password Does not Match!',
            );
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'authorid' => $request->authorid,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.dash')->with(
            'success', 'Authentication Added',
        );
    }
}
