<?php

use App\Support\ContributorPlans;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $legacyMap = ContributorPlans::legacyMap();

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'contributor_plan')) {
            foreach ($legacyMap as $legacyPlan => $newPlan) {
                DB::table('users')
                    ->where('contributor_plan', $legacyPlan)
                    ->update(['contributor_plan' => $newPlan]);
            }
        }

        if (Schema::hasTable('contributor_payments') && Schema::hasColumn('contributor_payments', 'plan')) {
            foreach ($legacyMap as $legacyPlan => $newPlan) {
                DB::table('contributor_payments')
                    ->where('plan', $legacyPlan)
                    ->update(['plan' => $newPlan]);
            }
        }

        if (Schema::hasTable('contributor_posts') && Schema::hasColumn('contributor_posts', 'feature_source_plan')) {
            foreach ($legacyMap as $legacyPlan => $newPlan) {
                DB::table('contributor_posts')
                    ->where('feature_source_plan', $legacyPlan)
                    ->update(['feature_source_plan' => $newPlan]);
            }
        }
    }

    public function down(): void
    {
        $legacyMap = array_flip(ContributorPlans::legacyMap());

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'contributor_plan')) {
            foreach ($legacyMap as $newPlan => $legacyPlan) {
                DB::table('users')
                    ->where('contributor_plan', $newPlan)
                    ->update(['contributor_plan' => $legacyPlan]);
            }
        }

        if (Schema::hasTable('contributor_payments') && Schema::hasColumn('contributor_payments', 'plan')) {
            foreach ($legacyMap as $newPlan => $legacyPlan) {
                DB::table('contributor_payments')
                    ->where('plan', $newPlan)
                    ->update(['plan' => $legacyPlan]);
            }
        }

        if (Schema::hasTable('contributor_posts') && Schema::hasColumn('contributor_posts', 'feature_source_plan')) {
            foreach ($legacyMap as $newPlan => $legacyPlan) {
                DB::table('contributor_posts')
                    ->where('feature_source_plan', $newPlan)
                    ->update(['feature_source_plan' => $legacyPlan]);
            }
        }
    }
};
