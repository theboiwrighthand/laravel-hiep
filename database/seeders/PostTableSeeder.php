<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $posts = [];
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->id = $i + 1;
            $post->authorId = $faker->numberBetween(1, 20);
            $post->parentId =  $i + 1;
            $post->title = $faker->sentence(6);
            $post->metaTitle = $faker->sentence(6);
            $post->slug = $faker->slug;
            $post->sumary = $faker->text(100);
            $post->published = $faker->boolean;
            $post->content = $faker->text(500);
            $post->created_at = $faker->dateTime;
            $post->updated_at = $faker->dateTime;
            $post->save();
            $posts[] = $post;
        }

        // Update the parentId for each post
        foreach ($posts as $key => $post) {
            $post->parentId = $faker->numberBetween(1, count($posts));
            $post->save();
        }
    }
}
