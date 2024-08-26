<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>main</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('build/assets/css/app.css') }}">

</head>

<body>
    <div class=" mt-3 " style="margin-left: 460px; display: inline-block;">
        <!-- Button trigger modal -->
        <span class="rounded  " style="border-radius:30% ;background-color: #f8f9fa;padding: 10px;"><i
                class="fa-solid fa-lightbulb me-2 fa-lg"></i></i> What is on your mind !
            <i class="fa-solid fa-plus"
                style="border-radius:30% ;width: 20px;height: 40px;margin-left: 400px ; margin-bottom: 5px; cursor:pointer"
                data-bs-toggle="modal" data-bs-target="#exampleModal"></i>


    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h3 class=" fs-5" id="exampleModalLabel">Add your though :</h3>
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                {{-- @error('description')
                                    <div class="alert alert-danger">Post cannot be empty</div>
                                @enderror --}}
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
    <div id='1' class="col-md-4">
        <div class="card">
            <div class="card-block">
                <h6 class="card-title">username</h6>
                <hr>
                <p class="card-text p-y-1">content</p>
                <div id="react">
                    <a href="#" id="add-comment"><i class="fa-regular fa-comment me-2 fa-lg px-4"></i></a>
                    <a href="#"><i class="fa-regular fa-thumbs-up me-2 fa-lg px-4"></i></a>
                </div>

            </div>
        </div>
    </div>

    </div>
    <script>
        var toggle = 0;
        document.getElementById('add-comment').addEventListener('click', function() {
            if (toggle == 0) {
                toggle = 1;
                var comment_area = document.createElement('div');
                comment_area.innerHTML =
                    '<form>' +
                    '<textarea class="form-control" rows="2"placeholder="Write a comment..."></textarea>' +
                    '<button type="submit" class="btn btn-success">Comment</button>' +
                    '</form>';
                document.getElementById('1').appendChild(comment_area);
            } else {
                toggle = 0;
                document.getElementById('1').lastElementChild.remove();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
