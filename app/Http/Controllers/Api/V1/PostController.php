<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a posts.
     */
    public function index()
    {
        $posts = Post::all();
        return count($posts) > 0 ? PostResource::collection($posts) : [];
    }

    /**
     * Create new post.
     */
    public function create(StorePostRequest $request)
    {
        
        try {
            
            $validated = $request->validate([
                'author_id' => 'required|numeric',
                'author' => 'required|string',
                'email' => 'required|string|email',
                'title' => 'required|string',
                'content' => 'required|string',
                'publish_at' => 'string'
            ]);


            /** Uncomment the code below to enable token expiration check */

            // $email = $request->only('email')['email'];

            // // calculate time since last logged in
            // $author_tokens = PersonalAccessToken::where('name', $email)->get();

            // foreach ($author_tokens as $token){
                
            //     if ($this->hoursSince($time=isset($token->created_at) ? $token->created_at : "1993-04-17T00:00:00.000000Z") >= 24){
                    
            //         $token->delete(); // delete expired tokens (24 hour max)

            //         // reset tokens list
            //         $author_tokens = PersonalAccessToken::where('name', $email)->get();
            //     }
            // }

            // if (count($author_tokens) < 1){
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Unauthorized access: user session expired, please login.',
            //         'code' => 401
            //     ], 201);
            // }
            // else {
            //     Post::create($validated);

            //     return response()->json([
            //         'success' => true,
            //         'message' => 'Post created successfully.',
            //         'code' => 201
            //     ], 201);
            // }


            /** comment the code below if above code is uncommented */

            $post = Post::create([
                'author_id' => $validated['author_id'],
                'author' => $validated['author'],
                'email' => $validated['email'],
                'title' => $validated['title'],
                'content' => $validated['content'],
                'publish_at' => $validated['publish_at'] ? Carbon::parse($validated['publish_at']) : null,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully.',
                'code' => 201,
                'post' => new PostResource($post)
            ], 201);
            
        }
        catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'code' => 400
            ], 400);
        }
    }

    /**
     * Display post by ID: For view post.
     */
    public function show(int $postId)
    {
        $post = Post::find($postId);
        $all_posts = (new PostController())->index();
        return view('blog.view', ['all_posts' => $all_posts, 'post' => $post]);
    }

    /**
     * Get post by ID: For edit post.
     */
    public function read(int $postId)
    {
        $post = Post::find($postId);
        $all_posts = (new PostController())->index();
        return view('blog.edit', ['all_posts' => $all_posts, 'post' => $post]);
    }

    /**
     * Update post.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|numeric',
                'author_id' => 'required|numeric',
                'author' => 'required|string',
                'email' => 'required|string|email',
                'title' => 'required|string',
                'content' => 'required|string'
            ]);

            // Find the post by ID
            $id = $validated['id'];
            $post = Post::findOrFail($id);

            // Update the post with the validated data
            $post->title = $validated['title'];
            $post->content = $validated['content'];
            
            $post->save();

            return response()->json([
                'success' => true,
                'message' => $post->save() == 1 ? "Blog post with ID({$id}) has been updated": "Post update failed.",
                'code' => 201,
                'post' => new PostResource($post)
            ], 201);
        }
        catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Delete post.
     */
    public function delete(UpdatePostRequest $request, Post $post)
    {

        $id = $request->only('id')['id'];
        
        return response()->json([
            'success' => true,
            'message' => Post::findOrFail($id)->delete() == 1 ? "Blog post with ID({$id}) is now deleted": "Failed to delete post(ID: {$id}).",
            'postId' => $id
        ], 201);
    }

    function hoursSince($timeString) {
        $givenTime = new \DateTime($timeString);
        $currentTime = new \DateTime();
    
        $interval = $givenTime->diff($currentTime);
    
        return $interval->h + ($interval->days * 24);
    }    
}
