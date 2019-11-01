<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller {
    public function logout() {
        if (auth::user()->update(['api_token' => 'logged out'])) {
            return "You've logged out";
        }
    }
}
