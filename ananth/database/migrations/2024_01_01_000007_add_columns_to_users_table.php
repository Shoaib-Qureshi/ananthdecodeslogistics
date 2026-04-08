<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'user_role')) {
                $table->string('user_role')->default('user')->after('password'); // admin or user
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('users', 'username')) {
                $columns[] = 'username';
            }
            if (Schema::hasColumn('users', 'user_role')) {
                $columns[] = 'user_role';
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
}
