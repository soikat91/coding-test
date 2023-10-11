<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
   public function transactionShow(Request $request){


        $user_id=$request->header('id');
        $transactions= Transaction::where('user_id',$user_id)->get();

        
        $currentBalance = 0;

        foreach ($transactions as $transaction) {
         
            if ($transaction->transaction_type === 'Deposit') {
                $currentBalance += $transaction->amount;
            } elseif ($transaction->transaction_type === 'Withdrawal') {
                $currentBalance -= $transaction->amount;
            }            
        }

    return response()->json(['transactions' => $transactions,'current_balance' => $currentBalance], 200);
   }


   function depositShow(Request $request){

        $user_id=$request->header('id');

        $deposit=Transaction::where('user_id',$user_id)->where('transaction_type','Deposit')->get();

        return response()->json(['deposit'=>$deposit]);


   }


   function deposit(Request $request){
  
    $userId = $request->header('id');
    $amount = $request->input('amount');

    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update the user's balance
    $user->balance += $amount;
    $user->save();

    // Create a deposit transaction
    Transaction::create([
        'user_id' => $user->id,
        'transaction_type' => 'Deposit',
        'amount' => $amount,
        'fee' => 0, // You can adjust this as needed
        'date' => now(),
    ]);

    return response()->json(['message' => 'Deposit successful', 'user' => $user], 201);
   }

   function withdrawalShow(Request $request){
        
     $user_id=$request->header('id');
     $withdraqal=Transaction::where('user_id',$user_id)->where('transaction_type','Withdrawal')->get();
     return response()->json(['withdraqal' => $withdraqal]);
   }


   function withdrawal(Request $request){
    
    $user_id = $request->header('id');
    $amount = $request->input('amount');
    $user = User::find($user_id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    if ($user->balance < $amount) {
        return response()->json(['message' => 'Insufficient funds'], 400);
    }

    // Update the user's balance
    $user->balance -= $amount;
    $user->save();

    // Create a withdrawal transaction
    Transaction::create([
        'user_id' => $user_id,
        'transaction_type' => 'Withdrawal',
        'amount' => $amount,
        'fee' => 0,
        'date' => now(),
    ]);

    return response()->json(['message' => 'Withdrawal successful', 'user' => $user], 201);
    
}  

}







