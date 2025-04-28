function confirmUpdate(postId, category) {
    if (confirm("Are you sure you want to update this post?")) {
        window.location.href = "../../api/updatePost.php?id=" + postId + "&category=" + category;
    }
}
