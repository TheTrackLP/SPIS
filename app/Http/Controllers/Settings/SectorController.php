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
        ],
        [
            'name' => 'Sector name is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Sector::create([
            'name' => $request->name,
            'desc' => $request->name,
        ]);
        return $this->StatusMessage(true, 'Success, Sector Added', 'sector.dash');
    }

    public function SectorEdit(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
        ],
        [
            'name' => 'Sector name is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Sector::findorfail($request->id)->update([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);
        return $this->StatusMessage(true, 'Success, Sector Updated', 'sector.dash');
    }
}
