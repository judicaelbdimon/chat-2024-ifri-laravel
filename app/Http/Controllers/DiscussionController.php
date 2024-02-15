<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Http\Requests\StoreDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         //
         $per_page = $request->per_page??15;
         $discussion=User::orderByDesc('created_at')
                         ->paginate($per_page);
         return $discussion;
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
     * @param  \App\Http\Requests\StoreDiscussionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscussionRequest $request)
    {
        //  $this->authorize('create', Discussion::class);
        $discussionAccountData = Arr::only($request->all(), ['name', 'description', 'createdBy', 'lastMessage','photoUrl','members']);
        $discussionAccountData['id'] = (string) Str::uuid();
        foreach($discussionAccountData as $key=>$value){
            if($value==null) $discussionAccountData[$key] = '';
        }
        $discussionAccount = Discussion::create($discussionAccountData);
        if($discussionAccount){
            return $discussionAccount;
        }
        else return response()->json([
            'message' => "Une erreur s'est produite"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
      //
      $discussion=User::findOrFail($discussion);

      return new Discussion($discussion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function edit(Discussion $discussion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiscussionRequest  $request
     * @param  \App\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        //
        $discussionAccountData = Arr::only($request->all(), ['name', 'description', 'createdBy', 'lastMessage','photoUrl','members']);
        $discussion->update($discussionData);

        return ($discussion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        // $this->authorize('delete',Discussion::class);
        if($discussion){
            if ($discussion->delete()) {
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
