<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('campaign', function (Blueprint $table) {
            $table->integer('pilihan')->nullable()->after('publish');
            $table->integer('urutan_pilihan')->nullable()->after('pilihan');
        });
    }

    public function down(): void
    {
        Schema::table('campaign', function (Blueprint $table) {
            $table->dropColumn(['pilihan', 'urutan_pilihan']);
        });
    }
};

