<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .login-link {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="font-size:22px;">3SC Laravel API Test - Abel Akponine</h1>
        <h2>Register</h2>
        <form id="registerForm" method="post" action="<?=route('api.register')?>">
            @csrf
            @method('post')
            <input type="text" id="name" class="input-field" name="name" placeholder="Full Name" required>
            <input type="email" id="email" class="input-field" name="email" placeholder="Email" required>
            <input type="password" id="password" class="input-field" name="password" placeholder="Password" required>
            <input type="password" id="password_confirmation" class="input-field" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="button" class="button" onclick="register()">Register</button>
        </form>
        <a href="<?=route('blog.index')?>" class="login-link">Login</a>
    </div>

    <script>
        function register() {
            // Get form data
            const form = document.getElementById('registerForm');
            const formData = new FormData(form);
            const url = "<?=route('api.register')?>";
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                if (data.success) {
                    alert('Registration successful!');
                    localStorage.setItem('user', JSON.stringify({
                        id: data.user.id,
                        authorName: data.user.name,
                        email: data.user.email,
                        token: data.token
                    }));

                    window.location.href = '/create';
                } else {
                    alert('Registration failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error registering.');
            });

            return false;
        }
    </script>
</body>
</html>
