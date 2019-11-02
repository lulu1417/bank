<?php
namespace App\Http\Controllers;
class AccountController{
    public function increase($amount, $account)
    {
        $account->balance += $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }

    public function deduct($amount, $account)
    {
        $account->balance -= $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }
}
