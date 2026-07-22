<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(AppNotification $notification)
    {
        $notification->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Notification marked as read!');
    }
}
