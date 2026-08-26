<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function ClassDashboard(){
        return inertia('Backend/Settings/Classification',[
            'class1'=>Classification::select('*')->where('class', 'class1')->orderby('name')->get(),
            'class2'=>Classification::select('*')->where('class', 'class2')->orderby('name')->get(),
        ]);
    }

    public function ClassAdd(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'class' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('class.dash')->with(
                'error', 'Error, Try Again!'
            );
        }

        Classification::create([
            'name' => strtoupper($request->name),
            'class' => $request->class,
        ]);

        return redirect()->route('class.dash')->with(
            'success', 'Success, Classification Added!'
        );
    }
}
