<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user (and global ones).
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Fetch notifications specific to user and global ones (id_user = null)
        $notifications = Notification::where('id_user', $user->id_user)
            ->orWhereNull('id_user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($notifications);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where(function($q) use ($request) {
                $q->where('id_user', $request->user()->id_user)
                  ->orWhereNull('id_user');
            })->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Marked as read']);
    }

    /**
     * Mark all notifications as read for the user.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        Notification::where('id_user', $user->id_user)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'All marked as read']);
    }
}
