<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Sorting
        if ($request->has('sortBy')) {
            $sortBy = $request->input('sortBy');
            $query->orderBy('created_at', $sortBy);
        }

        // Query
        if ($request->has('query')) {
            $query->where('firtName', 'like', '%' . $request->input('name') . '%')
                ->orWhere('middleName', 'like', '%' . $request->input('name') . '%')
                ->orWhere('lastName', 'like', '%' . $request->input('name') . '%')
                ->orWhere('mobile', 'like', '%' . $request->input('name') . '%')
                ->orWhere('email', 'like', '%' . $request->input('name') . '%');
        }

        // Pagination
        $limit = $request->query('limit', 5);
        $users = $query->paginate($limit);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firstName' => 'required|string|max:50',
        'middleName' => 'required|string|max:50',
        'lastName' => 'required|string|max:50',
        'mobile' => 'nullable|string|max:25',
        'email' => 'required|email|unique:users,email',
        'passwordHash' => 'required|string|max:32',
        'registerAt' => 'required|date',
        'lastLogin' => 'required|date',
        'intro' => 'required|string',
        'profile' => 'required|string|max:32'
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    $user = User::create($request->all());
    return response()->json($user, 201);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
        $validator = Validator::make($request->all(), [
            'firstName' => 'sometimes|required|string|max:50',
            'middleName' => 'sometimes|required|string|max:50',
            'lastName' => 'sometimes|required|string|max:50',
            'mobile' => 'nullable|string|max:25',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'passwordHash' => 'sometimes|required|string|max:32',
            'registerAt' => 'sometimes|required|date',
            'lastLogin' => 'sometimes|required|date',
            'intro' => 'sometimes|required|string',
            'profile' => 'sometimes|required|string|max:32'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }  
        $user = User::findOrFail($id);   
        // Chỉ cập nhật các trường có trong request
        $user->fill($request->only([
            'firstName',
            'middleName',
            'lastName',
            'mobile',
            'email',
            'passwordHash',
            'registerAt',
            'lastLogin',
            'intro',
            'profile'
        ]));
    
        $user->save();
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $res=[
            "message"=>"User deleted",
            "status"=>200,
            "data"=>$user,
        ];
        return response()->json($res);
    }
}
