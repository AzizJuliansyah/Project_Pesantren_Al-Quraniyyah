<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengeluaranuangkas', function (Blueprint $table) {
            $table->id();
            $table->longText('untuk');
            $table->decimal('nominal', 15, 2);
            $table->string('yangbertanggungjawab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaranuangkas');
    }
};
