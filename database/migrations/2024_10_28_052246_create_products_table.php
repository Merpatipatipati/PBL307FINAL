<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->string('nama_barang');
            $table->string('tag_barang');
            $table->decimal('harga_barang', 15, 2);
            $table->integer('jumlah_barang');
            $table->text('deskripsi_barang')->nullable();
            $table->string('gambar_barang'); 
            $table->timestamps();

            
        $table->uuid('user_id'); 
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
