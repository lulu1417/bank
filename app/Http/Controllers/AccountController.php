<?php
namespace App\Http\Controllers;

class AccountController{
    static function increase($amount, $account)
    {
        $account->balance += $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }

    static function deduct($amount, $account)
    {
        $account->balance -= $amount;
        $account->fill(['balance' => $account->balance]);
        $account->save();
    }
}
