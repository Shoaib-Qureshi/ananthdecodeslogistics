<?php

use App\Support\ContributorPlans;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contributor_plans')) {
            return;
        }

        if (DB::table('contributor_plans')->where('code', ContributorPlans::FREE_ACCOUNT)->exists()) {
            return;
        }

        $plan = ContributorPlans::defaults()[ContributorPlans::FREE_ACCOUNT];
        $now = now();

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

    public function down(): void
    {
        if (!Schema::hasTable('contributor_plans')) {
            return;
        }

        DB::table('contributor_plans')->where('code', ContributorPlans::FREE_ACCOUNT)->delete();
    }
};
