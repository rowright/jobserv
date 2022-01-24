<?php

namespace App\Library;

use App\Models\Comments;
use Auth;

class Audit
{
    public static function audit($object, $id, $message, $title = 'System generated action', $technical = '')
    {
        $comment = new Comments;
        $comment->name = $title;
        $comment->body = $message;
        $comment->user_id = Auth::user()->id;
        $comment->commentable_id = $id;
        $comment->commentable_type = $object;
        $comment->technical = $technical;
        $comment->save();
    }

}