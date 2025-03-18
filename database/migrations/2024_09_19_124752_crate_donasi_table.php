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
            $table->string('order_id');
            $table->integer('alumni_id')->nullable();
            $table->string('nama')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->decimal('nominal2', 15, 2);
            $table->string('status')->default('pending');
            $table->string('snap_token')->nullable();
            $table->json('transaction_result')->nullable();
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
