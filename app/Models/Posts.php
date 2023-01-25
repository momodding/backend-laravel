<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'post',
        'post_by',
    ];

    protected $hidden = [
        'id',
        'post_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'post_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(PostComments::class, 'posts_id');
    }

    public function posted_by()
    {
        return $this->users()->select(['id', 'name']);
    }
}
