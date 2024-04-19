<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:50',
            'middleName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'mobile' => 'required|string|max:15|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|string|min:8',
            'intro' => 'nullable|string',
            'profile' => 'nullable|string|max:32',
        ]);

        $user = User::create([
            'firstName' => $validatedData['firstName'],
            'middleName' => $validatedData['middleName'],
            'lastName' => $validatedData['lastName'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
            'passwordHash' => Hash::make($validatedData['password']),
            'registerAt' => now(),
            'lastLogin' => now(),
            'intro' => $validatedData['intro'],
            'profile' => $validatedData['profile'],
        ]);

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
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'firstName' => 'required|string|max:50',
            'middleName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $user->id,
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'intro' => 'nullable|string',
            'profile' => 'nullable|string|max:32',
        ]);

        $user->firstName = $validatedData['firstName'];
        $user->middleName = $validatedData['middleName'];
        $user->lastName = $validatedData['lastName'];
        $user->mobile = $validatedData['mobile'];
        $user->email = $validatedData['email'];

        if ($request->has('password')) {
            $user->passwordHash = Hash::make($validatedData['password']);
        }

        $user->intro = $validatedData['intro'];
        $user->profile = $validatedData['profile'];
        $user->lastLogin = now();
        $user->save();

        return response()->json($user);
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

        return response()->json(['message' => 'User deleted'], 204);
    }
}
