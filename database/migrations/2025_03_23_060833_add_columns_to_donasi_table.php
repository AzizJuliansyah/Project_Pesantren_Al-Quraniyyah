<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDonasiTable extends Migration
{
    public function up()
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->string('sapaan')->nullable(); // Kolom sapaan, tipe data string
            $table->string('no_hp')->nullable(); // Kolom no_hp, tipe data string
            $table->string('email')->nullable(); // Kolom email, tipe data string
            $table->text('doa')->nullable(); // Kolom doa, tipe data text
        });
    }

    public function down()
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn(['sapaan', 'no_hp', 'email', 'doa']);
        });
    }
}
