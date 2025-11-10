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
        Schema::table('movies', function (Blueprint $table) {
            $table->string('short_description')->nullable()->after('title');
            $table->text('long_description')->nullable()->after('short_description');
            $table->dropColumn('description'); // To remove the old description column.
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('description')->nullable()->after('title');
            $table->dropColumn(['short_description', 'long_description']);
        });
    }

};
