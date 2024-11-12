<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call([
            UserTestSeeder::class,
            SiteTestSeeder::class,
            NewsCategoryTestSeeder::class,
            NewsArticleTestSeeder::class,
            NewsSettingTestSeeder::class,
            //NewsTagTestSeeder::class,
            NewsSnsTestSeeder::class,
            BlogsCategoryTestSeeder::class,
            BlogsPostTestSeeder::class,
            BlogsSettingTestSeeder::class,
            //BlogsTagTestSeeder::class,
            BlogsSnsTestSeeder::class,
            TemplateTestSeeder::class,
            HeaderFooterSettingTestSeeder::class,
            SideBannerTestSeeder::class
        ]);
    }
}
