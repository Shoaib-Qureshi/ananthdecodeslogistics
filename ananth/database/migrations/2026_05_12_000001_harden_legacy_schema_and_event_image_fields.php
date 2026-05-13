<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('events') && Schema::hasColumn('events', 'hero_image')) {
            $this->alterColumn('events', 'hero_image', 'TEXT NULL');
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'username')) {
                    $table->string('username')->unique()->nullable()->after('name');
                }
                if (!Schema::hasColumn('users', 'user_role')) {
                    $table->string('user_role')->default('user')->after('password');
                }
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

        if (Schema::hasTable('executive_committee') && !Schema::hasColumn('executive_committee', 'position')) {
            Schema::table('executive_committee', function (Blueprint $table) {
                $table->integer('position')->default(0)->after('display_order');
            });
        }

        if (Schema::hasTable('book_reviews') && !Schema::hasColumn('book_reviews', 'status')) {
            Schema::table('book_reviews', function (Blueprint $table) {
                $table->tinyInteger('status')->default(1)->after('buy_link');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('events') && Schema::hasColumn('events', 'hero_image')) {
            $this->alterColumn('events', 'hero_image', 'VARCHAR(255) NULL');
        }
    }

    private function alterColumn(string $table, string $column, string $definition): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` {$definition}");
        }
    }
};
