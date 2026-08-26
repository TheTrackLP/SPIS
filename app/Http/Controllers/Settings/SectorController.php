<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectorController extends Controller
{
    public function SectorDashboard(){
        return inertia('Backend/Settings/Sector', [
            'sectors'=>Sector::all(),
        ]);
    }

    public function SectorAdd(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('sector.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        Sector::create([
            'name' => $request->name,
            'desc' => $request->name,
        ]);
        return redirect()->route('sector.dash')->with(
            'success', 'Success, Sector Added',
        );
    }

    public function SectorEdit(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('sector.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        Sector::findorfail($request->id)->update([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);
        return redirect()->route('sector.dash')->with(
            'success', 'Success, Sector Updated',
        );
    }
}
