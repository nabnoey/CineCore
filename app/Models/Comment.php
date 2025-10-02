<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'body',
        'rating',
        'likes_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    // Helper: ตรวจสอบว่า user สามารถแก้ไข comment นี้ได้
    public function isEditableBy($user)
    {
        return $user->role === 'admin' || $this->user_id === $user->id;
    }
}
