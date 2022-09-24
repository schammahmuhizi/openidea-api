<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['author', 'tags', 'comments', 'likes'];

    // Scoped function is used to inject query collection
    public function scopeFilter($query, $filter)
    {
        $query->when($filter ?? false, function ($query, $tag) {
            $query->whereHas('tags', fn($query) => $query->where('name', $tag));
        });
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    // Return number of likes using COUNT aggregate
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
