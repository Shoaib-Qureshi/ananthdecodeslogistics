<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferReferenceToEventSponsorPaymentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('event_sponsor_payments')) {
            return;
        }

        Schema::table('event_sponsor_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('event_sponsor_payments', 'transfer_reference')) {
                $table->string('transfer_reference')->nullable()->after('razorpay_signature');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('event_sponsor_payments')) {
            return;
        }

        Schema::table('event_sponsor_payments', function (Blueprint $table) {
            if (Schema::hasColumn('event_sponsor_payments', 'transfer_reference')) {
                $table->dropColumn('transfer_reference');
            }
        });
    }
}
