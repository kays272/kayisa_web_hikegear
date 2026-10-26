<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // Tenda
            [
                'category' => 'tenda',
                'name' => 'Tenda Hiking Alpine 2P',
                'price' => 750000,
                'stock' => 15,
                'weight' => 2200,
                'description' => 'Tenda hiking kapasitas 2 orang dengan desain ringan dan praktis.',
            ],
            [
                'category' => 'tenda',
                'name' => 'Tenda Camping Explorer 4P',
                'price' => 1250000,
                'stock' => 10,
                'weight' => 3800,
                'description' => 'Tenda camping kapasitas 4 orang yang cocok untuk kegiatan keluarga.',
            ],

            // Carrier
            [
                'category' => 'carrier',
                'name' => 'Carrier Mountain 45L',
                'price' => 850000,
                'stock' => 12,
                'weight' => 1400,
                'description' => 'Carrier 45 liter dengan kompartemen luas untuk perjalanan hiking.',
            ],
            [
                'category' => 'carrier',
                'name' => 'Carrier Adventure 60L',
                'price' => 1150000,
                'stock' => 8,
                'weight' => 1800,
                'description' => 'Carrier 60 liter untuk perjalanan outdoor dengan kapasitas besar.',
            ],

            // Sleeping Bag
            [
                'category' => 'sleeping-bag',
                'name' => 'Sleeping Bag Mountain -5C',
                'price' => 425000,
                'stock' => 20,
                'weight' => 900,
                'description' => 'Sleeping bag hangat untuk camping di area dengan suhu rendah.',
            ],
            [
                'category' => 'sleeping-bag',
                'name' => 'Sleeping Bag Compact',
                'price' => 275000,
                'stock' => 25,
                'weight' => 700,
                'description' => 'Sleeping bag ringan dan mudah dibawa untuk camping.',
            ],

            // Matras
            [
                'category' => 'matras',
                'name' => 'Matras Camping Foam',
                'price' => 125000,
                'stock' => 30,
                'weight' => 450,
                'description' => 'Matras foam ringan untuk alas tidur saat camping.',
            ],
            [
                'category' => 'matras',
                'name' => 'Matras Ultralight Outdoor',
                'price' => 225000,
                'stock' => 18,
                'weight' => 350,
                'description' => 'Matras outdoor ringan untuk hiking dan camping.',
            ],

            // Trekking Pole
            [
                'category' => 'trekking-pole',
                'name' => 'Trekking Pole Aluminium',
                'price' => 185000,
                'stock' => 25,
                'weight' => 500,
                'description' => 'Trekking pole aluminium yang ringan dan dapat disesuaikan.',
            ],
            [
                'category' => 'trekking-pole',
                'name' => 'Trekking Pole Carbon Pro',
                'price' => 325000,
                'stock' => 15,
                'weight' => 420,
                'description' => 'Trekking pole carbon untuk perjalanan hiking yang nyaman.',
            ],

            // Headlamp
            [
                'category' => 'headlamp',
                'name' => 'Headlamp LED 500 Lumens',
                'price' => 175000,
                'stock' => 30,
                'weight' => 120,
                'description' => 'Headlamp LED dengan cahaya terang untuk aktivitas malam.',
            ],
            [
                'category' => 'headlamp',
                'name' => 'Headlamp Outdoor Pro',
                'price' => 275000,
                'stock' => 18,
                'weight' => 150,
                'description' => 'Headlamp outdoor dengan beberapa mode pencahayaan.',
            ],

            // Kompor Camping
            [
                'category' => 'kompor-camping',
                'name' => 'Kompor Portable Mini',
                'price' => 225000,
                'stock' => 20,
                'weight' => 350,
                'description' => 'Kompor portable berukuran kecil untuk kebutuhan camping.',
            ],
            [
                'category' => 'kompor-camping',
                'name' => 'Kompor Camping Windproof',
                'price' => 375000,
                'stock' => 12,
                'weight' => 480,
                'description' => 'Kompor camping dengan desain tahan angin.',
            ],

            // Sepatu Hiking
            [
                'category' => 'sepatu-hiking',
                'name' => 'Sepatu Hiking Trail Pro',
                'price' => 675000,
                'stock' => 15,
                'weight' => 850,
                'description' => 'Sepatu hiking dengan grip yang cocok untuk medan outdoor.',
            ],
            [
                'category' => 'sepatu-hiking',
                'name' => 'Sepatu Trekking Waterproof',
                'price' => 925000,
                'stock' => 10,
                'weight' => 950,
                'description' => 'Sepatu trekking waterproof untuk perjalanan outdoor.',
            ],

            // Jaket Outdoor
            [
                'category' => 'jaket-outdoor',
                'name' => 'Jaket Outdoor Windbreaker',
                'price' => 425000,
                'stock' => 20,
                'weight' => 550,
                'description' => 'Jaket windbreaker ringan untuk aktivitas outdoor.',
            ],
            [
                'category' => 'jaket-outdoor',
                'name' => 'Jaket Hiking Waterproof',
                'price' => 650000,
                'stock' => 14,
                'weight' => 620,
                'description' => 'Jaket hiking waterproof untuk perlindungan dari hujan.',
            ],

            // Peralatan Masak
            [
                'category' => 'peralatan-masak',
                'name' => 'Nesting Camping Set',
                'price' => 285000,
                'stock' => 16,
                'weight' => 650,
                'description' => 'Set peralatan masak camping yang ringkas dan mudah dibawa.',
            ],
            [
                'category' => 'peralatan-masak',
                'name' => 'Camping Cookware Stainless',
                'price' => 425000,
                'stock' => 10,
                'weight' => 900,
                'description' => 'Peralatan masak camping berbahan stainless steel.',
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where(
                'slug',
                $item['category']
            )->firstOrFail();

            Product::create([
                'category_id' => $category->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'price' => $item['price'],
                'stock' => $item['stock'],
                'weight' => $item['weight'],
                'image' => null,
                'status' => true,
            ]);
        }
    }
}