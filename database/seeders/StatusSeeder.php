<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            ['name' => 'Новый', 'is_changeable' => true],
            ['name' => 'В обработке', 'is_changeable' => true],
            ['name' => 'Ожидает доставки', 'is_changeable' => true],
            ['name' => 'Доставлен', 'is_changeable' => false],
            ['name' => 'Отменён', 'is_changeable' => false],
        ]);
    }
}
