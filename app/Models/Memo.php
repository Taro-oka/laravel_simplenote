<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    public function myMemos($user_id)
    {
        $tag = \Request::query('tag');

        if (empty($tag)) {
            return static::select('memos.*')
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $memos = static::select('memos.*')
                ->leftJoin('tags', 'tags.id', '=', 'memos.tag_id')
                ->where('tags.name', $tag)
                ->where('tags.user_id', $user_id)
                ->where('memos.user_id', $user_id)
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->get();
            return $memos;
        }
    }
}
