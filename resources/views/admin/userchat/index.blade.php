@extends('admin.master')

@section('admin')

<style>
    .chat-wrapper {
        height: calc(100vh - 200px);
        min-height: 500px;
        position: relative;
    }

    .chat-sidebar {
        width: 320px;
        max-height: 100%;
        overflow-y: auto;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        background: white;
    }

    .chat-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .chat-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    .user-item {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0 !important;
        position: relative;
    }

    .user-item:hover {
        background-color: #f7fafc !important;
        transform: translateX(5px);
    }

    .user-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        border-color: #667eea !important;
    }

    .user-item.active .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .user-item.has-unread {
        font-weight: 600;
        border-left: 3px solid #667eea !important;
    }

    .unread-badge {
        min-width: 22px;
        height: 22px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
    }

    .chat-main {
        display: flex;
        flex-direction: column;
        max-height: 100%;
        position: relative;
        z-index: 10;
    }

    .chat-header {
        padding: 15px 20px;
        border-bottom: 2px solid #e2e8f0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px 8px 0 0;
        color: white;
        position: relative;
        z-index: 11;
    }

    .chat-box {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f7fafc;
        min-height: 400px;
        max-height: calc(100vh - 400px);
        position: relative;
        z-index: 10;
    }

    .chat-box::-webkit-scrollbar {
        width: 8px;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    .message-bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        margin-bottom: 12px;
        word-wrap: break-word;
        line-height: 1.5;
        animation: slideIn 0.3s ease;
        position: relative;
        z-index: 1;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
        margin-left: auto;
    }

    .message-user {
        background: white;
        color: #2d3748;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .message-user.unread {
        background: #e6f7ff;
        border-left: 3px solid #1890ff;
        font-weight: 500;
    }

    .message-image {
        max-width: 250px;
        border-radius: 12px;
        margin-top: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .message-image:hover {
        transform: scale(1.05);
    }

    .message-time {
        font-size: 11px;
        color: #a0aec0;
        margin-top: 4px;
        text-align: right;
    }

    .message-user .message-time {
        text-align: left;
    }

    .chat-form {
        padding: 15px 20px;
        background: white;
        border-top: 2px solid #e2e8f0;
        border-radius: 0 0 8px 8px;
        position: relative;
        z-index: 11;
    }

    .chat-input {
        border-radius: 25px;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .chat-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-send {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 25px;
        padding: 10px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-send:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #a0aec0;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .online-indicator {
        width: 10px;
        height: 10px;
        background: #2ecc71;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .file-preview {
        max-width: 200px;
        margin-top: 10px;
        border-radius: 8px;
    }

    /* Back button for mobile */
    .btn-back-mobile {
        display: none;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-back-mobile:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .chat-wrapper {
            flex-direction: row !important;
            height: calc(100vh - 150px);
            gap: 0 !important;
        }

        /* Sidebar styles */
        .chat-sidebar {
            width: 100%;
            max-height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            z-index: 100;
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        .chat-sidebar.hide-mobile {
            transform: translateX(-100%);
        }

        /* Chat main area */
        .chat-main {
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        .chat-main.show-mobile {
            transform: translateX(0);
            z-index: 101;
        }

        /* Show back button on mobile */
        .btn-back-mobile {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .message-bubble {
            max-width: 85%;
        }

        .chat-box {
            max-height: calc(100vh - 350px);
            min-height: 300px;
        }

        /* Adjust header for mobile */
        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
        }

        .message-image {
            max-width: 200px;
        }

        .btn-send {
            padding: 10px 20px;
            font-size: 14px;
        }

        /* Empty state adjustments */
        .empty-state i {
            font-size: 48px;
        }

        .empty-state h5 {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .chat-input {
            font-size: 14px;
            padding: 8px 15px;
        }

        .btn-send {
            padding: 8px 15px;
        }

        .message-bubble {
            padding: 10px 14px;
            font-size: 14px;
        }

        .user-item {
            padding: 10px !important;
        }

        .user-item .rounded-circle {
            width: 30px !important;
            height: 30px !important;
            font-size: 12px !important;
        }
    }
</style>

<main class="dashboard-main">
    <div class="dashboard-main-body">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">ইউজার চ্যাট</h4>
                <p class="text-muted mb-0">ইউজারদের সাথে সরাসরি যোগাযোগ করুন</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                <i class="fas fa-home me-2"></i>ড্যাশবোর্ড
            </a>
        </div>

        <div class="chat-wrapper d-flex gap-3">
            {{-- User Sidebar --}}
            <div class="chat-sidebar card" id="userSidebar">
                <div class="p-3 border-bottom">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-users me-2"></i>সকল ইউজার
                    </h6>
                </div>
                <div class="p-3" id="userList">
                    @forelse($users as $user)
                    <div class="user-item p-3 rounded mb-2" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                         style="width: 35px; height: 35px; font-size: 14px; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong class="user-name">{{ $user->name }}</strong>
                                </div>
                                <small class="text-muted d-block ms-5">{{ $user->email }}</small>
                            </div>
                            <span class="badge bg-danger unread-badge" style="display: none;">0</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                        <p>কোনো ইউজার নেই</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Chat Area --}}
            <div class="chat-main card flex-grow-1" id="chatMain">
                <div class="chat-header">
                    <div class="d-flex align-items-center flex-grow-1">
                        <button class="btn btn-back-mobile me-2" id="backBtn">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <span class="online-indicator"></span>
                        <h6 class="mb-0 fw-semibold" id="chatUserName">একজন ইউজার নির্বাচন করুন</h6>
                    </div>
                </div>

                <div id="chatBox" class="chat-box">
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h5>কথোপকথন শুরু করতে একজন ইউজার নির্বাচন করুন</h5>
                    </div>
                </div>

                <div class="chat-form">
                    <form id="chatForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" id="receiver_id">

                        <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <input type="text"
                                       class="form-control chat-input"
                                       name="message"
                                       id="message"
                                       placeholder="মেসেজ লিখুন..."
                                       autocomplete="off">
                            </div>

                            <div>
                                <label for="chatImage" class="btn btn-outline-secondary" style="border-radius: 25px;">
                                    <i class="fas fa-paperclip"></i>
                                </label>
                                <input type="file"
                                       name="image"
                                       id="chatImage"
                                       class="d-none"
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                            </div>

                            <button type="submit" class="btn btn-send" id="sendBtn">
                                <i class="fas fa-paper-plane me-2"></i>পাঠান
                            </button>
                        </div>

                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img src="" alt="Preview" class="file-preview">
                            <button type="button" class="btn btn-sm btn-danger ms-2" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const chatBox = document.getElementById("chatBox");
    const chatForm = document.getElementById("chatForm");
    const receiverInput = document.getElementById("receiver_id");
    const messageInput = document.getElementById("message");
    const chatUserName = document.getElementById("chatUserName");
    const sendBtn = document.getElementById("sendBtn");
    const chatImage = document.getElementById("chatImage");
    const imagePreview = document.getElementById("imagePreview");
    const removeImageBtn = document.getElementById("removeImage");
    const userSidebar = document.getElementById("userSidebar");
    const chatMain = document.getElementById("chatMain");
    const backBtn = document.getElementById("backBtn");

    let selectedUser = null;
    let lastMessageId = 0;
    let isLoading = false;
    let messageCheckInterval = null;

    // Mobile view management
    function showChatView() {
        if (window.innerWidth <= 768) {
            userSidebar.classList.add('hide-mobile');
            chatMain.classList.add('show-mobile');
        }
    }

    function showUserListView() {
        if (window.innerWidth <= 768) {
            userSidebar.classList.remove('hide-mobile');
            chatMain.classList.remove('show-mobile');
        }
    }

    // Back button click handler
    backBtn.addEventListener('click', function() {
        showUserListView();
    });

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Image preview
    chatImage.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2048 * 1024) {
                alert('ছবি খুব বড়। সর্বোচ্চ ২ MB অনুমোদিত।');
                chatImage.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.querySelector('img').src = event.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function() {
        chatImage.value = '';
        imagePreview.style.display = 'none';
    });

    // Fetch unread counts and update UI
    async function fetchUnread() {
        try {
            const res = await fetch("{{ route('admin.user.unread') }}");
            const data = await res.json();

            Object.keys(data).forEach(userId => {
                const userEl = document.querySelector(`.user-item[data-id='${userId}']`);
                if (!userEl) return;

                const badge = userEl.querySelector(".unread-badge");
                const count = data[userId];

                if (count > 0) {
                    badge.style.display = "inline-flex";
                    badge.innerText = count;
                    userEl.classList.add('has-unread');

                    // Move to top
                    const parent = userEl.parentNode;
                    parent.insertBefore(userEl, parent.firstChild);
                } else {
                    badge.style.display = "none";
                    userEl.classList.remove('has-unread');
                }
            });
        } catch (error) {
            console.error('Error fetching unread counts:', error);
        }
    }

    // Initial fetch and set interval
    fetchUnread();
    setInterval(fetchUnread, 3000);

    // Select user
    document.querySelectorAll(".user-item").forEach(item => {
        item.addEventListener("click", async function() {
            // Update UI
            document.querySelectorAll(".user-item").forEach(u => u.classList.remove("active"));
            this.classList.add("active");

            selectedUser = this.dataset.id;
            const userName = this.dataset.name;

            receiverInput.value = selectedUser;
            chatUserName.innerText = userName;

            // Show chat view on mobile
            showChatView();

            // Mark as read
            try {
                await fetch(`/admin/to/chat/mark-read/${selectedUser}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });

                // Update badge
                const badge = this.querySelector(".unread-badge");
                badge.style.display = "none";
                this.classList.remove('has-unread');
            } catch (error) {
                console.error('Error marking as read:', error);
            }

            // Clear and load messages
            lastMessageId = 0;
            chatBox.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

            await loadMessages();

            // Start auto-refresh for this conversation
            if (messageCheckInterval) {
                clearInterval(messageCheckInterval);
            }
            messageCheckInterval = setInterval(loadMessages, 2000);
        });
    });

    // Load messages
    async function loadMessages() {
        if (!selectedUser || isLoading) return;

        isLoading = true;

        try {
            const res = await fetch(`/admin/to/chat/fetch/${selectedUser}?last_id=${lastMessageId}`);
            const data = await res.json();

            if (lastMessageId === 0) {
                // Initial load - clear and show all messages
                chatBox.innerHTML = '';

                if (data.length === 0) {
                    chatBox.innerHTML = '<div class="empty-state"><i class="fas fa-inbox"></i><h5>কোনো মেসেজ নেই</h5><p class="text-muted">এই ইউজারের সাথে কথোপকথন শুরু করুন</p></div>';
                } else {
                    data.forEach(msg => {
                        appendMessage(msg);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                    });
                }
            } else {
                // Load new messages only
                data.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        appendMessage(msg);
                        lastMessageId = msg.id;
                    }
                });
            }

            scrollToBottom();
        } catch (error) {
            console.error('Error loading messages:', error);
            if (lastMessageId === 0) {
                chatBox.innerHTML = '<div class="empty-state text-danger"><i class="fas fa-exclamation-circle"></i><h5>মেসেজ লোড করতে সমস্যা হয়েছে</h5></div>';
            }
        } finally {
            isLoading = false;
        }
    }

    // Append message to chat
    function appendMessage(msg) {
        const isAdmin = msg.sender_id === {{ Auth::id() }};
        const messageText = msg.message ? escapeHtml(msg.message) : '';

        let bubbleClass = isAdmin ? 'message-admin' : 'message-user';
        let alignment = isAdmin ? 'text-end' : 'text-start';

        // Highlight unread user messages
        if (!isAdmin && !msg.is_read) {
            bubbleClass += ' unread';
        }

        let content = `<div class="${alignment}">`;
        content += `<div class="message-bubble ${bubbleClass}">`;

        if (messageText) {
            content += `<div>${messageText}</div>`;
        }

        if (msg.image) {
            content += `<img src="/${msg.image}" class="message-image" onclick="window.open('/${msg.image}', '_blank')" alt="Image">`;
        }

        content += `<div class="message-time">${msg.time}</div>`;
        content += `</div></div>`;

        chatBox.insertAdjacentHTML('beforeend', content);
    }

    // Scroll to bottom
    function scrollToBottom() {
        setTimeout(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    }

    // Send message
    chatForm.addEventListener("submit", async function(e) {
        e.preventDefault();

        if (!receiverInput.value) {
            alert("প্রথমে একজন ইউজার নির্বাচন করুন!");
            return;
        }

        const message = messageInput.value.trim();
        const hasImage = chatImage.files.length > 0;

        if (!message && !hasImage) {
            alert("মেসেজ বা ছবি দিন!");
            return;
        }

        if (isLoading) return;

        isLoading = true;
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>পাঠানো হচ্ছে...';

        const formData = new FormData(chatForm);

        try {
            const res = await fetch("{{ route('admin.chat.send') }}", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                messageInput.value = '';
                chatImage.value = '';
                imagePreview.style.display = 'none';

                appendMessage(data.chat);
                lastMessageId = Math.max(lastMessageId, data.chat.id);
                scrollToBottom();
            } else {
                alert(data.message || 'মেসেজ পাঠাতে সমস্যা হয়েছে।');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('মেসেজ পাঠাতে সমস্যা হয়েছে।');
        } finally {
            isLoading = false;
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>পাঠান';
        }
    });

    // Enter key to send
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            userSidebar.classList.remove('hide-mobile');
            chatMain.classList.remove('show-mobile');
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (messageCheckInterval) {
            clearInterval(messageCheckInterval);
        }
    });
});
</script>

@endsection
