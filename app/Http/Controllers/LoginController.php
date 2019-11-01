<?php
namespace App\Http\Controllers;
use Str;
use App\Member;
use Illuminate\Http\Request;
class LoginController
{
    public function login(Request $request)
    {
        $member = Member::where('account', $request->account)->where('password', $request->password)->first();
        $apiToken = Str::random(10);
        if($member){
            if ($member->update(['api_token'=>$apiToken])) { //update api_token
                    return "login as user, your api token is $apiToken";
            }
        }else return "Wrong email or password！";
    }
}
