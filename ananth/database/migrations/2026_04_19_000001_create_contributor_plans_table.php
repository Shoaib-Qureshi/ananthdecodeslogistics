<?php

use App\Support\ContributorPlans;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contributor_plans')) {
            Schema::create('contributor_plans', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->boolean('is_public')->default(false);
                $table->string('name');
                $table->string('admin_name');
                $table->unsignedInteger('price')->default(0);
                $table->string('currency', 10)->default('USD');
                $table->string('price_label')->nullable();
                $table->unsignedInteger('duration_months')->nullable();
                $table->string('duration_label')->nullable();
                $table->unsignedInteger('max_posts')->nullable();
                $table->string('post_limit_label')->nullable();
                $table->boolean('homepage_feature')->default(false);
                $table->text('summary')->nullable();
                $table->text('highlights')->nullable();
                $table->string('checkout_name')->nullable();
                $table->text('checkout_description')->nullable();
                $table->string('success_label')->nullable();
                $table->text('success_note')->nullable();
                $table->string('renew_cta')->nullable();
                $table->timestamps();
            });
        }

        $existingCodes = DB::table('contributor_plans')->pluck('code')->all();
        $now = now();

        foreach (ContributorPlans::defaults() as $plan) {
            if (in_array($plan['code'], $existingCodes, true)) {
                continue;
            }

            DB::table('contributor_plans')->insert([
                'code' => $plan['code'],
                'is_public' => $plan['public'],
                'name' => $plan['name'],
                'admin_name' => $plan['admin_name'],
                'price' => $plan['price'],
                'currency' => $plan['currency'],
                'price_label' => $plan['price_label'],
                'duration_months' => $plan['duration_months'],
                'duration_label' => $plan['duration_label'],
                'max_posts' => $plan['max_posts'],
                'post_limit_label' => $plan['post_limit_label'],
                'homepage_feature' => $plan['homepage_feature'],
                'summary' => $plan['summary'],
                'highlights' => json_encode($plan['highlights']),
                'checkout_name' => $plan['checkout_name'],
                'checkout_description' => $plan['checkout_description'],
                'success_label' => $plan['success_label'],
                'success_note' => $plan['success_note'],
                'renew_cta' => $plan['renew_cta'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contributor_plans');
    }
};
