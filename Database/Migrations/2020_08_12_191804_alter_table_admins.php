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
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('last_name')->after('id')->nullable();
                $table->string('login')->after('name')->nullable();
                $table->timestamp('last_login')->after('remember_token')->nullable();
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
            Schema::hasColumns('admins', ['last_name', 'login', 'last_login'])
        ) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('last_name');
                $table->dropColumn('login');
                $table->dropColumn('last_login');
            });
        }
    }
}
