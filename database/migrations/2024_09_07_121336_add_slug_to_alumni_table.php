<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('alumni')->whereNull('slug')->orWhere('slug', '')->orderBy('id')->chunk(100, function ($alumni) {
            foreach ($alumni as $person) {
                // Generate a slug and append ID to ensure uniqueness if needed
                $slug = Str::slug($person->nama) ?: 'alumni-' . $person->id;
                
                // Ensure uniqueness
                $existingSlugCount = DB::table('alumni')->where('slug', $slug)->count();
                if ($existingSlugCount > 0) {
                    $slug .= '-' . $person->id; // Append ID to avoid duplication
                }

                DB::table('alumni')->where('id', $person->id)->update(['slug' => $slug]);
            }
        });
    }

    public function down()
    {
        // Optionally, you can clear slugs if you need to roll back
        DB::table('alumni')->update(['slug' => null]);
    }

};
