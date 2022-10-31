<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHolidayDeleteDateTo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('holidays' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('date_to','holidays'))
            {
                $table->dropColumn('date_to');
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
        \Schema::table('holidays' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('date_to','holidays'))
            {
                $table->string('date_to')->after('date_from');
            }
        
        });
        
    }
}
