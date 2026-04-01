<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('contributor_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('designation');
            $table->text('intro');
            $table->text('reason_for_joining');
            $table->string('plan');
            $table->unsignedInteger('amount');
            $table->string('currency', 10)->default('usd');
            $table->string('status')->default('pending');
            $table->string('stripe_checkout_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['email', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contributor_payments');
    }
}
