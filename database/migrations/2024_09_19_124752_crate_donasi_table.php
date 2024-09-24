<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id');
            $table->integer('alumni_id');
            $table->string('order_id')->nullable(); // Token Snap dari Midtrans
            $table->decimal('nominal', 15, 2); // Untuk menyimpan nominal dengan dua angka desimal
            $table->decimal('nominal2', 15, 2); // Untuk menyimpan nominal dengan dua angka desimal
            $table->string('status')->default('pending'); // Status donasi, misalnya 'pending', 'success', 'failed'
            $table->string('snap_token')->nullable(); // Token Snap dari Midtrans
            $table->json('transaction_result')->nullable(); // Data hasil transaksi dalam bentuk JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
