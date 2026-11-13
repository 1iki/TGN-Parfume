<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MongoDbSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Products into collection 'tgn-parfume'
        Product::truncate();
        $products = [
            [
                'legacy_id' => 1,
                'name' => 'Blue Seduction',
                'details' => 'The initial impression upon spraying Blue Seduction is characterized by the top notes, introducing a refreshing',
                'categories' => 'male',
                'ingredient' => 'Alcohol and Parfum (Fragrance)',
                'price' => 50000,
                'image' => 'menu-parfum1.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 2,
                'name' => 'Zera Chocolate',
                'details' => 'all other notes gradually fade away, the base notes in Zera Chocolate may encompass deeper and long-lasting elements such as wood or musk',
                'categories' => 'male',
                'ingredient' => 'Aqua (Water) and Benzyl Salicylate',
                'price' => 75000,
                'image' => 'menu-parfum2.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 3,
                'name' => 'Versace Eros',
                'details' => 'Versace Eros aims to provide an enticing freshness with a touch of a striking and captivating aroma.',
                'categories' => 'male',
                'ingredient' => 'Linalool and Limonene',
                'price' => 85000,
                'image' => 'menu-parfum3.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 4,
                'name' => 'H. Boss Orange',
                'details' => 'This fragrance is designed to reflect the courage and masculinity of the modern man.',
                'categories' => 'male',
                'ingredient' => 'Butyl and Limonene',
                'price' => 40000,
                'image' => 'menu-parfum4.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 5,
                'name' => 'Cheese Cake',
                'details' => 'Cheese Cake aims to offer a captivating allure, grabbing attention with its distinctive and sensual aroma.',
                'categories' => 'male',
                'ingredient' => 'Geraniol and Coumarin',
                'price' => 70000,
                'image' => 'menu-parfum5.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 6,
                'name' => 'Sauvage',
                'details' => 'Sauvage is chosen as a suitable option for various occasions, be it formal events or daily wear.',
                'categories' => 'male',
                'ingredient' => 'Butyl and Hydroxycitronellal',
                'price' => 60000,
                'image' => 'menu-parfum6.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 7,
                'name' => 'Caramel Popcorn',
                'details' => 'Creating a sweet, warm, and enticing aroma reminiscent of caramel and popcorn.',
                'categories' => 'female',
                'ingredient' => 'Benzyl Benzoate and Pentaerythrityl',
                'price' => 50000,
                'image' => 'menu-parfum7.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 8,
                'name' => 'BVL Extreme',
                'details' => 'Bvlgari (BVL) Extreme aims to provide an intense, captivating, and long-lasting olfactory experience.',
                'categories' => 'female',
                'ingredient' => 'Geraniol and Coumarin',
                'price' => 75000,
                'image' => 'menu-parfum8.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 9,
                'name' => 'Eternity Women',
                'details' => 'Eternity Women is renowned for its elegant and contemporary fragrance, characterized by a blend of floral and oriental elements.',
                'categories' => 'female',
                'ingredient' => 'Benzyl Alcohol and Triethyl Citrate',
                'price' => 85000,
                'image' => 'menu-parfum9.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 10,
                'name' => 'Black XS',
                'details' => 'Black XS is often used to boost self-confidence and enhance the mood of the wearer.',
                'categories' => 'female',
                'ingredient' => 'Farnesol and Benzyl Alcohol',
                'price' => 40000,
                'image' => 'menu-parfum10.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 11,
                'name' => 'Kenzo Bali',
                'details' => 'Kenzo Bali can enhance confidence by providing a comforting and pleasing scent that makes individuals feel better about themselves.',
                'categories' => 'female',
                'ingredient' => 'Coumarin and Citral',
                'price' => 70000,
                'image' => 'menu-parfum11.png',
                'sold' => 0
            ],
            [
                'legacy_id' => 12,
                'name' => 'Creed Aventus',
                'details' => 'Creed Aventus is designed to provide a distinctive and unique aromatic experience with oriental woody undertones.',
                'categories' => 'female',
                'ingredient' => 'Anise Alcohol and Citronellol',
                'price' => 40000,
                'image' => 'menu-parfum12.png',
                'sold' => 0
            ],
        ];

        foreach ($products as $prodData) {
            Product::create($prodData);
        }

        // 2. Seed Users into collection 'users' (combining users table + karyawan table)
        User::truncate();

        // Standard Users
        $users = [
            [
                'legacy_id' => 6,
                'username' => 'kriss',
                'fullname' => 'krisna aprian',
                'email' => 'krisnawirawan57@gmail.com',
                'phone' => '08158061371',
                'status' => 'Active',
                'password' => '40bd001563085fc35165329ea1ff5c5ecbdbbeef', // sha1
                'password_algorithm' => 'sha1',
                'level' => 'consument',
            ],
            [
                'legacy_id' => 7,
                'username' => 'admin',
                'fullname' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '123',
                'status' => 'Active',
                'password' => '40bd001563085fc35165329ea1ff5c5ecbdbbeef', // sha1
                'password_algorithm' => 'sha1',
                'level' => 'Super Admin',
            ],
            [
                'legacy_id' => 8,
                'username' => 'tes2',
                'fullname' => 'tes2',
                'email' => 'tes2@gmail.com',
                'phone' => '123',
                'status' => 'Active',
                'password' => '40bd001563085fc35165329ea1ff5c5ecbdbbeef', // sha1
                'password_algorithm' => 'sha1',
                'level' => 'Marketing',
            ],
            [
                'legacy_id' => 9,
                'username' => 'tes3',
                'fullname' => 'tes3',
                'email' => 'tes3@gmail.com',
                'phone' => '123',
                'status' => 'Disabled',
                'password' => '40bd001563085fc35165329ea1ff5c5ecbdbbeef', // sha1
                'password_algorithm' => 'sha1',
                'level' => 'consument',
            ],
            // Merged employee from karyawan table (id 3)
            [
                'legacy_id' => 103, // prefixed to avoid collision
                'username' => 'gweh',
                'fullname' => 'Putra Ardiasnyah',
                'email' => 'email.putra@gmail.com',
                'phone' => '041522010256',
                'status' => 'Active',
                'password' => 'da39a3ee5e6b4b0d3255bfef95601890afd80709', // sha1 empty
                'password_algorithm' => 'sha1',
                'level' => 'Customer Service',
                'about' => 'Karyawan Staff',
                'job' => 'staff',
                'country' => 'Indonesia',
                'address' => 'Jl. Buncit Raya No.98, RT.1/RW.7, Pejaten Bar., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12510',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // 3. Seed Messages
        Message::truncate();
        Message::create([
            'legacy_id' => 1,
            'user_id' => 6,
            'name' => 'gweh',
            'email' => 'asdDs@asda.com',
            'number' => '0825806137',
            'message' => 'puh, ajarannya puhh',
        ]);

        Cart::truncate();
        Order::truncate();
    }
}
