<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
    Schema::table('follows', function (Blueprint $table) {
        // این قانون به دیتابیس می‌گوید که هر ترکیب از این دو ستون باید منحصر به فرد باشد
        $table->unique(['follower_id', 'following_id']);
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follows', function (Blueprint $table) {
            //
        });
    }
};
