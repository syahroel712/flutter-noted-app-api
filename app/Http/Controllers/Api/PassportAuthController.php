<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use DB;
use Validator;
use Illuminate\Validation\Rule;

class PassportAuthController extends Controller
{
    // register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Laravel8PassportAuth')->accessToken;

        return response()->json([
            'success' => true,
            'message' => "Register successfully",
            'data' => $user
        ], 200);
    }

    // login
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' =>$request->password
        ];
        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;
            $user = auth()->user();
            return response()->json([
                'token' => $token,
                'data' => $user
            ], 200);
        }else{
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
        }
    }

    // logout
    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => "Logout successfully"
        ], 200);
    }
    

    // user
    public function index()
    {
        $users = DB::table('users')
                ->select('name','email')
                ->get();
        
        return response()->json([
            "success" => true,
            "message" => "User List",
            "data" => $users
        ], 200);
    }

    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'level' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "User created successfully",
            "data" => $user
        ], 201);

    }

    public function show($id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response()->json([
                "success" => false,
                "message" => "User not found"
            ],404);
        }

        return response()->json([
            "success" => true,
            "message" => "User retrieved successfully",
            "data" => $user,
        ], 200);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                        'required', 
                        'email', 
                        Rule::unique('users')->ignore($user->id,'id')
                    ],
            'level' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ], 422);
        }

        if($request->password != null){
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "User updated successfully",
            "data" => $user
        ], 201);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            "success" => true,
            "message" => "User deleted succesfully"
        ], 200);
    }

}
