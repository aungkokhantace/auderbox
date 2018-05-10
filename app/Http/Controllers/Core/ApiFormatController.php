<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class ApiFormatController extends Controller
{
    public function index()
    {
        if (Auth::guard('User')->check()) {
            return view('core.api_format.api_format');
        }
        return redirect('/backend/login');
    }
}
