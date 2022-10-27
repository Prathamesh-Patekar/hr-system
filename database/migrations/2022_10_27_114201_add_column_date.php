<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('training_programs', function($table) {
            $table->date('date_frm')->after('description');
            $table->date('date_to')->after('date_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('training_programs', function($table) {
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
        });
    }
}
