<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable()->after('user_role');
            $table->string('insta')->nullable()->after('designation');
            $table->string('linkedin')->nullable()->after('insta');
            $table->string('twitter')->nullable()->after('linkedin');
            $table->text('intro')->nullable()->after('twitter');
            $table->string('profile_pic')->nullable()->after('intro');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'designation',
                'insta',
                'linkedin',
                'twitter',
                'intro',
                'profile_pic',
            ]);
        });
    }
}
