<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('admins') && !Schema::hasColumns('last_name', 'login', 'last_login_at')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('last_name')->after('id')->nullable();
                $table->string('login')->after('name')->nullable();
                $table->timestamp('last_login_at')->after('remember_token')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('admins') &&
            Schema::hasColumns('admins', ['last_name', 'login', 'last_login_at'])
        ) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn(['last_name', 'login', 'last_login_at']);
            });
        }
    }
}
