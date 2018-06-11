<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class SystemReferencesController extends Controller
{
    public function index()
    {
        if (Auth::guard('User')->check()) {
            return view('core.system_references.system_references');
        }
        return redirect('/backend/login');
    }
}
