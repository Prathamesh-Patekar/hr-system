<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeDeleteField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('employees' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('date_of_resignation','employees'))
            {
                $table->dropColumn('date_of_resignation');
            }
            if(!\Schema::hasColumn('notice_period','employees'))
            {
                $table->dropColumn('notice_period');

            }
            if(!\Schema::hasColumn('last_working_day','employees'))
            {
                $table->dropColumn('last_working_day');

            }
            if(!\Schema::hasColumn('full_final','employees'))
            {
                $table->dropColumn('full_final');
            }

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
    }
}
