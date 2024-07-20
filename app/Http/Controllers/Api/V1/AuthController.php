<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * register new user
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:authors',
                'password' => 'required|string|min:8|confirmed'
            ]);
            
            $author = Author::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            return $this->login($request);

        }
        catch (Exception $error) {
            
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * authenticate user login
     */
    public function login(Request $request)
    {
        try {

            $credentials = $request->only('email', 'password');
            
            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            
            $user = Auth::user();
            $token = @$user->createToken($credentials['email'], ['post:read', 'post:write'])->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user], 200
            );
        }
        catch (Exception $error) {
            
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * logout user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
