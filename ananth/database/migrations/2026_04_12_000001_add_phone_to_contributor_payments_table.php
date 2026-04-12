<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToContributorPaymentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('contributor_payments')) {
            return;
        }

        Schema::table('contributor_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('contributor_payments', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('contributor_payments') || !Schema::hasColumn('contributor_payments', 'phone')) {
            return;
        }

        Schema::table('contributor_payments', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
}
