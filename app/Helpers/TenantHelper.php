<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class TenantHelper
{
    public static function getTenantId()
    {
        if (Auth::check()) {
            return Auth::user()->tenant_id;
        }

        return null;
    }
}