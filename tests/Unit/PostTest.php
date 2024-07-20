<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Author; // Assuming Author is the user model
use Laravel\Sanctum\Sanctum;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a user can create a post.
     *
     * @return void
     */
    public function test_can_create_post()
    {
        // Create a user and authenticate using Sanctum
        $user = Author::factory()->create([
            'name' => 'Abel Akponine', // default Author name
            'email' => 'abelakponine@gmail.com', // default Author email
            'password' => Hash::make('test1234'), // Ensure you set a password
        ]);

        Sanctum::actingAs($user, ['post:read', 'post:write']); // 'post:read' and 'post:write' permission

        // Define the post data
        $postData = [
            'author_id' => $user->id,
            'author' => $user->name,
            'email' => $user->email,
            'title' => 'Test Post Title',
            'content' => 'Test post content',
            'publish_at' => now()
        ];

        // Make a POST request to create a new post
        $response = $this->postJson('/api/v1/create', $postData);
        
        // Assert that the response status is 201 (created)
        $response->assertStatus(201);

        // Assert that the response contains the success message
        $response->assertJson([
            'success' => true,
            'message' => 'Post created successfully.',
        ]);

        // Assert that the post is actually stored in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'content' => 'Test post content',
        ]);
    }

    /**
     * Test if a user cannot create a post without authentication.
     *
     * @return void
     */
    public function test_cannot_create_post_without_authentication()
    {
        // Define the post data
        $postData = [
            'author_id' => 1,
            'author' => 'Test Author',
            'email' => 'test@123.com',
            'title' => 'Test Post Title',
            'content' => 'Test post content',
        ];

        // Make a POST request to create a new post without authentication
        $response = $this->postJson('/api/v1/create', $postData);

        // Assert that the response status is 401 (unauthorized)
        $response->assertStatus(401);

        // Assert that the response contains the correct error message
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

}
