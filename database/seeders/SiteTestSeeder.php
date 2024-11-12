<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Site::create([
            'seo_keyword1' => 'Laravel',
            'seo_keyword2' => 'PHP',
            'seo_keyword3' => 'Framework',
            'seo_title' => 'Laravel Website',
        ]);

        Site::create([
            'seo_keyword1' => 'Vue.js',
            'seo_keyword2' => 'Frontend',
            'seo_keyword3' => 'JavaScript',
            'seo_title' => 'Vue.js SPA',
        ]);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
