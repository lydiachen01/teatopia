document.addEventListener('DOMContentLoaded', function () {
    const postForm = document.getElementById('postForm');
    const postsContainer = document.getElementById('posts');

    // Function to create a post element
    function createPostElement(post) {
        const postElement = document.createElement('div');
        postElement.innerHTML = `<strong>${post.username}</strong>: <span style="font-weight: bold;">${post.title}</span> - ${post.content}`;
        return postElement;
    }

    // Fetch initial posts
    fetch('fetch_posts.php')
        .then(response => response.json())
        .then(posts => {
            posts.forEach(post => {
                const postElement = createPostElement(post);
                postsContainer.appendChild(postElement);
            });
        })
        .catch(error => console.error('Error fetching posts:', error));

    postForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(postForm);
        fetch('create_post.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                // Update posts container with new post
                const postElement = createPostElement(data);
                postsContainer.appendChild(postElement);

                // Clear the form
                postForm.reset();
            })
            .catch(error => console.error('Error:', error));
    });
});
