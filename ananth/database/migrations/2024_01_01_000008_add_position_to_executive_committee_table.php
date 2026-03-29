<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToExecutiveCommitteeTable extends Migration
{
    public function up()
    {
        Schema::table('executive_committee', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('display_order');
        });
    }

    public function down()
    {
        Schema::table('executive_committee', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}
