<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 400px;
            width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .input-field {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            width: 100%;
            padding: 10px;
            margin: 20px 0;
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
        .register-link {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="font-size:22px;">3SC Laravel API Test - Abel Akponine</h1>
        <h2>Login</h2>
        <form id="loginForm" method="post" action="<?=route('api.login')?>">
            @csrf
            @method('post')
            <input type="email" id="email" class="input-field" name="email" placeholder="Email" required>
            <input type="password" id="password" class="input-field" name="password" placeholder="Password" required>
            <button type="button" class="button" onclick="login()">Login</button>
        </form>
        <a href="<?= route('blog.register')?>" class="register-link">Register</a>
    </div>

    <script>
        
        function login() {
            window.event.preventDefault();
            window.event.stopImmediatePropagation();
            // Get form data
            const form = document.getElementById('loginForm');
            const formData = new FormData(form);
            const url = "<?=route('api.login')?>";

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Login successful!');
                    localStorage.setItem('user', JSON.stringify({
                        id: data.user.id,
                        authorName: data.user.name,
                        email: data.user.email,
                        token: data.token
                    }));

                    // Redirect
                    window.location.href = '/create';
                } else {
                    alert('Login failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error logging in.');
            });
        }
    </script>
</body>
</html>
