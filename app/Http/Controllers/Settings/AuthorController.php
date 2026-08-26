<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function SettingAuthor(){
        return inertia('Backend/Settings/Authors', [
            'authors'=>Authors::all(),
        ]);
    }

    public function AddAuthor(Request $request){
        $valid = Validator::make($request->all(), [
            'authorhead' => "required",
            'authordesc' => "required",
            'authoroffice' => "required",
            'authoracronym' => "required",
            'authorposition' => "required",
            'authorterm' => "required",
        ]);

        if($valid->fails()){
            return redirect()->route('gear.author')->with(
                'error', 'Error, Try Again!'
            );
        }

        Authors::create([
            'authorhead' => strtoupper($request->authorhead),
            'authordesc' => $request->authordesc,
            'authoroffice' => $request->authoroffice,
            'authoracronym' => $request->authoracronym,
            'authorposition' => $request->authorposition,
            'authorterm' => $request->authorterm,
        ]);

        return redirect()->route('gear.author')->with(
            'success', 'Success, Author Added',
        );
    }
    public function EditAuthor(Request $request){
        $valid = Validator::make($request->all(), [
            'authorhead' => "required",
            'authordesc' => "required",
            'authoroffice' => "required",
            'authoracronym' => "required",
            'authorposition' => "required",
            'authorterm' => "required",
        ]);

        if($valid->fails()){
            return redirect()->route('gear.author')->with(
                'error', 'Error, Try Again!'
            );
        }

        Authors::findorfail($request->id)->update([
            'authorhead' => strtoupper($request->authorhead),
            'authordesc' => $request->authordesc,
            'authoroffice' => $request->authoroffice,
            'authoracronym' => $request->authoracronym,
            'authorposition' => $request->authorposition,
            'authorterm' => $request->authorterm,
        ]);

        return redirect()->route('gear.author')->with(
            'success', 'Success, Author Updated',
        );
    }
}
