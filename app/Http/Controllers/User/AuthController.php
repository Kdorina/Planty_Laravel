<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;

class AuthController extends BaseController
{
    public function login(Request $request){

        if(Auth::attempt(['email' =>$request->email, 'password'=> $request->password])){
            $authUser = Auth::user();
            $success["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
            $success["name"] = $authUser->name;

            return $this->sendResponse($success, 'sikeres bejelentkezés');

        }
        else{
            return $this->sendError('Unauthorizd.'.['error' => 'hibás adatok'], 401);
        }
    }

    public function register(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            "name" =>"required",
            "email"=> "required",
            "password"=> "required",
            "confirm_password"=> "required"
        ]);

        if($validator->fails()){
            return $this->sendError("Error validation", $validator->errors());
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success ["name"] = $user->name;

        return $this->sendResponse($success, "sikeres regisztráció");


    }

    public function logout(Request $request){
        auth("sanctum")->user()->currentAccessToken()->delete();
        return response()->json("sikeres kijelentkezés");
    }
}
