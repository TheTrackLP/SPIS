<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ],
        [
            'username' => 'Username is required',
            'email' => 'Email is required',
            'role' => 'Role is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        $checkPassword = Validator::make($request->all(), [
            'password' => ['required', 'string', 'same:confirmPass'],
            'confirmPass' => ['required'],
        ], [
            'password.same' => 'Password does not match.',
        ]);

        if($checkPassword->fails()){
             return $this->failedValidation($checkPassword);
        }
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'authorid' => $request->authorid,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return $this->StatusMessage(true, 'Success, Authentication Added', 'users.dash');
    }

    public function UsersEditAcct(Request $request){
        $user = User::findorfail($request->id);
    
        $valid = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('users.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        $data = [
            'username' => $request->username,
            'name'     => $request->name,
            'authorid' => $request->authorid,
            'email'    => $request->email,
            'role'     => $request->role,
            'status'   => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('users.dash')->with(
            'success', 'Authentication Updated',
        );
    }
}
