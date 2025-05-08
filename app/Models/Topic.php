<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Topic extends Model
{
    /** @use HasFactory<\Database\Factories\TopicFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_anonymous',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous'=>'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'');
    }

}
