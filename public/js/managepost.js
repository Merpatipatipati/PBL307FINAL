function submitComment(postId) {
    const commentContent = document.getElementById('comment-content-' + postId).value;
    if (commentContent.trim() === '') return alert('Komentar tidak boleh kosong');
    
    fetch(`/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ content: commentContent }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const comment = data.comment;
            const commentHtml = `
                <div class="comment-item mb-3" id="comment-${comment.id}">
                    <strong>${comment.user.username}</strong>
                    <p class="mb-1">${comment.content}</p>
                </div>
            `;
            document.getElementById('comments-container-' + postId).innerHTML += commentHtml;
            document.getElementById('comment-content-' + postId).value = ''; // Clear input
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitReply(commentId) {
    const replyContent = document.getElementById('reply-content-' + commentId).value;
    if (replyContent.trim() === '') return alert('Balasan tidak boleh kosong');
    
    fetch(`/comments/${commentId}/replies`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ content: replyContent }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const reply = data.reply;
            const replyHtml = `
                <div class="reply-item mb-2 ms-3">
                    <strong>${reply.user.username}</strong>
                    <p class="mb-1">${reply.content}</p>
                </div>
            `;
            document.getElementById('replies-' + commentId).innerHTML += replyHtml;
            document.getElementById('reply-content-' + commentId).value = ''; // Clear input
        }
    })
    .catch(error => console.error('Error:', error));
}