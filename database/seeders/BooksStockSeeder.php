<?php

namespace Database\Seeders;

use App\Models\BookStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookStock::factory()
            ->count(10)
            ->create();
    }
}
