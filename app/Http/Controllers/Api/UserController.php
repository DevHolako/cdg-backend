<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(["ability:view,full"])->only('index', 'show');
        $this->middleware(["ability:full"])->only("store", "update", "destory");
    }


    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomComplete' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string',
            'isAdmin' => 'sometimes|boolean',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $fields = $request->validate([
            'nomComplete' => 'sometimes|string',
            'login' => 'sometimes|string',
            'password' => 'sometimes|string',
            'isAdmin' => 'sometimes|boolean',
        ]);

        if (isset($fields['password'])) {
            $fields['password'] = Hash::make($fields['password']);
        }

        $user->update($fields);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
