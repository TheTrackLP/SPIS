<?php

namespace App\Http\Controllers;

use App\Models\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypesController extends Controller
{
    public function TypesDashboard(){
        return inertia('Backend/Settings/Types', [
            'types'=>Types::all(),
        ]);
    }

    public function TypesStore(Request $request){
        $valid = Validator::make($request->all(), [
            'type_name' => 'required',
            'type_desc' => 'required',
        ],
        [
            'type_name' => 'Type name is required',
            'type_desc' => 'Type description is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Types::create([
            'type_name' => $request->type_name,
            'type_desc' => $request->type_desc,
        ]);

        return $this->StatusMessage(true, 'Success, Type Added!', 'types.dash');
    }

    public function TypesUpdate(Request $request){
        $valid = Validator::make($request->all(), [
            'type_name' => 'required',
            'type_desc' => 'required',
        ],
        [
            'type_name' => 'Type name is required',
            'type_desc' => 'Type description is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Types::findorfail($request->id)->update([
            'type_name' => $request->type_name,
            'type_desc' => $request->type_desc,
        ]);

        return $this->StatusMessage(true, 'Success, Type Updated', 'types.dash');
    }
}
