<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $role = $request->user()->isAdmin;

            $role ? $abilities = ['full'] : $abilities = ['view'];

            $token = $request->user()->createToken("authToken", $abilities)->plainTextToken;
            return response()->json(['token' => $token, "user" => $request->user()]);
        }

        throw ValidationException::withMessages([
            'password' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
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

    /**
     * Log the user out (Invalidate the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'mdpA' => 'required',
            'Nmdp' => 'required|string|min:6',
        ]);

        $user = $request->user();

        // Check if the old password is correct
        if (!Hash::check($request->mdpA, $user->password)) {
            throw ValidationException::withMessages([
                'mdpA' => ['The provided old password is incorrect.'],
            ]);
        }

        // Update the password
        $user->password = Hash::make($request->Nmdp);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}
