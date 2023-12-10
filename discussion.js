document.addEventListener('DOMContentLoaded', function () {
    const postForm = document.getElementById('postForm');
    const postsContainer = document.getElementById('posts');

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

    // Fetch initial posts (if any)
    fetch('fetch_posts.php')
        .then(response => response.json())
        .then(posts => {
            posts.forEach(post => {
                const postElement = createPostElement(post);
                postsContainer.appendChild(postElement);
            });
        })
        .catch(error => console.error('Error:', error));
});

function createPostElement(post) {
    const postContainer = document.createElement('div');

    // Style for the username
    const usernameElement = document.createElement('div');
    usernameElement.style.fontSize = '18px';
    usernameElement.style.fontWeight = 'bold';
    usernameElement.textContent = post.username;

    // Style for the title
    const titleElement = document.createElement('div');
    titleElement.style.fontSize = '14px';
    titleElement.style.fontWeight = 'bold';
    titleElement.textContent = post.title;

    // Style for the content
    const contentElement = document.createElement('div');
    contentElement.textContent = post.content;

    // Append elements to the post container
    postContainer.appendChild(usernameElement);
    postContainer.appendChild(titleElement);
    postContainer.appendChild(contentElement);

    // Apply some margin between posts
    postContainer.style.marginBottom = '20px';

    return postContainer;
}
