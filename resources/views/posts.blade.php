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
                        <form method="POST" action="">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchPosts();
        });

        function fetchPosts() {
            fetch('/api/posts', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer {{ auth()->user()->createToken('API Token')->plainTextToken }}'
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
                        cardTitle.textContent = post.username;

                        let cardContent = document.createElement('p');
                        cardContent.className = 'card-text';
                        cardContent.textContent = post.content;

                        let hr = document.createElement('hr');

                        let reactDiv = document.createElement('div');
                        reactDiv.id = 'react';

                        let commentLink = document.createElement('a');
                        commentLink.href = '#';
                        commentLink.id = `add-comment-${post.id}`; // Unique ID for comment toggle
                        commentLink.innerHTML = '<i class="fa-regular fa-comment me-2 fa-lg px-4"></i>';

                        let likeLink = document.createElement('a');
                        likeLink.href = '#';
                        likeLink.innerHTML = '<i class="fa-regular fa-thumbs-up me-2 fa-lg px-4"></i>';

                        reactDiv.appendChild(commentLink);
                        reactDiv.appendChild(likeLink);

                        cardBlockDiv.appendChild(cardTitle);
                        cardBlockDiv.appendChild(hr);
                        cardBlockDiv.appendChild(cardContent);
                        cardBlockDiv.appendChild(reactDiv);

                        cardDiv.appendChild(cardBlockDiv);
                        postDiv.appendChild(cardDiv);
                        postsContainer.appendChild(postDiv);

                        // Add event listener for adding comments
                        commentLink.addEventListener('click', function() {
                            toggleCommentArea(post.id);
                        });
                    });
                })
                .catch(error => console.error('Error fetching posts:', error));
        }

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
                newCommentArea.innerHTML =
                    '<form>' +
                    '<textarea class="form-control" rows="2" placeholder="Write a comment..."></textarea>' +
                    '<button type="submit" class="btn btn-success mt-2">Comment</button>' +
                    '</form>';

                postDiv.appendChild(newCommentArea);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
