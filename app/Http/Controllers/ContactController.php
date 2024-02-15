<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          //
          $per_page = $request->per_page??15;
          $contact=Contact::orderByDesc('created_at')
                          ->paginate($per_page);
          return $contact;
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
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        //  $this->authorize('create',Contact::class);
        $contactAccountData = Arr::only($request->all(), ['user1Id', 'user2Id', 'user1blocked', 'user2blocked','status']);
        $contactAccountData['id'] = (string) Str::uuid();
        foreach($contactAccountData as $key=>$value){
            if($value==null) $contactAccountData[$key] = '';
        }
        $contactrAccount = User::create($contactAccountData);
        if($contactAccount){
            return $contactrAccount;
        }
        else return response()->json([
            'message' => "Une erreur s'est produite"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
         //
         $contact=Contact::findOrFail($contact);

         return new Contact($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
       //
       $contactAccountData = Arr::only($request->all(),  ['user1Id', 'user2Id', 'user1blocked', 'user2blocked','status']);
       $contact->update($contactData);

       return ($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        // $this->authorize('delete', Contact::class);
        if($contact){
            if ($contact->delete()) {
                //return response()->noContent();
                return response()->json([
                    'message' => 'Resource deleted sucessfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Failed deleting resource'
                ], 400);
            }
        }else{
            return response()->json([
                'message' => 'Resource don\'t exist.'
            ], 404);
        }
    }
}
