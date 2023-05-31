<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends BaseController
{
    public function login(Request $request)
    {
        $validated = Validator::make($request->all() [
            ''
        ]);
    }
}
