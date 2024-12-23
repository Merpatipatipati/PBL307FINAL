<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReportsTable extends Migration
{
    public function up()
    {
        Schema::create('product_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id'); // ID pengguna yang melaporkan
            $table->uuid('product_id'); // ID produk yang dilaporkan
            $table->text('reason'); // Alasan laporan
            $table->decimal('product_price', 10, 2)->nullable(); // Harga produk (nullable)
            $table->timestamps();

            // Relasi dengan tabel users dan products
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_reports');
    }
}
