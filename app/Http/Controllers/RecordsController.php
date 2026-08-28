<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Classification;
use App\Models\Records;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecordsController extends Controller
{
    public function RecordDashboard(){
        return inertia('Backend/Records',[
            'sectors'=>Sector::all(),
            'authors'=>Authors::all(),
            'class1'=>Classification::select('*')->where('class', 'class1')->orderby('name')->get(),
            'class2'=>Classification::select('*')->where('class', 'class2')->orderby('name')->get(),
            'records'=>Records::select('*')->orderby('resono')->get(),
        ]);
    }

    public function RecordAdd(Request $request){
        $valid = Validator::make($request->all(), [
            'term' => 'required',
            'type' => 'required',
            'resono' => 'required',
            'session_date' => 'required',
            'title' => 'required',
            'authorid' => 'required',
            'authorname' => 'required',
            'authoracronym' => 'required',
            'class1id' => 'required',
            'class1name' => 'required',
            'class2id' => 'required',
            'class2name' => 'required',
            'sectorid' => 'required',
            'sectorname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('rec.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        Records::create([
            'term' => $request->term,
            'type' => $request->type,
            'resono' => $request->resono,
            'session_date' => $request->session_date,
            'title' => $request->title,
            'status' => $request->status,
            'authorid' => $request->authorid,
            'authorname' => $request->authorname,
            'authoracronym' => $request->authoracronym,
            'coauthorid' => $request->coauthorid,
            'coauthorname' => $request->coauthorname,
            'coauthoracronym' => $request->coauthoracronym,
            'class1id' => $request->class1id,
            'class1name' => $request->class1name,
            'class2id' => $request->class2id,
            'class2name' => $request->class2name,
            'sectorid' => $request->sectorid,
            'sectorname' => $request->sectorname,
        ]);

        return redirect()->route('rec.dash')->with(
            'success', 'Success, Record Added',
        );
    }
}
