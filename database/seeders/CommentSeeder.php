<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = Topic::all();
        $users = User::all();

        foreach ($topics as $topic) {
            Comment::factory()->count(5)->create([
                'topic_id' => $topic->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
