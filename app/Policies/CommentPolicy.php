<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id; // user แก้ไขของตัวเองได้
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->is_admin; // admin ลบ comment ได้
    }
}
