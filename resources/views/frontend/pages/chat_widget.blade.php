<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .usertoadminchat-hidden {
        display: none !important;
    }

    /* Floating Button */
    .usertoadminchat-floating-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 9998;
        transition: all 0.3s ease;
    }

    .usertoadminchat-floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.4);
    }

    .usertoadminchat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        border: 2px solid white;
    }

    /* Chat Window */
    .usertoadminchat-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 550px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: scale(0);
        transform-origin: bottom right;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .usertoadminchat-window.active {
        transform: scale(1);
        opacity: 1;
    }

    /* Header */
    .usertoadminchat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .usertoadminchat-admin-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .usertoadminchat-admin-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: white;
        color: #667eea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
    }

    .usertoadminchat-title {
        font-size: 16px;
        font-weight: 600;
    }

    .usertoadminchat-admin-status {
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        opacity: 0.9;
    }

    .usertoadminchat-status-dot {
        width: 8px;
        height: 8px;
        background: #2ecc71;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .usertoadminchat-close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .usertoadminchat-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Messages Container */
    .usertoadminchat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f5f7fa;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .usertoadminchat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .usertoadminchat-messages::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    /* Message */
    .usertoadminchat-message {
        display: flex;
        gap: 10px;
        animation: messageSlide 0.3s ease;
    }

    @keyframes messageSlide {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .usertoadminchat-message-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .usertoadminchat-admin .usertoadminchat-message-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
    }

    .usertoadminchat-user .usertoadminchat-message-avatar {
        background: #e2e8f0;
        color: #4a5568;
        order: 2;
    }

    .usertoadminchat-message-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .usertoadminchat-user .usertoadminchat-message-content {
        align-items: flex-end;
    }

    .usertoadminchat-admin-badge {
        font-size: 11px;
        color: #667eea;
        font-weight: 600;
        text-transform: uppercase;
    }

  .usertoadminchat-message-bubble {
        max-width:50%;
        padding: 12px 16px;
        border-radius: 18px;
        overflow-wrap: break-word;
        word-break: keep-all;
        line-height:15px;
        white-space: pre-wrap;
    }

    .usertoadminchat-admin .usertoadminchat-message-bubble {
        background: white;
        color: #2d3748;
        border-bottom-left-radius: 4px;
    }

    .usertoadminchat-user .usertoadminchat-message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .usertoadminchat-message-image {
        margin-top: 8px;
    }

    .usertoadminchat-message-image img {
        max-width: 200px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .usertoadminchat-message-image img:hover {
        transform: scale(1.02);
    }

    .usertoadminchat-message-time {
        font-size: 11px;
        color: #a0aec0;
        padding: 0 5px;
    }

    /* Image Preview */
    .usertoadminchat-image-preview-container {
        padding: 10px 20px;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
        display: none;
        position: relative;
    }

    .usertoadminchat-image-preview-container.active {
        display: block;
    }

    .usertoadminchat-preview-image {
        max-width: 100%;
        max-height: 150px;
        border-radius: 12px;
        object-fit: contain;
    }

    .usertoadminchat-remove-preview {
        position: absolute;
        top: 15px;
        right: 25px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .usertoadminchat-remove-preview:hover {
        background: rgba(0, 0, 0, 0.9);
    }

    /* Input Area */
    .usertoadminchat-input-area {
        background: white;
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
    }

    .usertoadminchat-input-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .usertoadminchat-file-input {
        display: none;
    }

    .usertoadminchat-attach-btn {
        background: none;
        border: none;
        color: #718096;
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.3s;
    }

    .usertoadminchat-attach-btn:hover {
        background: #f7fafc;
        color: #667eea;
    }

    .usertoadminchat-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 16px;
        border-radius: 25px;
        background: #f7fafc;
        font-size: 14px;
        transition: all 0.3s;
    }

    .usertoadminchat-input:focus {
        background: #edf2f7;
    }

    .usertoadminchat-send-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .usertoadminchat-send-btn:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .usertoadminchat-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Loading Indicator */
    .usertoadminchat-loading {
        text-align: center;
        padding: 10px;
        color: #718096;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .usertoadminchat-window {
            width: calc(100% - 20px);
            right: 10px;
            bottom: 90px;
            height: 500px;
        }

        .usertoadminchat-floating-btn {
            right: 20px;
            bottom: 20px;
        }
    }
</style>

<!-- Floating Button -->
<button class="usertoadminchat-floating-btn" id="usertoadminchatButton">
    <i class="fas fa-comments"></i>
    <span class="usertoadminchat-badge usertoadminchat-hidden" id="usertoadminchatBadge">0</span>
</button>

<!-- Chat Window -->
<div class="usertoadminchat-window" id="usertoadminchatWindow">
    <div class="usertoadminchat-header">
        <div class="usertoadminchat-admin-info">
            <div class="usertoadminchat-admin-avatar">A</div>
            <div class="usertoadminchat-admin-details">
                <div class="usertoadminchat-title">Admin Support</div>
                <div class="usertoadminchat-admin-status">
                    <span class="usertoadminchat-status-dot"></span>Online
                </div>
            </div>
        </div>
        <button class="usertoadminchat-close-btn" id="usertoadminchatCloseButton">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="usertoadminchat-messages" id="usertoadminchatMessages">
        <!-- Messages will be loaded here -->
    </div>

    <!-- Image Preview -->
    <div class="usertoadminchat-image-preview-container" id="usertoadminchatImagePreviewContainer">
        <img src="" alt="Preview" class="usertoadminchat-preview-image" id="usertoadminchatPreviewImage">
        <button class="usertoadminchat-remove-preview" id="usertoadminchatRemovePreviewBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Input Area -->
    <div class="usertoadminchat-input-area">
        <div class="usertoadminchat-input-controls">
            <input type="file" class="usertoadminchat-file-input" id="usertoadminchatFileInput" accept="image/jpeg,image/png,image/jpg,image/gif">
            <button class="usertoadminchat-attach-btn" id="usertoadminchatAttachButton">
                <i class="fas fa-paperclip"></i>
            </button>
            <input type="text" class="usertoadminchat-input" id="usertoadminchatInput" placeholder="লিখুন...">
            <button class="usertoadminchat-send-btn" id="usertoadminchatSendButton">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let selectedImage = null;
        let messageCheckInterval = null;
        let lastMessageId = 0;
        let isLoading = false;

        // Setup AJAX with CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Cache DOM elements
        const floatingBtn = $('#usertoadminchatButton');
        const chatWindow = $('#usertoadminchatWindow');
        const closeBtn = $('#usertoadminchatCloseButton');
        const sendBtn = $('#usertoadminchatSendButton');
        const input = $('#usertoadminchatInput');
        const messagesContainer = $('#usertoadminchatMessages');
        const fileInput = $('#usertoadminchatFileInput');
        const attachBtn = $('#usertoadminchatAttachButton');
        const previewContainer = $('#usertoadminchatImagePreviewContainer');
        const previewImage = $('#usertoadminchatPreviewImage');
        const removePreviewBtn = $('#usertoadminchatRemovePreviewBtn');
        const badge = $('#usertoadminchatBadge');

        // Open Chat Window
        floatingBtn.on('click', function() {
            chatWindow.addClass('active');
            loadMessages();
            markMessagesAsRead();
            badge.addClass('usertoadminchat-hidden');

            if (!messageCheckInterval) {
                messageCheckInterval = setInterval(checkForNewMessages, 3000);
            }
        });

        // Close Chat Window
        closeBtn.on('click', function() {
            chatWindow.removeClass('active');
            if (messageCheckInterval) {
                clearInterval(messageCheckInterval);
                messageCheckInterval = null;
            }
        });

        // Attach Image
        attachBtn.on('click', function() {
            fileInput.click();
        });

        fileInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2048 * 1024) {
                    alert('ছবি খুব বড়। সর্বোচ্চ ২ MB অনুমোদিত।');
                    fileInput.val('');
                    return;
                }

                selectedImage = file;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.attr('src', e.target.result);
                    previewContainer.addClass('active');
                };
                reader.readAsDataURL(file);
            }
        });

        removePreviewBtn.on('click', function() {
            selectedImage = null;
            fileInput.val('');
            previewContainer.removeClass('active');
        });

        // Send Message
        function sendMessage() {
            const message = input.val().trim();

            if (!message && !selectedImage) {
                return;
            }

            if (isLoading) {
                return;
            }

            const adminId = 1; // Admin ID
            const formData = new FormData();
            formData.append('receiver_id', adminId);

            if (message) {
                formData.append('message', message);
            }

            if (selectedImage) {
                formData.append('image', selectedImage);
            }

            isLoading = true;
            sendBtn.prop('disabled', true);

            $.ajax({
                url: '/usertoadminchat/send',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        input.val('');
                        selectedImage = null;
                        fileInput.val('');
                        previewContainer.removeClass('active');

                        // Append sent message immediately
                        if (response.chat) {
                            appendMessage(response.chat);
                            lastMessageId = response.chat.id;
                            scrollToBottom();
                        }
                    } else {
                        alert(response.message || 'মেসেজ পাঠাতে সমস্যা হয়েছে।');
                    }
                },
                error: function(xhr) {
                    console.error('Error sending message:', xhr);
                    let errorMsg = 'মেসেজ পাঠাতে সমস্যা হয়েছে।';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                },
                complete: function() {
                    isLoading = false;
                    sendBtn.prop('disabled', false);
                }
            });
        }

        sendBtn.on('click', sendMessage);

        input.on('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Load Messages
        function loadMessages() {
            if (isLoading) return;

            isLoading = true;

            $.ajax({
                url: '/usertoadminchat/fetch',
                type: 'GET',
                data: { last_id: 0 },
                success: function(response) {
                    if (response.success) {
                        displayMessages(response.messages);
                        if (response.messages.length > 0) {
                            lastMessageId = response.messages[response.messages.length - 1].id;
                        }
                        scrollToBottom();
                    }
                },
                error: function(xhr) {
                    console.error('Error loading messages:', xhr);
                    messagesContainer.html('<div class="usertoadminchat-loading">মেসেজ লোড করতে সমস্যা হয়েছে।</div>');
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }

        // Check For New Messages
        function checkForNewMessages() {
            $.ajax({
                url: '/usertoadminchat/fetch',
                type: 'GET',
                data: { last_id: lastMessageId },
                success: function(response) {
                    if (response.success && response.messages.length > 0) {
                        response.messages.forEach(msg => appendMessage(msg));
                        lastMessageId = response.messages[response.messages.length - 1].id;
                        scrollToBottom();

                        // Mark as read if chat is open
                        if (chatWindow.hasClass('active')) {
                            markMessagesAsRead();
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error checking new messages:', xhr);
                }
            });
        }

        // Display Messages
        function displayMessages(messages) {
            messagesContainer.empty();
            if (messages.length === 0) {
                messagesContainer.html('<div class="usertoadminchat-loading">কোনো মেসেজ নেই।</div>');
            } else {
                messages.forEach(msg => appendMessage(msg));
            }
        }

        // Append Message
        function appendMessage(msg) {
            const isAdmin = msg.is_admin;
            const messageText = msg.message ? escapeHtml(msg.message) : '';

            let messageHtml = `
                <div class="usertoadminchat-message ${isAdmin ? 'usertoadminchat-admin' : 'usertoadminchat-user'}">
                    <div class="usertoadminchat-message-avatar">
                        ${isAdmin ? 'A' : '<i class="fas fa-user"></i>'}
                    </div>
                    <div class="usertoadminchat-message-content">
                        ${isAdmin ? '<div class="usertoadminchat-admin-badge">Admin</div>' : ''}
                        <div class="usertoadminchat-message-bubble">
            `;

            if (messageText) {
                messageHtml += `<div>${messageText}</div>`;
            }

            if (msg.image) {
                messageHtml += `
                    <div class="usertoadminchat-message-image">
                        <img src="${msg.image}" alt="Image" onclick="window.open('${msg.image}', '_blank')">
                    </div>
                `;
            }

            messageHtml += `
                        </div>
                        <div class="usertoadminchat-message-time">${msg.time}</div>
                    </div>
                </div>
            `;

            messagesContainer.append(messageHtml);
        }

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

        // Update Unread Count
        function updateUnreadCount() {
            $.ajax({
                url: '/usertoadminchat/unread-count',
                type: 'GET',
                success: function(response) {
                    if (response.success && response.count > 0) {
                        badge.text(response.count);
                        badge.removeClass('usertoadminchat-hidden');
                    } else {
                        badge.addClass('usertoadminchat-hidden');
                    }
                },
                error: function(xhr) {
                    console.error('Error updating unread count:', xhr);
                }
            });
        }

        // Mark Messages as Read
        function markMessagesAsRead() {
            $.ajax({
                url: '/usertoadminchat/mark-read',
                type: 'POST',
                success: function() {
                    badge.addClass('usertoadminchat-hidden');
                },
                error: function(xhr) {
                    console.error('Error marking messages as read:', xhr);
                }
            });
        }

        // Scroll to Bottom
        function scrollToBottom() {
            setTimeout(function() {
                messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
            }, 100);
        }

        // Initial unread count check
        updateUnreadCount();

        // Check for new messages every 5 seconds when chat is closed
        setInterval(function() {
            if (!chatWindow.hasClass('active')) {
                updateUnreadCount();
            }
        }, 5000);
    });
</script>
