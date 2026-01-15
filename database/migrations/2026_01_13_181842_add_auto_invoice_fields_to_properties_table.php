<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('auto_invoice_enabled')->default(false)->after('is_active');
            $table->integer('invoice_generation_day')->default(1)->after('auto_invoice_enabled')->comment('Day of month (1-28) to generate invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['auto_invoice_enabled', 'invoice_generation_day']);
        });
    }
};
