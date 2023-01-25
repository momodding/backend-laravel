<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'posts_id',
        'parent_comment_id',
        'content',
        'post_by',
    ];

    protected $hidden = [
        'id',
        'post_by',
    ];

    public function posts()
    {
        return $this->belongsTo(Posts::class, 'posts_id');
    }

    public function comment()
    {
        return $this->parentComment();
    }

    public function parentComment()
    {
        return $this->hasOne(PostComments::class, 'id', 'parent_comment_id');
    }

    public function reply()
    {
        return $this->replyComment();
    }

    public function replyComment()
    {
        return $this->hasMany(PostComments::class, 'parent_comment_id', 'id');
    }

    public function posted_by()
    {
        return $this->users()->select(['id', 'name']);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'post_by', 'id');
    }
}
