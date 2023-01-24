<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Posts;
use App\Traits\ApiResponseTrait;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function createPost(CreatePostRequest $request)
    {
        $user = $request->user();
        $post = [
            'title' => $request['title'],
            'post' => $request['post'],
            'post_by' => $user->id
        ];
        $post = Posts::create($post);
        $post['posted_by'] = $user->username;

        return $this->successResponse($post, 'Post published!');
    }
}
