<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog Post Editor</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <style>
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .title-input, .description-input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .editor-container {
            height: 400px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .d-flex {
            display: flex;
        }
        .flex-column {
            flex-direction: column;
        }
        #side-bar .title {
            font-size: 1.5rem;
        }
        #side-bar .author {
            font-size: 1rem;
        }
        #side-bar {
            max-height: calc(100% - 40px);
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="d-flex h-100">
        <div class="container w-75 mx-auto">
            <div class="mb-3">
                <a href="<?=route('blog.create')?>"><button class="btn no-bg" style="text-decoration: underline;outline:none;box-shadow:none;"><i class="fas fa-house"></i> Go Home</button></a>
            </div>

            <h1 style="font-size:1rem;">Viewing Post (ID::<?=$post->id?>)</h1>
            <br/>

            <div class="card border-0">
                <h1 class="card-title px-1"><?=$post->title?></h1>
                <h2 class="px-2 text-secondary" style="font-size:1.2rem;"><small>by</small> <?=$post->author?></h2>
                <p></p>
                <span class="card-body" style="font-size:1rem;"><?=urldecode($post->content)?></span>
            </div>
        </div>
        <div id="side-bar" class="pt-5 w-25 mx-5">
            <ul class="m-0 px-0" style="width:100%;height:100%;overflow:auto;">
                <?php
                    foreach ($all_posts as $post){
                ?>
                    <li class="card p-3">
                        <div class="d-flex flex-column">
                            <div>
                                <h1 class="title"><?=$post->title?></h1>
                                <h2 class="author"><small>by</small> <?=$post->author?></h2>
                            </div>
                            <div>
                                <a href="/post/<?=$post->id?>"><button class="btn btn-secondary">View Post</button></a>
                                <a href="/edit/<?=$post->id?>"><button class="btn btn-warning">Edit</button></a>
                                <button class="btn btn-danger" onclick="deletePost(<?=$post->id?>)">delete</button>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script>
        
        const AuthToken = JSON.parse(localStorage.getItem('user')).token;

        function deletePost(id) {
            
            // Send the data to the server
            const url = "<?php echo route('api.delete'); ?>";
            const data = { id };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Authorization': 'Bearer ' + AuthToken
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                alert('Success: '+ data.message);
                window.location.reload();
            })
            .catch((error) => {
                console.error('Error:', error);
            });

            return false;
        }
    </script>
</body>
</html>
