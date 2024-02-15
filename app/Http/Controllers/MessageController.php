<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         //
         $per_page = $request->per_page??15;
         $message=Message::orderByDesc('created_at')
                         ->paginate($per_page);
         return $message;
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
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        //  $this->authorize('create', Survey::class);
        $messageData = Arr::only($request->all(), ['text', 'surveyId', 'senderId', 'discussionId','responseToMsgId','description','file']);
        $messageData['id'] = (string) Str::uuid();
        foreach($messageData as $key=>$value){
            if($value==null) $messageData[$key] = '';
        }
        $message = Message::create($messageData);
        if($message){
            return $message;
        }
        else return response()->json([
            'message' => "Une erreur s'est produite"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
        $message=Message::findOrFail($survey);

        return new Message($message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
         //
         $messageData = Arr::only($request->all(), ['text', 'surveyId', 'senderId', 'discussionId','responseToMsgId','description','file']);
         $message->update($messageData);

         return ($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
         // $this->authorize('delete', Message::class);
         if($message){
            if ($message->delete()) {
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
