<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentPostRequest;
use App\Http\Requests\CreatePostRequest;
use App\Models\PostComments;
use App\Models\Posts;
use App\Traits\ApiResponseTrait;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function showPostDetail($postId)
    {
        $post = Posts::where('posts.id', $postId)
            ->with('posted_by')
            ->first();

        return $this->successResponse($post);
    }

    public function showPostComment($postId)
    {
        $post = PostComments::where('post_comments.posts_id', $postId)
            ->with(['posted_by', 'reply', 'reply.posted_by'])
            ->first();

        return $this->successResponse($post);
    }

    public function createPost(CreatePostRequest $request)
    {
        $user = $request->user();
        $post = [
            'title' => $request['title'],
            'post' => $request['post'],
            'post_by' => $user->id
        ];
        $post = Posts::create($post);
        $post['posted_by'] = $user->postsBy();

        return $this->successResponse($post, 'Post published!');
    }

    public function commentPost(CreateCommentPostRequest $request, $postId)
    {
        $user = $request->user();
        $comment = [
            'posts_id' => $postId,
            'content' => $request['content'],
            'post_by' => $user->id
        ];
        $comment = PostComments::create($comment);
        $comment['posted_by'] = $user->postsBy();

        return $this->successResponse($comment, 'Comment published!');
    }

    public function replyCommenttedPost(CreateCommentPostRequest $request, $postId, $commentId)
    {
        $user = $request->user();
        $comment = [
            'posts_id' => $postId,
            'parent_comment_id' => $commentId,
            'content' => $request['content'],
            'post_by' => $user->id
        ];
        $comment = PostComments::create($comment);
        $comment['posted_by'] = $user->postsBy();

        return $this->successResponse($comment, 'Comment published!');
    }
}
