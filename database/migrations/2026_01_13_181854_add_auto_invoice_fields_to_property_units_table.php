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
        Schema::table('property_units', function (Blueprint $table) {
            $table->boolean('auto_invoice_enabled')->default(false)->after('is_occupied');
            $table->integer('default_invoice_type_id')->nullable()->after('auto_invoice_enabled')->comment('Default invoice type ID for auto-generated invoices');
            $table->timestamp('last_invoice_generated_at')->nullable()->after('default_invoice_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_units', function (Blueprint $table) {
            $table->dropColumn(['auto_invoice_enabled', 'default_invoice_type_id', 'last_invoice_generated_at']);
        });
    }
};
