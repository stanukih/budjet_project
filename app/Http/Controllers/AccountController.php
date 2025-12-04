<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function get_all(Request $request){
        if (!isset($request['user_id'])){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Riittämättömät tiedot';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        $accounts = Account::where('user_id',$request['user_id'])->get();
        $response = [];
        $response['status'] = 'success';
        $response['data'] = $accounts;
        return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request){
        if (
            !isset($request['user_id'])|
            !isset($request['title'])|
            !isset($request['start_sum'])){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Riittämättömät tiedot';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        $account = new Account();
        $account->user_id = $request['user_id'];
        $account->title = $request['title'];
        $account->sum = $request['start_sum'];
        $account->save();
        $response = [];
        $response['status'] = 'success';
        return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request){
        if (
            !isset($request['id'])|
            !isset($request['title'])|
            !isset($request['user_id'])){
                $response = [];
                $response['status'] = 'error';
                $response['message'] = 'Riittämättömät tiedot';
                return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        $account = Account::find($request['id']);
        $account->title = $request['title'];
        $account->save();
        $response = [];
        $response['status'] = 'success';
        return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    
}
