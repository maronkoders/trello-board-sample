<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserActivity
{
    public function saveUserActivity(String $message)
    {
        return  \App\UserActivity::create([
            'action' => $message,
            'username' => Auth::user()->name
        ]);
    }
}
