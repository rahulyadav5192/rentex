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
        Schema::create('lead_form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('field_label');
            $table->enum('field_type', ['input', 'doc', 'checkbox', 'yes_no', 'select'])->default('input');
            $table->text('field_options')->nullable()->comment('JSON array for select options');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_default')->default(false)->comment('Default fields like Name, Email, Phone');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();
            
            $table->index('parent_id');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_form_fields');
    }
};
