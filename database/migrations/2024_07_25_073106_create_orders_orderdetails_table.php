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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('orderId')->autoIncrement()->primary();
            $table->dateTime('orderdate');
        });

        Schema::create('orderdetails', function (Blueprint $table) {
            $table->integer('orderId');
            $table->integer('itemId');
            $table->integer('quantity');
            $table->primary(['orderId', 'itemId']); // 複合主キーの設定
            $table->foreign('orderId')->references('orderId')->on('orders')->onDelete('cascade');
            $table->foreign('itemId')->references('ident')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orderdetails');
    }
};
