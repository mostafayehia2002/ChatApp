console.log('scripts.js loaded');
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        // Mobile sidebar toggle
        sidebarToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('show');
            console.log('Sidebar toggled, classes:', sidebar.className);
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                // Only apply on mobile
                if (sidebar && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Close sidebar when clicking a conversation link
        const conversationLinks = sidebar.querySelectorAll('a');
        conversationLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    }

    const messagesDiv = document.getElementById('messages');
    if (!messagesDiv) return;
    scrollMessagesToBottom(messagesDiv);
    initInfiniteScroll(messagesDiv);
});


    function scrollMessagesToBottom(messagesDiv) {
    if (!messagesDiv) return;
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function initInfiniteScroll(messagesDiv) {
    if (!messagesDiv) return;

    let isLoading = false;
    let hasMore = true;
    const loader = document.getElementById('messagesLoader');

    async function loadMoreMessages() {
        if (isLoading || !hasMore) return;

        const firstMessage = messagesDiv.querySelector('[data-message-id]');
        if (!firstMessage) return;

        const conversationId = messagesDiv.dataset.conversationId;
        const lastMessageId = firstMessage.getAttribute('data-message-id');

        isLoading = true;

        if (loader) {
            loader.classList.remove('d-none');
        }

        const oldScrollHeight = messagesDiv.scrollHeight;

        try {
            const response = await fetch(`/conversations/${conversationId}/messages?last_message_id=${lastMessageId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (!data.html || data.count === 0) {
                hasMore = false;
                return;
            }

            messagesDiv.insertAdjacentHTML('afterbegin', data.html);

            const newScrollHeight = messagesDiv.scrollHeight;
            messagesDiv.scrollTop = newScrollHeight - oldScrollHeight;
        } catch (error) {
            console.error('Error loading more messages:', error);
        } finally {
            isLoading = false;

            if (loader) {
                loader.classList.add('d-none');
            }
        }
    }

    messagesDiv.addEventListener('scroll', function () {
        if (messagesDiv.scrollTop <= 20) {
            loadMoreMessages();
        }
    });
}

