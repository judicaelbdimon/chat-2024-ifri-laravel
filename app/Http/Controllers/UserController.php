<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::orderByDesc('created_at')
                        ->paginate(15);
        return $users;
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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //  $this->authorize('create', User::class);
        $userAccountData = Arr::only($request->all(), ['firstname', 'lastname', 'email', 'password'=>bcrypt($request->password), 'description', 'photoUrl']);
        $userAccountData['id'] = (string) Str::uuid();
        foreach($userAccountData as $key=>$value){
            if($value==null) $userAccountData[$key] = '';
        }
        $userAccount = User::create($userAccountData);
        if($userAccount){
            return $userAccount;
        }
        else return response()->json([
            'message' => "Une erreur s'est produite"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $userAccountData = Arr::only($request->all(), ['firstname', 'lastname', 'email', 'password'=>bcrypt($request->password), 'description', 'photoUrl']);
        $user->update($userData);

        return ($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $this->authorize('delete', User::class);
        if($user){
            if ($user->delete()) {
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
