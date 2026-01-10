<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Usertoadminchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsertoadminchatController extends Controller
{
    /**
     * Send a message (AJAX)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        // Ensure either message or image is provided
        if (!$request->message && !$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'message' => 'বার্তা বা ছবি প্রয়োজন।'
            ], 400);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin_chat'), $imageName);
            $imagePath = 'uploads/admin_chat/' . $imageName;
        }

        $chat = Usertoadminchat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'image' => $imagePath,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'মেসেজ পাঠানো হয়েছে।',
            'chat' => [
                'id' => $chat->id,
                'message' => $chat->message,
                'image' => $imagePath ? asset($imagePath) : null,
                'time' => $chat->created_at->format('h:i A'),
                'is_admin' => false,
            ]
        ]);
    }

    /**
     * Fetch messages (AJAX)
     */
    public function fetchMessages(Request $request)
    {
        $adminId = 1; // Admin ID
        $userId = Auth::id();
        $lastId = $request->input('last_id', 0);

        $query = Usertoadminchat::where(function ($q) use ($adminId, $userId) {
            $q->where(function ($subQ) use ($adminId, $userId) {
                $subQ->where('sender_id', $userId)->where('receiver_id', $adminId);
            })->orWhere(function ($subQ) use ($adminId, $userId) {
                $subQ->where('sender_id', $adminId)->where('receiver_id', $userId);
            });
        });

        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        $formattedMessages = $messages->map(function ($msg) use ($adminId) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'image' => $msg->image ? asset($msg->image) : null,
                'time' => $msg->created_at->format('h:i A'),
                'is_admin' => $msg->sender_id == $adminId,
                'is_read' => $msg->is_read,
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $formattedMessages
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markRead(Request $request)
    {
        $userId = Auth::id();
        $adminId = 1; // Admin ID

        // Mark all unread messages from admin to user as read
        Usertoadminchat::where('sender_id', $adminId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread message count
     */
    public function unreadCount(Request $request)
    {
        $userId = Auth::id();
        $adminId = 1; // Admin ID

        // Count unread messages from admin to user
        $count = Usertoadminchat::where('sender_id', $adminId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
