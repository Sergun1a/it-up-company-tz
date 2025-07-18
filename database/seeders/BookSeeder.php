<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            ['title' => 'Чистый код', 'author' => 'Роберт Мартин', 'price' => 1200],
            ['title' => 'Паттерны проектирования', 'author' => 'Эрих Гамма', 'price' => 1500],
            ['title' => 'Refactoring', 'author' => 'Мартин Фаулер', 'price' => 1300],
            ['title' => 'Laravel в действии', 'author' => 'Мэтт Стаффорд', 'price' => 1100],
            ['title' => 'Совершенный код', 'author' => 'Стив Макконнелл', 'price' => 1400],
        ]);
    }
}
