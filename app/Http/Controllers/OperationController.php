<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Termwind\parse;

class OperationController extends Controller
{
    public function create(Request $request){
        if (
            !isset($request['date'])&&
            !isset($request['account_id'])&&
            !isset($request['type_id'])&&
            !isset($request['category_id'])&&
            !isset($request['sum'])&&
            !isset($request['description'])&&
            !isset($request['user_id'])//&&
            //!in_array($request['category_id'],['going','coming'])
            
            ){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Riittämättömät tiedot';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        $account = Account::find($request['account_id']);
        if ($account->user_id!=$request['user_id']){

        $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Väärä pankkitili';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        $operation = new Operation();
        $operation->created_at = $request['date'];
        $operation->account_id = $request['account_id'];
        $operation->type = $request['type_id'];
        $operation->category_id = $request['category_id'];
        $operation->sum = $request['sum'];
        $operation->description = $request['description'];
        $operation->save();

        if ($request['type_id']=='going')
            $account->sum = $account->sum - $request['sum'];
        
        if ($request['type_id']=='coming')
            $account->sum = $account->sum + $request['sum'];
        $account->save();
        $response = [];
        $response['status'] = 'success';
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }


    public function get_all(Request $request){
        if (!isset($request['user_id'])){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Riittämättömät tiedot';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        
        $accounts = Account::where('user_id', $request['user_id'])->get(['id']);
        
        $account_list_id = [];
        foreach ($accounts as $account){
            array_push($account_list_id, $account->id);
        }
        //$options = [['account_id','in', $account_list_id]];
        $operations_request = Operation::whereIn('account_id', $account_list_id);
        //return $operations_request->get();
        $filters = $request['filter'];
        if (!empty($filters['start_date'])){
            //array_push($options,['created_at','>=',$filters['start_date']]);
            $operations_request->where('created_at','>=',$filters['start_date']);
        }
        if (!empty($filters['end_date'])){
            //array_push($options,['created_at','<=',$filters['stop_date']]);
            $operations_request->where('created_at','<=',$filters['end_date']);
        }
        if (!empty($filters['category_id'])){
            //array_push($options,['category_id','=',$filters['category_id']]);
            $operations_request->where('category_id','=',$filters['category_id']);
        }
        if (
            !empty($filters['sum'])&&
            !empty($filters['sum']['operation'])&&
            !empty($filters['sum']['value'])
            ){
                //array_push($options,['sum', $filters['sum']['operation'], $filters['sum']['value']]);
                $operations_request->where('sum',$filters['sum']['operation'],$filters['sum']['value']);
        }
        //$operations = Operation::where($options)->get();
        //return $operations_request->toSql();
        $operations = $operations_request->get();
        //return $operations_request->toSql();
        $response = [];
        $response['status'] = 'success';
        $response['data'] = $operations;
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }
    public function update(Request $request){
        if (
            !isset($request['date'])&&
            !isset($request['account_id'])&&
            !isset($request['type_id'])&&
            !isset($request['category_id'])&&
            !isset($request['sum'])&&
            !isset($request['description'])&&
            !isset($request['operation_id'])&&
            !isset($request['user_id'])
            ){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Riittämättömät tiedot';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        $operation = Operation::find($request['operation_id']);
        if ($operation->account_id!=$request['account_id']){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Väärä pankkitili';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        $account = Account::find($request['account_id']);
        if ($account->user_id!=$request['user_id']){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Väärä pankkitili';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        //vanhan operaation peruuttaminen
        if ($operation->type=='going')
            $account->sum = $account->sum + $operation->sum;
        
        if ($operation->type=='coming')
            $account->sum = $account->sum - $operation->sum;
        
        if ($request['type_id']=='going')
            $account->sum = $account->sum - $request['sum'];
        
        if ($request['type_id']=='coming')
            $account->sum = $account->sum + $request['sum'];
        $account->save();
        $operation->created_at = $request['date'];
        $operation->account_id = $request['account_id'];
        $operation->type = $request['type_id'];
        $operation->category_id = $request['category_id'];
        $operation->sum = $request['sum'];
        $operation->description = $request['description'];
        $operation->save(); 
        $response = [];
        $response['status'] = 'success';
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    public function delete(Request $request){
        if (
            !isset($request['operation_id'])&&
            !isset($request['user_id'])
            ){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Riittämättömät tiedot';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        $operation = Operation::find($request['operation_id']);
        if (!$operation){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Väärä operation_id';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        $account = Account::find($operation->account_id);
        if ($account->user_id!=$request['user_id']){
            $response = [];
            $response['status'] = 'error';
            $response['message'] = 'Väärä user_id';
            return response()->json($response, 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }

        //vanhan operaation peruuttaminen
        if ($operation->type=='going'){
            $account->sum = $account->sum + $operation->sum;
            $account->save();
        }
        if ($operation->type=='coming'){
            $account->sum = $account->sum - $operation->sum;
            $account->save();
        }
        $operation->delete();
        $response = [];
        $response['status'] = 'success';
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }
}