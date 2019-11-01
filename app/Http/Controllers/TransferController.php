<?php

namespace App\Http\Controllers;

use App\Member;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController
{
    public function transfer(Request $request)
    {

        $amount = $request->amount;

        //deduct remittance's money
        $remittance = Auth::user();
        $this->deduct($amount, $remittance);
        //increase payee's money
        $payee = Member::where('account', $request->account)->first();
        $this->increase($amount, $payee);

        //make transfer record
        $create = Record::create([
            'remittance' => $remittance->account,
            'payee' => $payee->account,
            'amount' => $request->amount,
        ]);
        if ($create)
            return "Transfer successfully, you transfer $$amount to $payee->account, and your balance is $$remittance->balance.";

    }

    protected function increase($amount, $account)
    {
        $account->balance += $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }

    protected function deduct($amount, $account)
    {
        $account->balance -= $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }
}
