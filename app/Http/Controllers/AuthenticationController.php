<?php

namespace App\Http\Controllers;

use App\Classes\AuthenticationManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    private $authenticationManagement;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthenticationManagement $authenticationManagement)
    {
        //
        $this->authenticationManagement = $authenticationManagement;
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required|email|unique:users",
            "password" => "required|string"
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }
    
        return response()->created(
            "User successfully created",
            $this->authenticationManagement->register($request->all()),
            "data"
        );
    }
    

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string"
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }

        return response()->fetch(
            "User successfully signed in",
            $this->authenticationManagement->login($request->all()),
            "data"
        );
    }


}
