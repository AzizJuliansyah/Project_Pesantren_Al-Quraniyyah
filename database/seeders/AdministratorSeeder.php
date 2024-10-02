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
                'info' => 'Logo Pesantren Al-Quraniyyah',
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
            [
                'item_id' => '4',
                'item' => 'Edit ini dengan background landscape',
                'info' => 'Background Untuk di Halaman Landing Page',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'item_id' => '5',
                'item' => 'Pesantren Al-Quraniyyah adalah pesantren yang berkomitmen untuk mencetak generasi berakhlak mulia dengan landasan ilmu Al-Quran. Selain fokus pada pendidikan agama yang mendalam, pesantren ini juga aktif dalam berbagai kegiatan sosial, termasuk pengelolaan dana infaq, sedekah, dan kampanye donasi untuk mendukung kesejahteraan santri serta pengembangan fasilitas pesantren.',
                'info' => 'Text Untuk di Halaman Landing Page',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
