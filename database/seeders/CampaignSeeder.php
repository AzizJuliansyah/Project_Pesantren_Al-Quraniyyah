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
            'server_key' => 'a',
            'client_key' => 'a',
            'target' => '5000000',
        ]);
    }
}
