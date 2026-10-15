<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\MainClassifications;
use App\Models\Records;
use App\Models\Sector;
use App\Models\SubClassifications;
use App\Models\Terms;
use App\Models\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function ReportsDashboard(){
        //Here is the second method. The first part is on the Admin Controller Dashboard.
        
        $recordsCount = Records::select('authorid', 'coauthorid', 'sponsorid', 'cosponsorid', 'sptermid')->get(); //Get every authorid string from the table

        $terms = Terms::all()->keyBy('id');

        $recordsByTerm = $recordsCount->groupBy('sptermid');

        //Make an empty array to push and display later on
        $authorCounts = [];
        $coAuthorCounts = [];
        $SponsorCounts = [];
        $coSponsorCounts = [];

        //Loop through each unique author, and count their records
        foreach ($recordsByTerm as $spTermId => $termsRecords) {
            $authorIds = $termsRecords
            ->flatMap(fn ($records) => explode('/', $records->authorid)) //Break every string into individual IDs, and merge them all into one big list
            ->map(fn ($id) => (int) trim($id)) // Convert every ID from string to integer
            ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
            ->unique() // This Remove duplicates
            ->values(); // Reset Index


            foreach ($authorIds as $id) {
                $count = $termsRecords->filter(function ($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->authorid));
                })->count();

                $author = Authors::select(
                    DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                )->find($id);
                
                //Push Data into an empty Array
                $authorCounts[] = [
                    'id' => $id,
                    'fullname' => $author->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $terms[$spTermId]->sptermno ?? 'Unknown',
                    'sptermid' => $spTermId,
                ];
            }

            $coAuthorIds = $termsRecords
                ->flatMap(fn ($records) => explode('/', $records->coauthorid))
                ->map(fn ($id) => (int) trim($id)) // trim whitespace just in case
                ->filter(fn ($id) => $id > 0) // drop 0s and negatives — invalid IDs
                ->unique() 
                ->values(); 

            foreach ($coAuthorIds as $id) {
                $count = $termsRecords->filter(function ($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->coauthorid));
                    })->count();

                $coauthor = Authors::select(
                    DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                )->find($id);
            
                $coAuthorCounts[] = [
                    'id' => $id,
                    'fullname' => $coauthor->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $terms[$spTermId]->sptermno ?? 'Unknown',
                    'sptermid' => $spTermId,
                ];
            }

            $sponsorIds = $termsRecords
                ->flatMap(fn ($records) => explode('/', $records->sponsorid))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();
            
            foreach ($sponsorIds as $id) {
                $count = $termsRecords->filter(function ($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->sponsorid));
                })->count();

                $sponsor = Authors::select(
                            DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                    )->find($id);

                $SponsorCounts[] = [
                    'id' => $id,
                    'fullname' => $sponsor->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $terms[$spTermId]->sptermno ?? 'Unknown',
                    'sptermid' => $spTermId,
                ];
            }

            $coSponsorIds = $termsRecords
                ->flatMap(fn ($records) => explode('/', $records->cosponsorid))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();
            
            foreach ($coSponsorIds as $id) {
                $count = $termsRecords->filter(function ($record) use ($id) {
                    return in_array((string) $id, explode('/', $record->cosponsorid));
                })->count();

                $coSponsor = Authors::select(
                    DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
                )->find($id);

                $coSponsorCounts[] = [
                    'id' => $id,
                    'fullname' => $coSponsor->fullname ?? 'Unknown',
                    'count' => $count,
                    'spterm' => $terms[$spTermId]->sptermno ?? 'Unknown',
                    'sptermid' => $spTermId,
                ];
            }
        }


        return inertia('Backend/Reports', [
            'mainAuthRecCount'=>$authorCounts,
            'CoAuthRecCount'=>$coAuthorCounts,
            'sponsorRecCounts'=>$SponsorCounts,
            'coSponsorRecCounts'=>$coSponsorCounts,
            'authors'=>Authors::select(
                '*',
                DB::raw('CONCAT(authorlastname, ", ", authorfirstname, " ", authormiddlename) as fullname')
            )->get(),
            'mainClass'=>MainClassifications::all(),
            'subClass'=>SubClassifications::all(),
            'sectors'=>Sector::all(),
            'terms'=>Terms::all(),
            'types'=>Types::all(),
        ]);
    }

    public function FilterReport(Request $request) {
        
        $query = Records::query()
        ->leftJoin('terms', 'terms.id', '=', 'records.sptermid')
        ->leftJoin('types', 'types.id', '=', 'records.type_id');

        if($request->filled('sptermid')){
            $query->where('sptermid', $request->sptermid);
        }

        if($request->filled('type_id')){
            $query->where('type_id', $request->type_id);
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

        if($request->filled('sponsorid')){
            $query->whereRaw(
                "CONCAT('/', sponsorid, '/') LIKE ?",
                ["%/{$request->sponsorid}/%"]
            );        
        }

        if($request->filled('cosponsorid')){
            $query->whereRaw(
                "CONCAT('/', cosponsorid, '/') LIKE ?",
                ["%/{$request->cosponsorid}/%"]
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
                'authorid', 'coauthorid', 'sponsorid', 'cosponsorid', 'term', 'status', 'sector',
                'mainclassid', 'subclassid', 'sessionfrom', 'sessionto'
            ]),
        ]);
    }
}
