document.addEventListener('DOMContentLoaded', function () {
    const launcher = document.getElementById('te-chat-launcher');
    const window = document.getElementById('te-chat-window');
    const closeBtn = document.getElementById('te-chat-close');
    const sendBtn = document.getElementById('te-chat-send');
    const input = document.getElementById('te-chat-input');
    const messages = document.getElementById('te-chat-messages');

    let isOpen = false;

    // Toggle Chat
    function toggleChat() {
        isOpen = !isOpen;
        if (isOpen) {
            window.classList.add('open');
            input.focus();
        } else {
            window.classList.remove('open');
        }
    }

    launcher.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleChat();
    });

    // Send Message Logic
    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        // 1. Add User Message
        appendMessage(text, 'user');
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        // 2. Add Loading Indicator
        const loadingId = appendLoading();

        // 3. Call API
        try {
            const response = await fetch('/wp-json/te/v1/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': teChatSettings.nonce || '' // If we use nonces in future
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();

            // Remove Loading
            removeMessage(loadingId);

            if (data.answer) {
                appendMessage(formatResponse(data.answer), 'bot');
            } else {
                appendMessage("Desculpe, tive um problema de conexão. Tente novamente.", 'bot');
            }

        } catch (error) {
            console.error(error);
            removeMessage(loadingId);
            appendMessage("Erro ao conectar com a assistente.", 'bot');
        } finally {
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
            scrollToBottom();
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    // Helper: Append Message
    function appendMessage(html, sender) {
        const div = document.createElement('div');
        div.classList.add('chat-message', sender);
        div.innerHTML = html; // Using innerHTML to allow basic formatting if needed
        messages.appendChild(div);
        scrollToBottom();
        return div.id = 'msg-' + Date.now();
    }

    // Helper: Loading
    function appendLoading() {
        const div = document.createElement('div');
        div.classList.add('chat-message', 'bot', 'loading');
        div.innerHTML = '<div class="typing-dots"><span></span><span></span><span></span></div>';
        messages.appendChild(div);
        scrollToBottom();
        return div;
    }

    // Helper: Remove Message (for loading)
    function removeMessage(elementOrId) {
        if (typeof elementOrId === 'string') {
            const el = document.getElementById(elementOrId);
            if (el) el.remove();
        } else if (elementOrId instanceof HTMLElement) {
            elementOrId.remove();
        }
    }

    // Helper: Scroll
    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    // Helper: Format Response (Basic Markdown-ish to HTML)
    function formatResponse(text) {
        // Simple bold
        let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Line breaks
        formatted = formatted.replace(/\n/g, '<br>');
        return formatted;
    }
});
