<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTrainingProgram extends Migration
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
            $table->string('lecture')->after('description');
            $table->string('days')->after('lecture')->nullable();
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
            $table->dropColumn('lecture');
            $table->dropColumn('days');
        });
    }
}   
