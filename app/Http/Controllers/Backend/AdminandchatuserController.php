<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertoadminchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminandchatuserController extends Controller
{
    /**
     * ✅ Display user list for admin chat
     * Shows all users with role 'user'
     */
    public function adminuserchat()
    {
        try {
            $users = User::where('role', 'user')
                ->select('id', 'name', 'email', 'created_at')
                ->orderBy('name', 'asc')
                ->get();

            return view('admin.userchat.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Admin User Chat List Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'ইউজার লিস্ট লোড করতে সমস্যা হয়েছে।');
        }
    }

    /**
     * ✅ Fetch messages between admin and specific user
     * Returns messages after last_id for real-time updates
     */
    public function fetchMessages($user_id, Request $request)
    {
        try {
            $adminId = Auth::id();
            $lastId = (int) $request->query('last_id', 0);

            // Validate user exists
            $userExists = User::where('id', $user_id)
                ->where('role', 'user')
                ->exists();

            if (!$userExists) {
                return response()->json(['error' => 'ইউজার পাওয়া যায়নি'], 404);
            }

            // Fetch messages between admin and user
            $query = Usertoadminchat::where(function ($q) use ($user_id, $adminId) {
                $q->where(function ($sub) use ($user_id, $adminId) {
                    $sub->where('sender_id', $user_id)
                        ->where('receiver_id', $adminId);
                })
                ->orWhere(function ($sub) use ($user_id, $adminId) {
                    $sub->where('sender_id', $adminId)
                        ->where('receiver_id', $user_id);
                });
            });

            // Filter by last_id for new messages only
            if ($lastId > 0) {
                $query->where('id', '>', $lastId);
            }

            $messages = $query->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'sender_id' => $msg->sender_id,
                        'receiver_id' => $msg->receiver_id,
                        'message' => $msg->message,
                        'image' => $msg->image,
                        'is_read' => $msg->is_read,
                        'time' => $msg->created_at->format('h:i A'),
                        'date' => $msg->created_at->format('d M Y'),
                    ];
                });

            // Mark user messages as read (only if this is admin viewing)
            if ($lastId == 0) {
                Usertoadminchat::where('sender_id', $user_id)
                    ->where('receiver_id', $adminId)
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }

            return response()->json($messages);

        } catch (Exception $e) {
            Log::error('Fetch Messages Error: ' . $e->getMessage());
            return response()->json(['error' => 'মেসেজ লোড করতে সমস্যা হয়েছে'], 500);
        }
    }

    /**
     * ✅ Send message from admin to user
     * Supports text messages and images
     */
    public function sendMessage(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'receiver_id' => 'required|integer|exists:users,id',
                'message' => 'nullable|string|max:5000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'receiver_id.required' => 'রিসিভার আইডি প্রয়োজন',
                'receiver_id.exists' => 'ইউজার পাওয়া যায়নি',
                'image.image' => 'শুধুমাত্র ছবি আপলোড করুন',
                'image.max' => 'ছবি সর্বোচ্চ ২ MB হতে পারে',
                'message.max' => 'মেসেজ খুব বড়',
            ]);

            $adminId = Auth::id();
            $receiverId = $request->receiver_id;

            // Check if receiver is a valid user
            $receiver = User::where('id', $receiverId)
                ->where('role', 'user')
                ->first();

            if (!$receiver) {
                return response()->json([
                    'success' => false,
                    'message' => 'ইউজার পাওয়া যায়নি'
                ], 404);
            }

            // At least message or image required
            if (empty($request->message) && !$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'মেসেজ বা ছবি দিন'
                ], 422);
            }

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Store in uploads/admin_chat
                    $image->move(public_path('uploads/admin_chat'), $imageName);
                    $imagePath = 'uploads/admin_chat/' . $imageName;
                } catch (Exception $e) {
                    Log::error('Image Upload Error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'ছবি আপলোড করতে সমস্যা হয়েছে'
                    ], 500);
                }
            }

            // Create chat message
            $chat = Usertoadminchat::create([
                'sender_id' => $adminId,
                'receiver_id' => $receiverId,
                'message' => $request->message,
                'image' => $imagePath,
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'মেসেজ পাঠানো হয়েছে',
                'chat' => [
                    'id' => $chat->id,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'message' => $chat->message,
                    'image' => $chat->image,
                    'is_read' => $chat->is_read,
                    'time' => $chat->created_at->format('h:i A'),
                    'date' => $chat->created_at->format('d M Y'),
                ]
            ], 201);

        } catch (Exception $e) {
            Log::error('Send Message Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'মেসেজ পাঠাতে সমস্যা হয়েছে'
            ], 500);
        }
    }

    /**
     * ✅ Get unread message count for each user
     * Returns array of user_id => unread_count
     */
    public function unreadCount()
    {
        try {
            $adminId = Auth::id();

            $counts = Usertoadminchat::where('receiver_id', $adminId)
                ->where('is_read', false)
                ->select('sender_id', DB::raw('COUNT(*) as count'))
                ->groupBy('sender_id')
                ->pluck('count', 'sender_id')
                ->toArray();

            return response()->json($counts);

        } catch (Exception $e) {
            Log::error('Unread Count Error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * ✅ Mark all messages from specific user as read
     * Updates is_read status for unread messages
     */
    public function markRead($user_id)
    {
        try {
            $adminId = Auth::id();

            // Validate user exists
            $userExists = User::where('id', $user_id)
                ->where('role', 'user')
                ->exists();

            if (!$userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'ইউজার পাওয়া যায়নি'
                ], 404);
            }

            // Update unread messages to read
            $updated = Usertoadminchat::where('sender_id', $user_id)
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'মেসেজ পড়া হয়েছে',
                'updated_count' => $updated
            ]);

        } catch (Exception $e) {
            Log::error('Mark Read Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'মেসেজ আপডেট করতে সমস্যা হয়েছে'
            ], 500);
        }
    }

    /**
     * ✅ Delete a specific message (optional feature)
     */
    public function deleteMessage($message_id)
    {
        try {
            $adminId = Auth::id();

            $message = Usertoadminchat::where('id', $message_id)
                ->where('sender_id', $adminId)
                ->first();

            if (!$message) {
                return response()->json([
                    'success' => false,
                    'message' => 'মেসেজ পাওয়া যায়নি'
                ], 404);
            }

            // Delete image if exists
            if ($message->image) {
                $imagePath = public_path($message->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'মেসেজ ডিলিট হয়েছে'
            ]);

        } catch (Exception $e) {
            Log::error('Delete Message Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'মেসেজ ডিলিট করতে সমস্যা হয়েছে'
            ], 500);
        }
    }

    /**
     * ✅ Get chat statistics (optional)
     */
    public function getChatStats()
    {
        try {
            $adminId = Auth::id();

            $stats = [
                'total_users' => User::where('role', 'user')->count(),
                'total_messages' => Usertoadminchat::where(function($q) use ($adminId) {
                    $q->where('sender_id', $adminId)
                      ->orWhere('receiver_id', $adminId);
                })->count(),
                'unread_messages' => Usertoadminchat::where('receiver_id', $adminId)
                    ->where('is_read', false)
                    ->count(),
                'active_chats' => Usertoadminchat::where(function($q) use ($adminId) {
                    $q->where('sender_id', $adminId)
                      ->orWhere('receiver_id', $adminId);
                })
                ->distinct('sender_id', 'receiver_id')
                ->count(),
            ];

            return response()->json($stats);

        } catch (Exception $e) {
            Log::error('Chat Stats Error: ' . $e->getMessage());
            return response()->json(['error' => 'স্ট্যাটাস লোড করতে সমস্যা'], 500);
        }
    }
}
