<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReportsTablesForAdminResponse extends Migration
{
    public function up()
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->text('admin_response')->nullable()->after('reason'); // Menyimpan respon admin
            $table->enum('status', ['Pending', 'Submitted'])->default('Pending')->after('admin_response'); // Status laporan
        });

        Schema::table('post_reports', function (Blueprint $table) {
            $table->text('admin_response')->nullable()->after('reason'); // Menyimpan respon admin
            $table->enum('status', ['Pending', 'Submitted'])->default('Pending')->after('admin_response'); // Status laporan
        });
    }

    public function down()
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->dropColumn(['admin_response', 'status']);
        });

        Schema::table('post_reports', function (Blueprint $table) {
            $table->dropColumn(['admin_response', 'status']);
        });
    }
}
