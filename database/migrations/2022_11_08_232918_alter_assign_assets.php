<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAssignAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_assets', function($table) {
            $table->string('accessory_id')->after('asset_id');
            $table->string('accessory_name')->after('asset_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_assets', function($table) {
            $table->dropColumn('accessory_id');
            $table->dropColumn('accessory_name');

        });
    }
}
