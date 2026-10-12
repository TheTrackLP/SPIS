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
        ]);

        if($valid->fails()){
            return redirect()->route('types.dash')->with(
                'error', 'Error Try Again!',
            );
        }

        Types::create([
            'type_name' => $request->type_name,
            'type_desc' => $request->type_desc,
        ]);

        return redirect()->route('types.dash')->with(
            'success', 'Success, Type Added!',
        );
    }

    public function TypesUpdate(Request $request){
        $valid = Validator::make($request->all(), [
            'type_name' => 'required',
            'type_desc' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('types.dash')->with(
                'error', 'Error Try Again!',
            );
        }

        Types::findorfail($request->id)->update([
            'type_name' => $request->type_name,
            'type_desc' => $request->type_desc,
        ]);

        return redirect()->route('types.dash')->with(
            'success', 'Success, Type Updated!',
        );
    }
}
