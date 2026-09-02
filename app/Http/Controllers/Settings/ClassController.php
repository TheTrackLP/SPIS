<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use App\Models\MainClassifications;
use App\Models\SubClassifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function ClassDashboard(){
        return inertia('Backend/Settings/Classification', [
            'classification'=>MainClassifications::all(),
            'subClassification'=>SubClassifications::all(),
            'subCount' => SubClassifications::select('class_id', DB::raw('count(*) as count'))
                ->groupBy('class_id')
                ->get(),        
            ]);
    }

    public function ClassAdd(Request $request){
        $valid = Validator::make($request->all(), [
            'mainname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('class.dash')->with(
                'error', 'Error, Try Again!'
            );
        }

        MainClassifications::create([
            'mainname' => $request->mainname,
        ]);

        return redirect()->route('class.dash')->with(
            'success', 'Success, Main Classification Added!'
        );
    }

    public function ClassEdit(Request $request){
        $valid = Validator::make($request->all(), [
            'mainname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('class.dash')->with(
                'error', 'Error, Try Again!'
            );
        }

        MainClassifications::findorfail($request->id)->update([
            'mainname' => $request->mainname,
        ]);

        return redirect()->route('class.dash')->with(
            'success', 'Success, Main Classification Updated!'
        );
    }

    public function SubClassificationAdd(Request $request) {
        $valid = Validator::make($request->all(),[
            'class_id' => 'required',
            'subname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('class.dash')->with(
                'error', 'Try Again!',
            );
        }

        SubClassifications::create([
            'class_id' => $request->class_id,
            'subname' => $request->subname,
            'desc' => $request->desc,
        ]);
    
        return redirect()->route('class.dash')->with(
            'success', 'Success, Sub Classification Added!',
        );
    }

    public function SubClassificationEdit(Request $request) {
        $valid = Validator::make($request->all(),[
            'class_id' => 'required',
            'subname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('class.dash')->with(
                'error', 'Try Again!',
            );
        }

        SubClassifications::findorfail($request->id)->update([
            'class_id' => $request->class_id,
            'subname' => $request->subname,
            'desc' => $request->desc,
        ]);
    
        return redirect()->route('class.dash')->with(
            'success', 'Success, Sub Classification Updated!',
        );   
    }
}
