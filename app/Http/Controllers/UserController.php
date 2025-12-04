<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registration(Request $request){
        if (
            !isset($request['name'])|
            !isset($request['email'])|
            !isset($request['password'])){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Riittämättömät tiedot';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            }
            $user = User::where('email', $request['email'])->first();
            if ($user){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Sähköposti on jo rekisteröity';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            }
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];

            $user->password = $request['password'];
            $user->save();
            $response = [];
                $response['status'] = 'success';
                $response['user'] = $user->id;
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }


    public function login(Request $request){
        if (
            !isset($request['email'])|
            !isset($request['password'])){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Riittämättömät tiedot';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            }
            $user = User::where('email', $request['email'])->first();
            if (!$user){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Käyttäjää ei löydy';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            }
            if (Hash::check($request['password'], $user->password)) {
                $response = [];
                $response['status'] = 'success';
                $response['user'] = $user->id;
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            } else {
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Väärä salasana';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
            }            
    }
    
}
