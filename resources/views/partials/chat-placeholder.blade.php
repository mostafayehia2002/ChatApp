<div id="noChatPlaceholder" class="d-flex flex-column justify-content-center align-items-center p-0 w-100"
    style="height: 90vh; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); position: relative; overflow: hidden;">

    <!-- Background Decoration -->
    <div style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(102, 126, 234, 0.1), transparent); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(118, 75, 162, 0.08), transparent); border-radius: 50%;"></div>

    <!-- Content -->
    <div style="position: relative; z-index: 10; text-align: center;">
        <div style="margin-bottom: 24px;">
            <i class="fas fa-comments" style="font-size: 64px; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
        </div>

        <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
            Welcome to RealTimeChat
        </h2>

        <p style="font-size: 15px; color: #6b7280; margin-bottom: 28px; max-width: 360px;">
            Select a conversation from the sidebar or start a new one to begin chatting with your friends.
        </p>

        <button class="btn" data-bs-toggle="modal" data-bs-target="#addContactModal"
                style="padding: 12px 28px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <i class="fas fa-comment-dots"></i>
            Start New Conversation
        </button>
    </div>
</div>
