document.getElementById('comment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let content = document.getElementById('comment-content').value;
    let productId = "{{ $product->id }}";

    fetch(`/product/${productId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ content: content })
    })
    .then(response => response.json())
    .then(data => {
        // Tambahkan komentar baru di atas komentar yang ada
        const commentContainer = document.getElementById('comments-container');
        const newComment = `
            <div class="comment-item mb-3 border-bottom pb-2">
                <p><strong>${data.username}</strong></p>
                <p>${data.content}</p>
                <small class="text-muted">${data.created_at}</small>
            </div>
        `;
        commentContainer.innerHTML = newComment + commentContainer.innerHTML;
    })
    .catch(error => console.error('Error:', error));
});
