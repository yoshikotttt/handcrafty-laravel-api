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
        Schema::table('requests', function (Blueprint $table) {
            // 修正内容をこちらに記述
            $table->tinyInteger('status')->default(0)->change(); // 例: statusカラムの型をtinyIntegerに変更
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->enum('status', ['受け入れ済み', '未対応'])->change(); // 元に戻す場合
        });
    }
};
