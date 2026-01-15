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
        Schema::create('invoice_generation_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->date('generation_date');
            $table->integer('invoices_created')->default(0);
            $table->integer('invoices_failed')->default(0);
            $table->string('status')->default('success')->comment('success, partial, failed');
            $table->text('error_log')->nullable();
            $table->text('details')->nullable()->comment('JSON details of created/failed invoices');
            $table->timestamps();
            
            $table->index(['parent_id', 'generation_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_generation_logs');
    }
};
