<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'designation')) {
                $table->string('designation')->nullable()->after('user_role');
            }
            if (!Schema::hasColumn('users', 'insta')) {
                $table->string('insta')->nullable()->after('designation');
            }
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('insta');
            }
            if (!Schema::hasColumn('users', 'twitter')) {
                $table->string('twitter')->nullable()->after('linkedin');
            }
            if (!Schema::hasColumn('users', 'intro')) {
                $table->text('intro')->nullable()->after('twitter');
            }
            if (!Schema::hasColumn('users', 'profile_pic')) {
                $table->string('profile_pic')->nullable()->after('intro');
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

            foreach (['designation', 'insta', 'linkedin', 'twitter', 'intro', 'profile_pic'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
}
