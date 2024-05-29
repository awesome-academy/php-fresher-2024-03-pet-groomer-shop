<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnreadNotification()
    {
        $unreadNotifications = getUser()->unreadNotifications;

        return response()->json($unreadNotifications);
    }

    public function markAsRead($id)
    {
        $notification =
            Auth::user()->notifications->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json($notification);
    }
}
