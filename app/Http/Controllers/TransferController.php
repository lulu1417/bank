<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController
{
    public function transfer(Request $request)
    {
        $amount = $request->amount;
        $remittance = Auth::user();
        $this->deduct($amount, $remittance);

        $payee = Member::where('account', $request->account)->first();
        $this->increase($amount, $payee);

        return "Transfer successfully, you transfer $$amount to $payee->account, and your balance is $$remittance->balance.";

    }

    protected function increase($amount, $account){
        $account->balance+= $amount;
        $account->fill(['balance'=>$account->balance]);
        $account->save();
    }
    protected function deduct($amount, $account){
        $account->balance-= $amount;
        $account->fill(['balance'=>$account->balance]);
        $account->save();
    }
}
