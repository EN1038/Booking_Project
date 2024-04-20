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
        Schema::create('type_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name_type');
            $table->time('time_duration');
            $table->time('time_cancel');
            $table->time('time_late');
            $table->integer('number_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_rooms');
    }
};
