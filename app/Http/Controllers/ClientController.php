<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use DB;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get clients :
        $clients = Client::orderBy('created_at','desc')->paginate(5);

        //Return collection of clients as a resource : (bcz API)
        return ClientResource::collection($clients);    //collection bcz it's a list
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
        //put is for updating :
        //else : post is for creating a new client :
        $client = $request->isMethod("put") ? Client::where('nom_entreprise', $request->nom_entreprise)->first() : new Client;

        $client->nom_entreprise = $request->input('nom_entreprise');
        $client->adresse = $request->input('adresse');
        $client->ville = $request->input('ville');
        $client->num_compte_bancaire = $request->input('num_compte_bancaire');
        $client->RC = $request->input('RC');
        $client->ICE = $request->input('ICE');
        $client->category = $request->input('category');

        if($client->save()){
            return new ClientResource($client);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param string $nom_entreprise
     * @return \Illuminate\Http\Response
     */
    public function show($nom_entreprise)
    {
        //Get a single client :
        $client = Client::where('nom_entreprise', $nom_entreprise)->first();

        //Return a single article as resource
        return new ClientResource($client);
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
     * @param  string  $nom_entreprise
     * @return \Illuminate\Http\Response
     */
    public function destroy($nom_entreprise)
    {
         $client = Client::where('nom_entreprise', $nom_entreprise)->first();

         if($client->delete()){
            return new ClientResource($client);
         }


    }
}
