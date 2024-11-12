<?php

namespace Database\Seeders;

use App\Models\BlogsPost;
use App\Models\BlogsTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogsTagTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogsTagCategories = BlogsPost::all();

        foreach ($blogsTagCategories as $blogsTagCategory) {
            BlogsTag::factory(1)->create(['site_id' => $blogsTagCategory->site_id, 'blogs_post_id' => $blogsTagCategory->id]);
        }
    }
}
