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
        ]);

        if($valid->fails()){
            return redirect()->route('term.dash')->with(
                'error', "Error, Try Again!",
            );
        }

        Terms::create([
            'sptermno' => 'SP-'.$request->sptermno,
            'termfrom' => $request->termfrom,
            'termto' => $request->termto,
        ]);

        return redirect()->route('term.dash')->with(
            'success', "Success, SP Term Period Added!",
        );
    }
}
