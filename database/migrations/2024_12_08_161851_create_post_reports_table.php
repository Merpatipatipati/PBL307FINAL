<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostReportsTable extends Migration
{
    public function up()
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id'); // ID pengguna yang melaporkan
            $table->uuid('post_id'); // ID post yang dilaporkan
            $table->text('reason'); // Alasan laporan
            $table->text('post_content')->nullable(); // Konten post yang dilaporkan (nullable)
            $table->timestamps();

            // Relasi dengan tabel users dan posts
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_reports');
    }
}
