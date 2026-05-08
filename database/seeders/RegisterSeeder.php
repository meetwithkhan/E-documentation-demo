<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegisterSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Rice', 'Wheat', 'Maize', 'Sugar', 'Salt',
            'Oil', 'Flour', 'Milk Powder', 'Beans', 'Lentils'
        ];

        $checkers = ['Manager', 'Supervisor', 'Admin', 'Jukar'];

        for ($i = 1; $i <= 100; $i++) {

            $createdAt = Carbon::now()
                ->subDays(rand(0, 30))
                ->subMinutes(rand(1, 500));

            $reviewedAt = (clone $createdAt)->addMinutes(rand(5, 120));

            DB::table('submissions')->insert([
                'user_id' => 4,
                'register_type' => 'weight_balance',

                'form_data' => json_encode([
                    'sr_no'        => $i,
                    'date'         => $createdAt->format('Y-m-d'),
                    'product_name' => $products[array_rand($products)],
                    'qty'          => rand(10, 500),
                    'remarks'      => 'Sample entry ' . $i,
                ]),

                'status' => 'approved',
                'reviewed_by' => rand(3, 6),

                'review_data' => json_encode([
                    'checked_by' => $checkers[array_rand($checkers)]
                ]),

                'review_note' => null,
                'reviewed_at' => $reviewedAt,
                'created_at'  => $createdAt,
                'updated_at'  => $reviewedAt,
            ]);
        }
    }
}