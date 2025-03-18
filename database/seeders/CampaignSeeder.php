<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::create([
            'campaign_id' => 501,
            'nama' => 'Uang Kas',
            'info' => 'campaign pembayaran uang kas alumni',
            'client_key' => 'Ganti Ini Dengan Client Key Midtrans',
            'server_key' => 'Ganti Ini Dengan Server Key Midtrans',
            'target' => '5000000',
        ]);
    }
}
