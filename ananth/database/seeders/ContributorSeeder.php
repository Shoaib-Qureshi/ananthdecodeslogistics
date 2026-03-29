<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BlogCategories;

class ContributorSeeder extends Seeder
{
    public function run()
    {
        // Admin user (only create if not exists)
        if (!User::where('email', 'admin@ananthdecodeslogistics.com')->exists()) {
            User::create([
                'name'        => 'Ananthakrishnan',
                'email'       => 'admin@ananthdecodeslogistics.com',
                'password'    => Hash::make('ChangeMe@2026!'),
                'user_role'   => 'admin',
                'status'      => 'approved',
                'designation' => 'Founder & Author',
            ]);
        }

        // Ensure existing users have approved status (so existing admin still works)
        User::whereNull('status')->update(['status' => 'approved']);

        // Default contributor category
        if (!BlogCategories::where('slug', 'logistics-insights')->exists()) {
            BlogCategories::create([
                'name'        => 'Logistics Insights',
                'slug'        => 'logistics-insights',
                'description' => 'Expert insights and analysis on the global logistics industry.',
            ]);
        }
    }
}
