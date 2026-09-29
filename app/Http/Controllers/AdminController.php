<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Records;
use App\Models\Sector;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function AdminDashboard(){
        $recordsCount = Records::select('authorid', 'coauthorid', 'sptermid', 'sectorid')->get(); //Get every authorid string from the table

        $authorIds = $recordsCount
            ->flatMap(fn ($recordsCount) => explode('/', $recordsCount->authorid)) //Break every string into individual IDs, and merge them all into one big list
            ->map(fn ($id) => (int) trim($id)) // Convert every ID from string to integer
            ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
            ->unique() // This Remove duplicates
            ->values(); // Reset Index
        
        $sectorIds = $recordsCount
            ->flatmap(fn ($recordsCount) => explode('/', $recordsCount->sectorid))
            ->map(fn ($id) => (int) trim($id))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        $coAuthorsIds = $recordsCount
            ->flatmap(fn ($recordsCount) => explode('/', $recordsCount->coauthorid))
            ->map(fn ($id) => (int) trim($id))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        //Make an empty array to push and display later on
        $authorCounts = [];
        $sectorsCounts = [];
        $coAuthorCounts = [];

        //Loop through each unique author, and count their records
        foreach ($authorIds as $id) {
            $count = Records::whereRaw(
                "CONCAT('/', authorid, '/') LIKE ?",
                ["%/{$id}/%"]
            )->count();

        $author = Authors::select(
            DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
        )->
        find($id);
        
        //Push Data into an empty Array
        $authorCounts[] = [
            'id' => $id,
            'fullname' => $author->fullname ?? 'Unknown',
            'count' => $count,
            ];
        }

        foreach ($sectorIds as $id) {
            $count = Records::whereRaw(
                "CONCAT('/', sectorid, '/') LIKE ?",
                ["%/{$id}/%"]
            )->count();

        $sector = Sector::find($id);
        
        //Push Data into an empty Array
        $sectorsCounts[] = [
            'id' => $id,
            'name' => $sector->name ?? 'Unknown',
            'count' => $count,
            ];
        }
        
        foreach ($coAuthorsIds as $id) {
            $count = Records::whereRaw(
                "CONCAT('/', coauthorid, '/') LIKE ?",
                ["%/{$id}/%"]
            )->count();

        $coAuthor = Authors::select(
            DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
        )->find($id);
        
        //Push Data into an empty Array
        $coAuthorCounts[] = [
            'id' => $id,
            'fullname' => $coAuthor->fullname ?? 'Unknown',
            'count' => $count,
            ];
        }
        return inertia('Admin/Dashboard', [
            'mainAuthorCount'=>$authorCounts,
            'coAuthorCount'=>$coAuthorCounts,
            'sectorCount'=>$sectorsCounts,
            'totalRecords'=>Records::count(),
            'activeAuthors'=>Authors::where('authorstatus', 1)->count(),
            'latestRecords' => Records::orderby('resono', 'desc')->limit(20)->get(),
            'terms'=>Terms::all(),
        ]);
    }
}
