<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Navire;
use App\Http\Resources\Navire as NavireResource;

class NavireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Get navires :
         $navires = Navire::orderBy('created_at','desc')->paginate(5);

         return NavireResource::collection($navires);    //collection bcz it's a list

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
        $navire = $request->isMethod("put") ? Navire::where('nom_navire', $request->nom_navire)->first() : new Navire;

        $navire->nom_navire = $request->input('nom_navire');
        $navire->statut = $request->input('statut');

        if($navire->save()){
            return new NavireResource($navire);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nom_navire
     * @return \Illuminate\Http\Response
     */
    public function show($nom_navire)
    {
         //Get a single navire :
         $navire = Navire::where('nom_navire', $nom_navire)->first();


         //Return a single article as resource
         return new NavireResource($navire);
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
     * @param  string  $nom_navire
     * @return \Illuminate\Http\Response
     */
    public function destroy($nom_navire)
    {
        //Cannot delete or update a parent row: a foreign key constraint fails
        $navire = Navire::where('nom_navire', $nom_navire)->first();

        if($navire->delete()){
           return new NavireResource($navire);
        }

    }
}
