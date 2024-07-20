# OpenAPI (Swagger) Documentation for the `create` Endpoint

## Create a New Post

### POST /v1/create

**Summary**: Create a new post

**Tags**: Posts

### Request

**Content-Type**: `application/json`

#### Request Body

```json
{
    "author_id": 1,
    "author": "John Doe",
    "email": "john@example.com",
    "title": "New Blog Post",
    "content": "This is the content of the blog post."
}
```

# Required Properties
+ `author_id` (integer): ID of the author.
+ `author` (string): Name of the author.
+ `email` (string): Email of the author (format: email).
+ `title` (string): Title of the post.
+ `content` (string): Content of the post.

**Responses**
**201 Created**
**Description: Post created successfully**

Content: `application/json`

```json
{
    "success": true,
    "message": "Post created successfully.",
    "post": {
        "id": 1,
        "author_id": 1,
        "author": "John Doe",
        "email": "john@example.com",
        "title": "New Blog Post",
        "content": "This is the content of the blog post.",
        "created_at": "2024-07-20T12:34:56Z",
        "updated_at": "2024-07-20T12:34:56Z"
    }
}
```

400 Bad Request
Description: Invalid input

Content: `application/json`

```json
{
    "success": false,
    "message": "Error message here."
}
```

Example Request

```bash
curl -X POST "http://your-api-url/v1/create" \
     -H "Content-Type: application/json" \
     -d '{
           "author_id": 1,
           "author": "John Doe",
           "email": "john@example.com",
           "title": "New Blog Post",
           "content": "This is the content of the blog post."
         }'
```

Example Response
201 Created

```json
{
    "success": true,
    "message": "Post created successfully.",
    "post": {
        "id": 1,
        "author_id": 1,
        "author": "John Doe",
        "email": "john@example.com",
        "title": "New Blog Post",
        "content": "This is the content of the blog post.",
        "created_at": "2024-07-20T12:34:56Z",
        "updated_at": "2024-07-20T12:34:56Z"
    }
}
```