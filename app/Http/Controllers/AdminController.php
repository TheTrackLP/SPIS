<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Records;
use App\Models\Sector;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function AdminDashboard(){
        $recordsCount = Records::select('authorid', 'coauthorid', 'sptermid', 'sectorid')->get(); //Get every authorid string from the table

        $recordsByTerm = $recordsCount->groupBy('sptermid');

        //Make an empty array to push and display later on
        $authorCounts = [];
        $sectorsCounts = [];
        $coAuthorCounts = [];

        foreach ($recordsByTerm as $spTermId => $termRecords) {
            $authorIds = $termRecords
                ->flatMap(fn ($records) => explode('/', $records->authorid)) //Break every string into individual IDs, and merge them all into one big list
                ->map(fn ($id) => (int) trim($id)) // Convert every ID from string to integer
                ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
                ->unique() // This Remove duplicates
                ->values(); // Reset Index

            foreach ($authorIds as $id) {
                $count = $termRecords->filter(function ($record) use ($id){
                    return in_array((string) $id, explode('/', $record->authorid));
                })->count();
                
                $author = Authors::select(
                    DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                )->
                find($id);
            
                //Push Data into an empty Array
                $authorCounts[] = [
                    'id' => $id,
                    'fullname' => $author->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $spTermId,
                    ];
            }

            $coAuthorsIds = $termRecords
                ->flatmap(fn ($records) => explode('/', $records->coauthorid))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();
            foreach ($coAuthorsIds as $id) {
                $count = $termRecords->filter(function ($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->coauthorid));
                })->count();

                $coAuthor = Authors::select(
                    DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                )->find($id);
                
                //Push Data into an empty Array
                $coAuthorCounts[] = [
                    'id' => $id,
                    'fullname' => $coAuthor->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $spTermId,
                    ];
            }

            $sectorIds = $recordsCount
                ->flatmap(fn ($recordsCount) => explode('/', $recordsCount->sectorid))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();

            foreach ($sectorIds as $id) {
                $count = $termRecords->filter(function($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->sectorid));
                })->count();

                $sector = Sector::find($id);
                
                $sectorsCounts[] = [
                    'id' => $id,
                    'name' => $sector->name ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $spTermId,
                    ];
            }
        }

        
        
        return inertia('Admin/Dashboard', [
            'mainAuthorCount'=>$authorCounts,
            'coAuthorCount'=>$coAuthorCounts,
            'sectorCount'=>$sectorsCounts,
            'totalRecords'=>Records::count(),
            'activeAuthors'=>Authors::where('authorstatus', 1)->count(),
            'latestRecords' => Records::latest()->limit(20)->get(),
            'terms'=>Terms::all(),
        ]);
    }

    public function AuthLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
