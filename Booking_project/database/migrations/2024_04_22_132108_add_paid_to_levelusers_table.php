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
        Schema::table('levelusers', function (Blueprint $table) {
            //
            $table->mediumText('image')->after('level_user');
            $table->mediumText('last_name')->after('passWordNumber_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levelusers', function (Blueprint $table) {
            //
            $table->dropColumn('image');
        });
    }
};
