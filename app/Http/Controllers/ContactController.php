<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Contact;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    public function index()
    {
         //Get contacts :
         $contacts = Contact::orderBy('created_at','desc')->paginate(5);

         return ContactResource::collection($contacts);    //collection bcz it's a list

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
        $contact = $request->isMethod("put") ? Contact::where('id', $request->id)->first() : new Contact;

        $contact->civilité = $request->input('civilité');
        $contact->nom_complet = $request->input('nom_complet');
        $contact->email = $request->input('email');
        $contact->telef = $request->input('telef');


        if($contact->save()){
            return new ContactResource($contact);
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
         $contact = Contact::findOrFail($id);

         //Return a single article as resource
         return new ContactResource($contact);
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
        $contact = Contact::findOrFail($id);

        if($contact->delete()){
            return new ContactResource($contact);

        }
    }
}
