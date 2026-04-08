<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToExecutiveCommitteeTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('executive_committee')) {
            return;
        }

        Schema::table('executive_committee', function (Blueprint $table) {
            if (!Schema::hasColumn('executive_committee', 'position')) {
                $table->integer('position')->default(0)->after('display_order');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('executive_committee')) {
            return;
        }

        Schema::table('executive_committee', function (Blueprint $table) {
            if (Schema::hasColumn('executive_committee', 'position')) {
                $table->dropColumn('position');
            }
        });
    }
}
