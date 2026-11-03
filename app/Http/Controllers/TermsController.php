<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermsController extends Controller
{
    public function TermsDashboard() {
        return inertia('Backend/Settings/Terms', [
            'terms'=>Terms::all(),
        ]); 
    }

    public function StoreTermPeriod(Request $request){
        $valid = Validator::make($request->all(), [
            'sptermno' => 'required',
            'termfrom' => 'required',
            'termto' => 'required',
        ],
        [
            'sptermno' => 'SP Term is required',
            'termfrom' => 'From date is required',
            'termto' => 'To date is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Terms::create([
            'sptermno' => 'SP-'.$request->sptermno,
            'termfrom' => $request->termfrom,
            'termto' => $request->termto,
        ]);

        return $this->StatusMessage(true, 'Success, SP Term Period Added!', 'term.dash');
    }

    public function UpdateTermPeriod(Request $request){
        $valid = Validator::make($request->all(), [
            'sptermno' => 'required',
            'termfrom' => 'required',
            'termto' => 'required',
        ],
        [
            'sptermno' => 'SP Term is required',
            'termfrom' => 'From date is required',
            'termto' => 'To date is required',
        ]);

        if($valid->fails()){
            return $this->failedValidation($valid);
        }

        Terms::findorfail($request->id)->update([
            'sptermno' => 'SP-'.$request->sptermno,
            'termfrom' => $request->termfrom,
            'termto' => $request->termto,
        ]);

        return $this->StatusMessage(true, 'Success, SP Term Period Updated!', 'term.dash');
    }
}
