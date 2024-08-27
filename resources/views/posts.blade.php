<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('build/assets/css/app.css') }}">
</head>

<body>
    <div class="mt-3" style="margin-left: 460px; display: inline-block;">
        <!-- Button trigger modal -->
        <span class="rounded" style="border-radius:30%; background-color: #f8f9fa; padding: 10px;">
            <i class="fa-solid fa-lightbulb me-2 fa-lg"></i> What is on your mind!
            <i class="fa-solid fa-plus"
                style="border-radius:30%; width: 20px; height: 40px; margin-left: 400px; margin-bottom: 5px; cursor:pointer"
                data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
        </span>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h3 class="fs-5" id="exampleModalLabel">Add your thought:</h3>
                        {{-- comment form --}}
                        <form id="post-form">
                            @csrf
                            <div class="mb-3">
                                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Publish</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Container -->
    <div id="posts" class="container mt-5">
        <!-- Posts will be dynamically inserted here -->
    </div>

    <!-- show comment Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const authenticatedUserId = '{{ auth()->user()->id }}'; // Authenticated user's ID

        // Function to handle form submission
        document.getElementById('post-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let token =
                '{{ auth()->user()->createToken('API Token')->plainTextToken }}'; // Ensure you have the token
            let description = document.querySelector('textarea[name="description"]').value;
            let userId = '{{ auth()->user()->id }}'; // Ensure you have the authenticated user's ID

            fetch('/api/posts', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        content: description,
                        title: 'Sample Title', // Replace with actual data
                        user_id: userId // Corrected property name
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    // Clear the textarea on success
                    document.querySelector('textarea[name="description"]').value = '';
                    var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                    modal.hide();
                    fetchPosts(); // Refresh the posts list
                })
                .catch((error) => {
                    console.error('Error creating post:', error);
                    alert('Error creating post: ' + (error.message || JSON.stringify(error)));
                });
        });
        ////////////////////

        // Function to fetch posts from the server

        document.addEventListener('DOMContentLoaded', function() {
            fetchPosts();
        });

        function fetchPosts() {
            fetch('/api/posts', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer {{ auth()->user()->createToken('API Token')->plainTextToken }}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let postsContainer = document.getElementById('posts');
                    postsContainer.innerHTML = '';

                    data.forEach(post => {
                        // Create post elements
                        let postDiv = document.createElement('div');
                        postDiv.className = 'col-md-4 mb-4';
                        postDiv.id = `post-${post.id}`; // Unique ID for each post

                        let cardDiv = document.createElement('div');
                        cardDiv.className = 'card';

                        let cardBlockDiv = document.createElement('div');
                        cardBlockDiv.className = 'card-body';

                        let cardTitle = document.createElement('h6');
                        cardTitle.className = 'card-title';
                        cardTitle.textContent = post.user.name; // Ensure this field exists in your API response

                        let cardContent = document.createElement('p');
                        cardContent.className = 'card-text';
                        cardContent.textContent = post.content;

                        let hr = document.createElement('hr');

                        let reactDiv = document.createElement('div');
                        reactDiv.id = 'react';
                        let commentConters = document.createElement('a');
                        commentConters.href = '#';
                        commentConters.innerHTML = post.comments.length + ' comments';
                        commentConters.style = "text-decoration: none;";
                        commentConters.id = `comment-counters-${post.id}`;

                        // Correctly set the data attributes using setAttribute method
                        commentConters.setAttribute('data-bs-toggle', 'modal');
                        commentConters.setAttribute('data-bs-target', '#staticBackdrop');

                        let commentLink = document.createElement('a');
                        commentLink.href = '#';
                        commentLink.id = `add-comment-${post.id}`; // Unique ID for comment toggle
                        commentLink.innerHTML = '<i class="fa-regular fa-comment me-2 fa-lg px-4"></i>';


                        let likeLink = document.createElement('a');
                        likeLink.href = '#';
                        likeLink.innerHTML = '<i class="fa-regular fa-thumbs-up me-2 fa-lg px-4"></i>';

                        reactDiv.appendChild(commentConters);
                        reactDiv.appendChild(commentLink);
                        reactDiv.appendChild(likeLink);

                        cardBlockDiv.appendChild(cardTitle);
                        cardBlockDiv.appendChild(hr);
                        cardBlockDiv.appendChild(cardContent);
                        cardBlockDiv.appendChild(reactDiv);

                        cardDiv.appendChild(cardBlockDiv);
                        postDiv.appendChild(cardDiv);
                        postsContainer.appendChild(postDiv);

                        // Add event listener for adding comments addcomments
                        commentLink.addEventListener('click', function() {
                            toggleCommentArea(post.id);
                        });

                        // Add event listener for comment counters fetchComments
                        commentConters.addEventListener('click', function() {
                            openCommentsModal(post.id);
                        });
                    });
                })
                .catch(error => console.error('Error fetching posts:', error));
        }
        //// area for comments
        function toggleCommentArea(postId) {
            let postDiv = document.getElementById(`post-${postId}`);
            let commentArea = postDiv.querySelector('.comment-area');

            if (commentArea) {
                // If comment area exists, remove it
                commentArea.remove();
            } else {
                // Create a new comment area
                let newCommentArea = document.createElement('div');
                newCommentArea.className = 'comment-area mt-2';
                newCommentArea.innerHTML = `
                    <form id="comment-form-${postId}">
                        <textarea class="form-control" rows="2" placeholder="Write a comment..."></textarea>
                        <button type="submit" class="btn btn-success mt-2">Comment</button>
                    </form>
                `;

                postDiv.appendChild(newCommentArea);

                // Add event listener for submitting comments
                let commentForm = document.getElementById(`comment-form-${postId}`);
                commentForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    let token =
                        '{{ auth()->user()->createToken('API Token')->plainTextToken }}'; // Ensure you have the token
                    let commentContent = commentForm.querySelector('textarea').value;
                    let userId = '{{ auth()->user()->id }}'; // Ensure you have the authenticated user's ID
                    /// add comment
                    fetch(`/api/posts/${postId}/comments`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            },
                            body: JSON.stringify({
                                content: commentContent,
                                post_id: postId,
                                user_id: userId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                            commentForm.querySelector('textarea').value = ''; // Clear the textarea on success
                            fetchPosts(); // Refresh the posts list
                        })
                        .catch(error => console.error('Error creating comment:', error));
                });
            }
        }
        /// show comments
        function openCommentsModal(postId) {
            const token = '{{ auth()->user()->createToken('API Token')->plainTextToken }}'; // Ensure you have the token
            const modalBody = document.querySelector('#staticBackdrop .modal-body'); // Select the modal body

            // Clear any existing content in the modal body
            modalBody.innerHTML = '<p>Loading comments...</p>';

            // Fetch comments from the server
            fetch(`/api/posts/${postId}/comments`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Clear loading text
                    modalBody.innerHTML = '';

                    if (data.length === 0) {
                        modalBody.innerHTML = '<p>No comments available.</p>';
                    } else {
                        // Create a list of comments
                        let commentsList = document.createElement('ul');
                        commentsList.className = 'list-group';

                        data.forEach(comment => {
                            let commentItem = document.createElement('li');
                            commentItem.className =
                                'list-group-item d-flex justify-content-between align-items-center';

                            // Build the comment HTML
                            commentItem.innerHTML = `
                    <span>${comment.content}</span>
                    <span class="badge bg-primary rounded-pill">${comment.user.name}</span>
                `;

                            // Check if the comment's user_id matches the authenticated user
                            if (comment.user_id == authenticatedUserId) {
                                // Create a "Delete" button
                                let deleteButton = document.createElement('span');
                                deleteButton.className =
                                    'badge bg-danger rounded-pill ms-2'; // Add margin for spacing
                                deleteButton.textContent = 'Delete';
                                deleteButton.style.cursor = 'pointer';

                                // Add click event listener for deleting the comment
                                deleteButton.addEventListener('click', function() {
                                    deleteComment(postId, comment.id);
                                });

                                // Append the delete button to the comment item
                                commentItem.appendChild(deleteButton);
                            }

                            commentsList.appendChild(commentItem);
                        });

                        modalBody.appendChild(commentsList);
                    }
                })
                .catch(error => {
                    console.error('Error fetching comments:', error);
                    modalBody.innerHTML = '<p>Error loading comments.</p>';
                });
        }
        ///// delete comment
        function deleteComment(postId, commentId) {
            const token = '{{ auth()->user()->createToken('API Token')->plainTextToken }}'; // Ensure you have the token

            fetch(`/api/posts/${postId}/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Comment deleted successfully:', data);
                    // Refresh comments after deletion
                    openCommentsModal(postId);
                })
                .catch(error => {
                    console.error('Error deleting comment:', error);
                    alert('Error deleting comment: ' + (error.message || JSON.stringify(error)));
                });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>



</body>

</html>
