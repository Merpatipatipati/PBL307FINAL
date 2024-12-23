document.addEventListener("DOMContentLoaded", function () {
    const detailsButtons = document.querySelectorAll(".details-btn");

    detailsButtons.forEach(button => {
        button.addEventListener("click", function () {
            const postId = this.getAttribute("data-post-id"); // Use post ID instead of chat ID
            fetch(`/admin/posts/${postId}`)  // Update the route to fetch post details
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Failed to fetch post details.");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        displayPostDetail(data.post);  // Display post details
                    } else {
                        alert(data.message || "Failed to load post.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching post:", error);
                    alert("An error occurred while fetching the post.");
                });
        });
    });
});

function displayPostDetail(post) {
    const postDetail = document.getElementById("post-detail");
    const postDetailBody = document.getElementById("post-detail-body");

    // Set the header (Post title and user)
    document.getElementById("post-detail-header-name").textContent = `${post.title} by ${post.user.username}`;

    // Populate post content (assuming 'content' contains the body of the post)
    postDetailBody.innerHTML = `
        <div class="post-content">
            <p>${post.content}</p>
            <p><strong>Category:</strong> ${post.category}</p>
            <p><strong>Tags:</strong> ${post.tags.join(", ")}</p>
            ${post.image_url ? `<img src="${post.image_url}" alt="${post.title}" style="width: 100%;">` : `<span>No Image</span>`}
        </div>
    `;

    // Show post detail
    postDetail.style.display = "block";
}

function closePostDetail() {
    const postDetail = document.getElementById("post-detail");
    postDetail.style.display = "none";
}
