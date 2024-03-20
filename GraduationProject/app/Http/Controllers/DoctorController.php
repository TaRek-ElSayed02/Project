<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
//use Validator;
use Illuminate\Database\Eloquent\Factories\Factory;


class DoctorController extends Controller{

    public function register(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'Email'=>'required|string|email|unique:doctors,Email',
            'Password'=>'required|string|min:7',
            'Password_Confirmation'=>'required|string|min:7'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);

        }
        $doctor= Doctor::create(array_merge(
            $validator->validated(), 
            ['Password' => bcrypt($request->Password)],
            #added
            ['Password_Confirmation' => bcrypt($request->Password_Confirmation)],
 
        ));
        return response()->json([
            'message'=>"user successfully registed",
            'Doctor'=>$doctor ],201);
    }
    public function login(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'Email'=>'required|email',
            'Password'=>'required|string|min:7',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),422);

        }
        if (!$token= auth()->attempt($validator->validated())){
            return response()->json(['error' =>'Unauthorized'],401);
        }
        return $this->createToken($token);
    }
    public function createToken($token){
        return response()->json([
         'access_token'=>$token,
         'token_type'=> 'bearer',
         'expires_in'=>auth()->factory()->getTTL()*60,
         'Doctor'=>auth()->Doctor
        ]);

    }
}










