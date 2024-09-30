<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('administrator')->insert([
            [
                'item_id' => '1',
                'item' => 'Edit ini dengan logo Al-Quraniyyah',
                'info' => 'Logo Peasntren Al-Quraniyyah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'item_id' => '2',
                'item' => 'Bantu Wujudkan Perubahan Melalui Donasi Anda!',
                'info' => 'Heading Text Untuk di Halaman Daftar Campaign',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'item_id' => '3',
                'item' => 'Selamat datang di halaman campaign donasi kami, di mana setiap kontribusi Anda dapat menginspirasi perubahan nyata. Bersama kita bisa membantu banyak orang dan komunitas yang membutuhkan dukungan. Pilih campaign yang paling menggugah hati Anda dan mari kita mulai bergerak bersama untuk membuat dunia menjadi tempat yang lebih baik.',
                'info' => 'Sub Heading Untuk di Halaman Daftar Campaign',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
