<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Outlet;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::factory(10)->create()->each(function ($merchant) {
            $outlets = Outlet::factory(2)->make();
            $merchant->outlets()->saveMany($outlets);
        });
    }
}
