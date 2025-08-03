<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// نام کلاس باید با نام فایل شما هماهنگ باشد
// برای مثال: CreateReportsTable
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // این ستون به دستور غذایی که گزارش شده، متصل می‌شود
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            // این ستون به کاربری که گزارش را ثبت کرده، متصل می‌شود
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reason'); // دلیل گزارش (مثلاً: اسپم، محتوای نامناسب)
            $table->text('details')->nullable(); // توضیحات بیشتر (اختیاری)
            $table->enum('status', ['pending', 'resolved'])->default('pending'); // وضعیت گزارش
            $table->timestamps();

            // این قانون تضمین می‌کند که هر کاربر فقط یک بار می‌تواند یک دستور را گزارش دهد
            $table->unique(['recipe_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
