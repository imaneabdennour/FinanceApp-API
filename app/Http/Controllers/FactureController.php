<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Facture;
use App\Http\Resources\Facture as FactureResource;
use DB;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get factures :
        $factures = Facture::paginate(15);

        return FactureResource::collection($factures);    //collection bcz it's a list

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
        //else : post is for creating a new facture :
            $facture = $request->isMethod("put") ? Facture::where('num_commande', $request->num_commande)->first() : new Facture;

            $facture->num_commande = $request->input('num_commande');
            $facture->num_facture = $request->input('num_facture');
            $facture->client = $request->input('client');
            $facture->proforma = $request->input('proforma');
            $facture->condition = $request->input('condition');
            $facture->navire = $request->input('navire');
            $facture->statut = $request->input('statut');
            $facture->date = $request->input('date');
            $facture->nature = $request->input('nature');

            if($facture->save()){
                return new FactureResource($facture);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $num_commande
     * @return \Illuminate\Http\Response
     */
    public function show($num_commande)
    {
         //Get a single client :
         $facture = Facture::where('num_commande', $num_commande)->first();

         //Return a single article as resource
         return new FactureResource($facture);
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
     * @param  int  $num_commande
     * @return \Illuminate\Http\Response
     */
    public function destroy($num_commande)
    {
        //works
        $facture = Facture::where('num_commande', $num_commande)->first();

        if($facture->delete()){
            return new FactureResource($facture);
        }

    }
}
