<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Journals', 'Guides', 'Templates', 'Challenges', 'Workbooks'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => \Str::slug($name),
            ]);
        }
    }
}
