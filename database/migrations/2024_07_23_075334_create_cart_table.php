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
        // デフォルトは'carts'となっているため、'cart'に変更
        Schema::create('cart', function (Blueprint $table) {
            $table->integer('ident')->primary();
            $table->integer('quantity');
            // 外部キー制約を追加
            $table->foreign('ident')->references('ident')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
