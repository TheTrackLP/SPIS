<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use App\Models\AuthorTerms;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function SettingAuthor(){
        return inertia('Backend/Settings/Authors', [
            'authors' => Authors::select(
                'authors.id',
                'authors.authorbirtdate',
                'authors.authorstatus',
                'authors.authorcurrentterm',
                'terms.sptermno',
                DB::raw("CONCAT(authorlastname, ', ', authorfirstname, ' ', authormiddlename) as fullname"),
            )
            ->leftJoin('terms', 'terms.id', '=', 'authors.authorcurrentterm')
            ->get(),
            'terms'=>Terms::all(),
        ]);
    }

    public function AddAuthor(Request $request){
        $valid = Validator::make($request->all(), [
            'authorfirstname' => "required",
            'authormiddlename' => "required",
            'authorlastname' => "required",
        ]);

        if($valid->fails()){
            return redirect()->route('gear.author')->with(
                'error', 'Error, Try Again!'
            );
        }

        Authors::create([
            'authorfirstname' => strtoupper($request->authorfirstname),
            'authormiddlename' => strtoupper($request->authormiddlename),
            'authorlastname' => strtoupper($request->authorlastname),
            'authorbirtdate' => $request->authorbirtdate,
        ]);

        return redirect()->route('gear.author')->with(
            'success', 'Success, Author Added',
        );
    }
    public function EditAuthor(Request $request){
        $valid = Validator::make($request->all(), [
            'authorhead' => "required",
            'authordesc' => "required",
            'authoroffice' => "required",
            'authoracronym' => "required",
            'authorposition' => "required",
            'authorterm' => "required",
        ]);

        if($valid->fails()){
            return redirect()->route('gear.author')->with(
                'error', 'Error, Try Again!'
            );
        }

        Authors::findorfail($request->id)->update([
            'authorhead' => strtoupper($request->authorhead),
            'authordesc' => $request->authordesc,
            'authoroffice' => $request->authoroffice,
            'authoracronym' => $request->authoracronym,
            'authorposition' => $request->authorposition,
            'authorterm' => $request->authorterm,
        ]);

        return redirect()->route('gear.author')->with(
            'success', 'Success, Author Updated',
        );
    }

    public function AuthorTerms($id){
        $authorTerms = AuthorTerms::select(
            'author_terms.id',
            'author_terms.authorid',
            'author_terms.authorposition',
            'author_terms.authortermno',
            'author_terms.remarks',
            'terms.termfrom',
            'terms.termto',
            'terms.sptermno',
                DB::raw("CONCAT(authors.authorlastname, ', ', authors.authorfirstname, ' ', authors.authormiddlename) as fullname"),
            )
            ->join('terms', 'terms.id', '=', 'author_terms.authortermid')
            ->join('authors', 'authors.id', '=', 'author_terms.authorid')
            ->where('author_terms.authorid', $id)
            
            ->get();
        return response()->json($authorTerms);
    }

    public function AddAuthorTerms(Request $request){
        $valid = validator::make($request->all(),[
            'authortermid' => "required",
            'authortermno' => "required",
            'authorposition' => "required",
        ]);

        if($valid->fails()){
            return redirect()->route('gear.author')->with(
                'error', 'Error, Try Again!',
            );
        }

        $currTerm = Authors::findorfail($request->id);

        $currTerm->update([
            'authorcurrentterm' => $request->authortermid
        ]);

        AuthorTerms::create([
            'authorid' => $request->id,
            'authortermid' => $request->authortermid,
            'authortermno' => $request->authortermno,
            'authorposition' => $request->authorposition,
            'remarks' => $request->remarks,
        ]);
        return redirect()->route('gear.author')->with(
            'success', 'Success, SP Term Added!',
        );
    }
}
