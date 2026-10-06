<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Classification;
use App\Models\MainClassifications;
use App\Models\Records;
use App\Models\Sector;
use App\Models\SubClassifications;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecordsController extends Controller
{
    public function RecordDashboard(){
        return inertia('Backend/Records',[
            'sectors'=>Sector::all(),
            'authors'=>Authors::select(
                '*',
                DB::raw("CONCAT(authorlastname, ', ', authorfirstname, ' ', authormiddlename) as fullname"),
            )
            ->where('authorstatus', 1)
            ->get(),
            'mainClass'=>MainClassifications::all(),
            'subClass'=>SubClassifications::all(),
            'terms'=>Terms::all(),
            'records'=>Records::select(
                'records.*',
                'terms.sptermno'
                )
                ->leftjoin('terms', 'terms.id', '=', 'records.sptermid')
                ->latest()->get(),
        ]);
    }

    public function RecordAdd(Request $request){
        $valid = Validator::make($request->all(), [
            'sptermid' => 'required',
            'type' => 'required',
            'resono' => 'required',
            'session_date' => 'required',
            'title' => 'required',
            'authorid' => 'required',
            'authorname' => 'required',
            'mainclassid' => 'required',
            'mainclassname' => 'required',
            'sectorid' => 'required',
            'sectorname' => 'required',
            'filepath' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:20480'],
        ]);

        if($valid->fails()){
            return redirect()->route('rec.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        $year = date('Y', strtotime($request->session_date));
        $file = $request->file('filepath');

        $filename = Str::slug($year.' '.$request->resono).'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs('scanned', $filename, 'documents');

        Records::create([
            'sptermid' => $request->sptermid,
            'type' => $request->type,
            'resono' => $request->resono,
            'session_date' => $request->session_date,
            'title' => $request->title,
            'status' => $request->status,
            'authorid' => $request->authorid,
            'authorname' => $request->authorname,
            'coauthorid' => $request->coauthorid,
            'coauthorname' => $request->coauthorname,
            'sponsorid' => $request->sponsorid,
            'sponsorname' => $request->sponsorname,
            'cosponsorid' => $request->cosponsorid,
            'cosponsorname' => $request->cosponsorname,
            'mainclassid' => $request->mainclassid,
            'mainclassname' => $request->mainclassname,
            'subclassid' => $request->subclassid,
            'subclassname' => $request->subclassname,
            'sectorid' => $request->sectorid,
            'sectorname' => $request->sectorname,
            'filepath' => $path,
        ]);

        return redirect()->route('rec.dash')->with(
            'success', 'Success, Record Added',
        );
    } 

    public function RecordEdit(Request $request){
        $valid = Validator::make($request->all(), [
            'sptermid' => 'required',
            'type' => 'required',
            'resono' => 'required',
            'session_date' => 'required',
            'title' => 'required',
            'authorid' => 'required',
            'authorname' => 'required',
            'mainclassid' => 'required',
            'mainclassname' => 'required',
            'sectorid' => 'required',
            'sectorname' => 'required',
        ]);

        if($valid->fails()){
            return redirect()->route('rec.dash')->with(
                'error', 'Error, Try Again!',
            );
        }

        $record = Records::findorfail($request->id);

        $data = [
            'sptermid' => $request->sptermid,
            'type' => $request->type,
            'resono' => $request->resono,
            'session_date' => $request->session_date,
            'title' => $request->title,
            'status' => $request->status,
            'authorid' => $request->authorid,
            'authorname' => $request->authorname,
            'coauthorid' => $request->coauthorid,
            'coauthorname' => $request->coauthorname,
            'sponsorid' => $request->sponsorid,
            'sponsorname' => $request->sponsorname,
            'cosponsorid' => $request->cosponsorid,
            'cosponsorname' => $request->cosponsorname,
            'mainclassid' => $request->mainclassid,
            'mainclassname' => $request->mainclassname,
            'subclassid' => $request->subclassid,
            'subclassname' => $request->subclassname,
            'sectorid' => $request->sectorid,
            'sectorname' => $request->sectorname,
        ];

        if ($request->hasFile('filepath')) {
            $file = $request->file('filepath');
            $year = date('Y', strtotime($request->session_date));
            $filename = Str::slug($year.' '.$request->resono).'.'.$file->getClientOriginalExtension();

            if ($record->filepath) {
                Storage::disk('documents')->delete($record->filepath);
            }

            $data['filepath'] = $file->storeAs('scanned', $filename, 'documents');
        }
        
        $record->update($data);
        return redirect()->route('rec.dash')->with(
            'success', 'Success, Record Updated',
        );
    }

    public function previewRecordFile(Records $record){
        $disk = Storage::disk('documents');

        abort_unless($disk->exists($record->filepath), 404);

        return $disk->response($record->filepath);
    }
}
