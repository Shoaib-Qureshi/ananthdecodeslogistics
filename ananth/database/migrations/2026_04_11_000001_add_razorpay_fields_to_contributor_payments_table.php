<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRazorpayFieldsToContributorPaymentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('contributor_payments')) {
            return;
        }

        Schema::table('contributor_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('contributor_payments', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->unique()->after('status');
            }

            if (!Schema::hasColumn('contributor_payments', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->unique()->after('razorpay_order_id');
            }

            if (!Schema::hasColumn('contributor_payments', 'razorpay_signature')) {
                $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('contributor_payments')) {
            return;
        }

        Schema::table('contributor_payments', function (Blueprint $table) {
            $columns = [];

            foreach (['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature'] as $column) {
                if (Schema::hasColumn('contributor_payments', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
}
