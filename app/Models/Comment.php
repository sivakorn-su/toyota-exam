<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'content',
        'is_anonymous',
        'topic_id',
        'user_id'
    ];
    protected function casts(): array
    {
        return [
            'is_anonymous'=>'boolean',
        ];
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
