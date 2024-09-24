<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumni::create([
            'nama' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Example No. 123, Jakarta',
            'no_telepon' => '081234567890',
            'angkatan' => 2008,
            'pendidikan_terakhir' => 'S1 Teknik Informatika',
            'pekerjaan' => 'Software Engineer',
            'usaha' => 'Startup Company',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
