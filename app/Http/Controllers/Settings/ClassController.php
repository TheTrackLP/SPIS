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
        ],
        [
            'mainname' => 'Main Classification is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        MainClassifications::create([
            'mainname' => $request->mainname,
        ]);

        return $this->StatusMessage(true, 'Success, Main Classification Added!', 'class.dash');
    }

    public function ClassEdit(Request $request){
        $valid = Validator::make($request->all(), [
            'mainname' => 'required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        MainClassifications::findorfail($request->id)->update([
            'mainname' => $request->mainname,
        ]);

        return $this->StatusMessage(true, 'Success, Main Classification Updated!', 'class.dash');
    }

    public function SubClassificationAdd(Request $request) {
        $valid = Validator::make($request->all(),[
            'class_id' => 'required',
            'subname' => 'required',
        ],
        [
            'subname' => 'Sub Classification is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        SubClassifications::create([
            'class_id' => $request->class_id,
            'subname' => $request->subname,
            'desc' => $request->desc,
        ]);
    
        return $this->StatusMessage(true, 'Sub Classification Added!', 'class.dash');
    }

    public function SubClassificationEdit(Request $request) {
        $valid = Validator::make($request->all(),[
            'class_id' => 'required',
            'subname' => 'required',
        ],
        [
            'subname' => 'Sub Classification is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        SubClassifications::findorfail($request->id)->update([
            'class_id' => $request->class_id,
            'subname' => $request->subname,
            'desc' => $request->desc,
        ]);
    
        return $this->StatusMessage(true, 'Sub Classification Updated!', 'class.dash');
    }
}
