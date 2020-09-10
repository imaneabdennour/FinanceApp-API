<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Gerant;
use App\Http\Resources\Gerant as GerantResource;

class GerantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Get gerants :
         $gerants = Gerant::orderBy('created_at','desc')->paginate(5);

         return GerantResource::collection($gerants);    //collection bcz it's a list

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gerant = $request->isMethod("put") ? Gerant::where('id', $request->id)->first() : new Gerant;

        $gerant->civilité = $request->input('civilité');
        $gerant->nom_complet = $request->input('nom_complet');
        $gerant->email = $request->input('email');
        $gerant->telef = $request->input('telef');
        $gerant->entreprise = $request->input('entreprise');


        if($gerant->save()){
            return new GerantResource($gerant);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         //Get a single gerant :
         $gerant = Gerant::findOrFail($id);

         //Return a single article as resource
         return new GerantResource($gerant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //works
        $gerant = Gerant::findOrFail($id);

        if($gerant->delete()){
            return new GerantResource($gerant);

        }
    }
}
