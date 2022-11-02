<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropcolumnTrainingInvites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('training_invites', function($table) {
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
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
        Schema::table('training_invites', function($table) {
            $table->date('date_from')->after('description');
            $table->date('date_to')->after('date_from');
        });
    }
}
