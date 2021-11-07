<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveColumnToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('roles') && !Schema::hasColumn('roles', 'active')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->boolean('active')->after('scope')->default(true);
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
        if (Schema::hasTable('roles') && Schema::hasColumn('roles', 'active')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
}
