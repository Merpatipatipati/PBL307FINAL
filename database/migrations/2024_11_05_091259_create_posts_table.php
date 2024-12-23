<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->uuid('id')->primary(); // Menghapus default UUID di sini
        $table->uuid('user_id');
        $table->text('content');
        $table->string('image_url')->nullable();
        $table->unsignedInteger('likes')->default(0);
        $table->unsignedInteger('comments_count')->default(0);
        $table->timestamps();

        // Menambahkan foreign key untuk user_id
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
