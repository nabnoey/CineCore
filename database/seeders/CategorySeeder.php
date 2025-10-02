<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Action (แอคชัน)']);
        Category::create(['name' => 'Adventure (ผจญภัย)']);
        Category::create(['name' => 'Crime (อาชญากรรม)']);
        Category::create(['name' => 'Drama (ชีวิต/ดราม่า)']);
        Category::create(['name' => 'Fantasy (แฟนตาซี)']);
        Category::create(['name' => 'Horror (สยองขวัญ)']);
        Category::create(['name' => 'Mystery (ลึกลับ)']);
        Category::create(['name' => 'Romance (โรแมนติก)']);
        Category::create(['name' => 'Sci-Fi (ไซไฟ)']);
        Category::create(['name' => 'Thriller (ระทึกขวัญ)']);
    }
}