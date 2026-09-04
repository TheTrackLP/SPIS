<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\MainClassifications;
use App\Models\Records;
use App\Models\Sector;
use App\Models\SubClassifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function ReportsDashboard(){
        $recordsCount = Records::select('authorid', 'coauthorid', 'term')->get(); //Get every authorid string from the table

        $authorIds = $recordsCount
            ->flatMap(fn ($recordsCount) => explode('/', $recordsCount->authorid)) //Break every string into individual IDs, and merge them all into one big list
            ->map(fn ($id) => (int) trim($id)) // Convert every ID from string to integer
            ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
            ->unique() // This Remove duplicates
            ->values(); // Reset Index

        $coAuthorIds = $recordsCount
            ->flatMap(fn ($recordsCount) => explode('/', $recordsCount->coauthorid))
            ->map(fn ($id) => (int) trim($id)) // trim whitespace just in case
            ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
            ->unique() 
            ->values(); 

        //Make an empty array to push and display later on
        $authorCounts = [];

        //Loop through each unique author, and count their records
        foreach ($authorIds as $id) {
            $count = Records::whereRaw(
                "CONCAT('/', authorid, '/') LIKE ?",
                ["%/{$id}/%"]
            )->count();

        $author = Authors::find($id);
        
        //Push Data into an empty Array
        $authorCounts[] = [
            'id' => $id,
            'authorhead' => $author->authorhead ?? 'Unknown',
            'count' => $count,
            ];
        }
        $coAuthorCounts = [];

        foreach ($coAuthorIds as $id) {
            $count = Records::whereRaw(
                "CONCAT('/', coauthorid, '/') LIKE ?",
                ["%/{$id}/%"]
            )->count();

        $coauthor = Authors::find($id);
        
        $coAuthorCounts[] = [
            'id' => $id,
            'coauthorhead' => $coauthor->authorhead ?? 'Unknown',
            'count' => $count,
            ];
        }
        return inertia('Backend/Reports', [
            'mainAuthRecCount'=>$authorCounts,
            'CoAuthRecCount'=>$coAuthorCounts,
            'authors'=>Authors::all(),
            'mainClass'=>MainClassifications::all(),
            'subClass'=>SubClassifications::all(),
            'sectors'=>Sector::all(),
        ]);
    }

    public function FilterReport(Request $request) {
        
        $query = Records::query();

        if($request->filled('term')){
            $query->where('term', $request->term);
        }

        if($request->filled('type')){
            $query->where('type', $request->type);
        }

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        if($request->filled('sessionfrom')){
            $query->whereDate('session_date', '>=' ,$request->sessionfrom);
        }

        if($request->filled('sessionto')){
            $query->whereDate('session_date', '<=' ,$request->sessionto);
        }

        if($request->filled('authorid')){
            $query->whereRaw(
                "CONCAT('/', authorid, '/') LIKE ?",
                ["%/{$request->authorid}/%"]
            );        
        }

        if($request->filled('coauthorid')){
            $query->whereRaw(
                "CONCAT('/', coauthorid, '/') LIKE ?",
                ["%/{$request->coauthorid}/%"]
            );        
        }

        if($request->filled('sectorid')){
            $query->whereRaw(
                "CONCAT('/', sectorid, '/') LIKE ?",
                ["%/{$request->sectorid}/%"]
            );        
        }

        if($request->filled('mainclassid')){
            $query->whereRaw(
                "CONCAT('/', mainclassid, '/') LIKE ?",
                ["%/{$request->mainclassid}/%"]
            );        
        }

        if($request->filled('subclassid')){
            $query->whereRaw(
                "CONCAT('/', subclassid, '/') LIKE ?",
                ["%/{$request->subclassid}/%"]
            );        
        }

        $filteredRecords = $query->get();

        return inertia('Backend/Filters', [
            'records' => $filteredRecords,
            'filters' => $request->only([
                'authorid', 'coauthorid', 'term', 'status', 'sector',
                'mainclassid', 'subclassid', 'sessionfrom', 'sessionto'
            ]),
        ]);
    }
}
