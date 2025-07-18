<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Получаем id книг и статусов
        $bookIds = DB::table('books')->pluck('id')->toArray();
        $statusIds = DB::table('statuses')->pluck('id')->toArray();

        $orders = [];
        for ($i = 1; $i <= 10; $i++) {
            $orders[] = [
                'customer_name' => 'Покупатель ' . $i,
                'book_id' => $bookIds[array_rand($bookIds)],
                'status_id' => $statusIds[array_rand($statusIds)],
                'delivery_address' => 'Город, улица ' . $i . ', дом ' . rand(1, 100),
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ];
        }
        DB::table('orders')->insert($orders);
    }
}
