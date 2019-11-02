<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AccountController as AccountController;
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
        AccountController::deduct($amount, $remittance);

        //increase payee's money
        $payee = Member::where('account', $request->account)->first();
        AccountController::increase($amount, $payee);

        //make transfer record
        $create = Record::create([
            'remittance' => $remittance->account,
            'payee' => $payee->account,
            'amount' => $request->amount,
        ]);
        if ($create)
            return "Transfer successfully, you transfer $$amount to $payee->account, and your balance is $$remittance->balance.";

    }

}
