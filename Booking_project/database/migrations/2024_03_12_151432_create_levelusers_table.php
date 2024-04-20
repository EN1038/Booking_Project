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
        Schema::create('levelusers', function (Blueprint $table) {
            $table->id();
            $table->string('name_user');
            $table->string('passWordNumber_user');
            $table->string('email');
            $table->string('level_user');
            $table->integer('goodness_user');//ใช้เพื่อนับครั้งที่ user มาสายหรือไม่มาพอครบ 3 จะเปลี่ยนสถานะ user ให้ไม่สามารถจองออนไลน์ได้ต้อง walkin
            $table->string('status_user');//ใช้เพื่อบอกสถานะว่าuserคนนี้สามารถจองออนไลน์ได้หรือไม่
            $table->dateTime('cool_down_user')->nullable()->default(null);//ใช้ไว้เก็บเวลาที่ user โดนแบนจากการทำผิด 3 ครั้งพอถึงเวลาที่กำหนดไว้จะเปลี่ยนสถานะ user ใหม่
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levelusers');
    }
};
