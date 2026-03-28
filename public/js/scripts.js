
document.addEventListener('DOMContentLoaded', function () {
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

