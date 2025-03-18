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
        Schema::create('campaign', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('campaign_id')->unique();
            $table->string('nama');
            $table->string('slug');
            $table->text('info');
            $table->string('server_key');
            $table->string('client_key');
            $table->integer('target')->nullable();
            $table->longText('nominal')->nullable();
            $table->integer('publish')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign');
    }
};
