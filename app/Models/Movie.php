<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_image_url',
        'trailer_url',
        'release_date',
    ];

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // เพิ่มเมธอดนี้เพื่อสร้างความสัมพันธ์กับ Comment
   public function comments()
{
    return $this->hasMany(Comment::class)->with('user');
}

}
