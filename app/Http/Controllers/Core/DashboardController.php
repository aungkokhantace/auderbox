<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('User')->check()) {
            $users = DB::select("SELECT count(id) as userCount FROM core_users WHERE deleted_at IS  NULL");
            $user_count = 0;
            if (isset($users) && count($users) > 0) {
                $user_count = $users[0]->userCount;
            }
            return view('core.dashboard.dashboard')
                ->with('userCount', $user_count);
        }
        return redirect('/backend/login');
    }
}
