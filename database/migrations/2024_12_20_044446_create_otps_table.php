<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel OTP.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');  // Menyimpan ID pengguna
            $table->string('otp');  // Menyimpan kode OTP
            $table->timestamp('expires_at');  // Waktu kadaluarsa OTP
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
