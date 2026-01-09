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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->boolean('most_popular')->default(0)->after('enabled_logged_history');
            $table->text('description')->nullable()->after('most_popular');
            $table->boolean('email_notification')->default(0)->after('description');
            $table->boolean('subdomain')->default(0)->after('email_notification');
            $table->boolean('custom_domain')->default(0)->after('subdomain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['most_popular', 'description', 'email_notification', 'subdomain', 'custom_domain']);
        });
    }
};
