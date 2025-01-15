import axios from 'axios';
import Echo from 'laravel-echo';

axios.defaults.withCredentials = true;

document.addEventListener('DOMContentLoaded', function () {
    // Mengatur token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found!');
        return;
    }
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

    const chatDataElement = document.getElementById('chat-data');
    if (!chatDataElement) {
        console.error('Chat data element not found!');
        return;
    }

    const username = chatDataElement.getAttribute('data-username');
    const conversationId = chatDataElement.getAttribute('data-conversation-id');
    const userId = parseInt(chatDataElement.getAttribute('data-user-id'));

    const EchoInstance = new Echo({
        broadcaster: 'socket.io',
        host: `${window.location.hostname}:6001`,
        transports: ['websocket', 'polling'],
    });

    // Mendengarkan pesan yang dikirim ke channel percakapan tertentu
    EchoInstance.private(`conversation.${conversationId}`)
        .listen('MessageSent', (data) => {
            const isSender = data.sender_id === userId;

            // Menambahkan pesan baru ke UI
            addMessageToUI({
                sender: data.sender_name,
                message: data.message,
                timestamp: new Date(data.timestamp).toLocaleString(),
            }, isSender);

            // Setelah menambahkan pesan baru, scroll otomatis ke bawah
            const messagesBox = document.getElementById('messages-box');
            if (messagesBox) {
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
        })
        .error((error) => {
            console.error('Echo connection error:', error);
        });

    // Fungsi untuk menambah pesan ke UI
    function addMessageToUI(data, isSender) {
        const messagesBox = document.getElementById('messages-box');
        if (!messagesBox) return;

        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message-item', 'mb-3');
        messageDiv.innerHTML = `
            <div class="${isSender ? 'text-right' : 'text-left'}">
                <p class="mb-1"><strong>${data.sender}</strong></p>
                <p class="bg-light p-2 rounded d-inline-block">
                    ${data.message}
                </p>
                <small class="text-muted d-block">${data.timestamp}</small>
            </div>
        `;
        messagesBox.appendChild(messageDiv);
    }

    // Fungsi untuk mengirim pesan
    function sendMessage(content) {
        return axios.post(`/api/conversations/${conversationId}/messages`, { content })
            .then(response => {
                if (response.status === 200) {
                    addMessageToUI({
                        sender: username,
                        message: content,
                        timestamp: new Date().toLocaleString(),
                    }, true);
                    document.getElementById('message-content').value = '';
                }
            })
            .catch(error => {
                console.error('Send message error:', error.response?.data || error.message);
                alert('Failed to send message. Please try again.');
            });
    }

    // Event listener untuk form kirim pesan
    document.getElementById('message-form')?.addEventListener('submit', function (e) {
        e.preventDefault();

        const content = document.getElementById('message-content')?.value.trim();
        if (!content) {
            alert('Message cannot be empty!');
            return;
        }

        const sendButton = e.target.querySelector('button[type="submit"]');
        sendButton.disabled = true;

        sendMessage(content).finally(() => {
            sendButton.disabled = false;
        });
    });

    // Pastikan untuk scroll ke bawah ketika halaman dimuat
    const messagesBox = document.getElementById('messages-box');
    if (messagesBox) {
        messagesBox.scrollTo(0, messagesBox.scrollHeight);
    }
});

