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
        Schema::create('items', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->nullable()->constrained();
             $table->foreignId('category_id')->nullable()->constrained();
             $table->string('title');
             $table->text('description');
             $table->string('status')->nullable(); // string データ型を使用
             $table->integer('production_time_per_minutes')->nullable();
             $table->string('reference_url')->nullable();
             $table->text('memo')->nullable();
             $table->boolean('show_memo')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
