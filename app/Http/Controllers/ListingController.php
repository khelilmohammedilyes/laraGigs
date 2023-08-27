<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //get all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);
    }

    //get specific listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //create listing form
    public function create(){
        return view('listings.create');
    }

    //store listing
    public function store(Request $request){
        $validation=$request->validate([
            'title'=>'required',
            'company'=>['required',Rule::unique('listings','company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if($request->hasFile('logo')){
            $validation['logo']=$request->file('logo')->store('public/images');
        }
        $validation['user_id']=auth()->id();
        Listing::create($validation);
        return redirect('/')->with('message','listing created succesfully!');
    }

    //show edit form
    public function edit(Listing $listing){
        return view('listings.edit',['listing'=>$listing]);
    }

    //update listing
    public function update(Request $request,Listing $listing){
        //make sure logged in user is the owner
        if($listing->user_id!=auth()->id()){
            abort(403,'unauthorized action');
        }
        $validation=$request->validate([
            'title'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if($request->hasFile('logo')){
            $validation['logo']=$request->file('logo')->store('logos','public');
        }
        $listing->update($validation);
        return back()->with('message','listing updated succesfully!');
    }

    //delete listing
    public function delete(Listing $listing){
        //make sure logged in user is the owner
        if($listing->user_id!=auth()->id()){
            abort(403,'unauthorized action');
        }
        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully');
    }

    //manage listings
    public function manage(){
        return view('listings.manage',['user' => auth()->user()]);
    }
}
