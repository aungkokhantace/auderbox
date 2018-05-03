<?php

namespace App\Session;

use Auth;
use Request;

class DatabaseSessionHandler extends \Illuminate\Session\DatabaseSessionHandler
{
    public function write($sessionId, $data)
    {
        $ip = Request::ip();    //to get ip address
        $user_agent = substr(Request::header('User-Agent'),0,500); //to get user agent
        $user_id = (Auth::guard('User')->check()) ? Auth::guard('User')->user()->id : null;

        if ($this->exists) {
            $this->getQuery()->where('id', $sessionId)->update([
                'payload' => base64_encode($data), 'last_activity' => time(), 'user_id' => $user_id,'ip_address'=>$ip,'user_agent'=>$user_agent,
            ]);
        } else {
            $this->getQuery()->insert([
                'id' => $sessionId, 'payload' => base64_encode($data), 'last_activity' => time(), 'user_id' => $user_id,
            ]);
        }

        $this->exists = true;
    }
}

?>