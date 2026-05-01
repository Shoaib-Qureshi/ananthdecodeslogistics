<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContributorSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(HomePageSettingSeeder::class);
        $this->call(AboutPageSettingSeeder::class);
        $this->call(FounderSeeder::class);
        $this->call(FounderCredentialSeeder::class);
        $this->call(ServiceCardSeeder::class);
        $this->call(ExpertDeskPillarSeeder::class);
        $this->call(PageBannerSeeder::class);
    }
}
