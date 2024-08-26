<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, PostCategory::class, 'post_id', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
