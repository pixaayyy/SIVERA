<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        
        if($notification) {
            $notification->markAsRead();
            
            if (isset($notification->data['url'])) {
                return redirect($notification->data['url']);
            }
        }
        
        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}