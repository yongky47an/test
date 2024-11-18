<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // User registration
    public function register(Request $request)
    {

        if ($request->ajax()) {
            ini_set('memory_limit', '500M');
            ini_set('max_execution_time', '600');
           

            $headerValue = request()->header('Your-Header-Name');
            $name = '';
            if ($request->name) {    
                
            };


            // $validator = Validator::make($request->all(), [
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users',
            //     'password' => 'required|string|min:6|confirmed',
            // ]);

            // if($validator->fails()){
            //     return response()->json($validator->errors()->toJson(), 400);
            // }

            // $user = User::create([
            //     'name' => $request->get('name'),
            //     'email' => $request->get('email'),
            //     'password' => Hash::make($request->get('password')),
            // ]);

            // $token = JWTAuth::fromUser($user);

            // return response()->json(compact('user','token'), 201);


            return response()->json(compact('headerValue','name'), 201);
        }

        



        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $user = User::create([
        //     'name' => $request->get('name'),
        //     'email' => $request->get('email'),
        //     'password' => Hash::make($request->get('password')),
        // ]);

        // $token = JWTAuth::fromUser($user);

        // return response()->json(compact('user','token'), 201);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
