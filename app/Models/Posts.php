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
}
