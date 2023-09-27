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
        Schema::table('likes',function (Blueprint $table){
            $table->dropForeign(['item_id']);

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

        });
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['item_id']);

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->foreign('item_id')->references('id')->on('items');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->foreign('item_id')->references('id')->on('items');
        });
    }
};
