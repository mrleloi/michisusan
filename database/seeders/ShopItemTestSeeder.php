<?php

namespace Database\Seeders;

use App\Models\ShopItem;
use Illuminate\Database\Seeder;

class ShopItemTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShopItem::factory()->count(50)->create();
    }
}
