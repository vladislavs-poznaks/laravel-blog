<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class OtherUsersWithPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                Article::factory()->count(3)->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
