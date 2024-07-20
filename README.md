# 3SidedCube Academy Laravel API Test - Blog Post Application
Laravel (PHP) Blog Post [CRUD Implemetation]

## Overview

This application is a blog post editor built using Laravel for the backend and a combination of HTML, CSS, and JavaScript for the frontend. It allows users to log in, create, edit, view, and delete blog posts. The frontend uses QuillJS for rich text editing.

## Features

- User Authentication (Login)
- Create, Edit, View, and Delete Blog Posts
- Rich Text Editor using QuillJS
- Bootstrap for responsive design
- FontAwesome for icons

## Prerequisites

- PHP >= 7.3
- Composer
- Node.js & npm (for frontend dependencies)
- A web server (e.g., Apache, Nginx)
- A database (e.g., MySQL, SQLite)

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/abelakponine/cubeacademy-laravel-crud.git
   cd cubeacademy-laravel-crud
   ```

2. **Install Backend Dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies:**
   ```bash
   npm install
   npm run dev
   ```

4. **Environment Configuration:**
   - Copy `.env.example` to `.env` and configure your environment variables, including database credentials and application settings.
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

7. **Start the Application:**
   ```bash
   php artisan serve
   ```

7. **Run PHPUnit test:**
   ```bash
   php artisan test
   ```

## Usage

### Login Page

- **File:** `index.blade.php`
- **Description:** A simple login form where users can log in using their email and password.

### Register Page

- **File:** `register.blade.php`
- **Description:** A simple registration form where users can create accounts their fullname, email and password.

### Create Page

- **File:** `create.blade.php`
- **Description:** A form to create a new blog post using QuillJS as the text editor, with a list of all posts displayed on the sidebar.

### Edit Page

- **File:** `edit.blade.php`
- **Description:** A form to edit an existing blog post with a list of all posts displayed on the sidebar.

### View Post Page

- **File:** `view.blade.php`
- **Description:** A simple page to view post by id, with a list of all posts displayed on the sidebar.

### Scripts and Styles

- **QuillJS:** Used for the rich text editor.
- **Bootstrap:** Used for responsive design and styling.
- **FontAwesome:** Used for icons.
- **Custom CSS and JavaScript:** Used for additional styling and functionality.

### API Endpoints

- **Login:** `api/v1/login`
- **Register Post:** `api/v1/register`
- **View Get:** `api/v1/posts`
- **Create Post:** `api/v1/create`
- **Update Post:** `api/v1/update`
- **Delete Post:** `api/v1/delete`

## Example Code Snippets

### Login Page Script
```html
<script>
    function login() {
        event.preventDefault();
        event.stopImmediatePropagation();
        const form = document.getElementById('loginForm');
        const formData = new FormData(form);
        const url = "{{ route('api.login') }}";

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
```

### Create Page Script
```html
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    function savePost(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        const author_id = JSON.parse(localStorage.getItem('user')).id;
        const authorName = JSON.parse(localStorage.getItem('user')).authorName;
        const email = JSON.parse(localStorage.getItem('user')).email;
        const title = document.getElementById('title').value;
        const content = encodeURIComponent(quill.root.innerHTML);
        const url = "{{ route('api.create') }}";
        const data = { author_id, author: authorName, email, title, content };
        const AuthToken = JSON.parse(localStorage.getItem('user')).token;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Authorization': 'Bearer ' + AuthToken
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            alert('Success: ' + data.message);
            window.location.reload();
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('There was an error creating the post.');
        });
    }

    function deletePost(id) {
        const url = "{{ route('api.delete') }}";
        const data = { id };
        const AuthToken = JSON.parse(localStorage.getItem('user')).token;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Authorization': 'Bearer ' + AuthToken
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            alert('Success: ' + data.message);
            window.location.href = '/create';
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('There was an error deleting the post.');
        });
        return false;
    }
</script>
```

## Contribution

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a Pull Request.

## License

This project is licensed under the MIT License.
