<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tenda',
                'slug' => 'tenda',
                'description' => 'Berbagai jenis tenda untuk kegiatan hiking dan camping.',
            ],
            [
                'name' => 'Carrier',
                'slug' => 'carrier',
                'description' => 'Tas carrier untuk membawa perlengkapan outdoor.',
            ],
            [
                'name' => 'Sleeping Bag',
                'slug' => 'sleeping-bag',
                'description' => 'Sleeping bag untuk menjaga kenyamanan saat beristirahat.',
            ],
            [
                'name' => 'Matras',
                'slug' => 'matras',
                'description' => 'Matras outdoor untuk camping dan hiking.',
            ],
            [
                'name' => 'Trekking Pole',
                'slug' => 'trekking-pole',
                'description' => 'Tongkat trekking untuk membantu perjalanan hiking.',
            ],
            [
                'name' => 'Headlamp',
                'slug' => 'headlamp',
                'description' => 'Lampu kepala untuk aktivitas outdoor malam hari.',
            ],
            [
                'name' => 'Kompor Camping',
                'slug' => 'kompor-camping',
                'description' => 'Kompor portable untuk kebutuhan memasak saat camping.',
            ],
            [
                'name' => 'Sepatu Hiking',
                'slug' => 'sepatu-hiking',
                'description' => 'Sepatu outdoor untuk hiking dan trekking.',
            ],
            [
                'name' => 'Jaket Outdoor',
                'slug' => 'jaket-outdoor',
                'description' => 'Jaket untuk melindungi tubuh saat aktivitas outdoor.',
            ],
            [
                'name' => 'Peralatan Masak',
                'slug' => 'peralatan-masak',
                'description' => 'Peralatan memasak praktis untuk kegiatan camping.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}