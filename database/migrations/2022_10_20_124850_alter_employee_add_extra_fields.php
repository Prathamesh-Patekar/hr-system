<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeAddExtraFields extends Migration
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
            if(!\Schema::hasColumn('mname','employees'))
            {
                $table->string('mname')->after('name');
            }
            if(!\Schema::hasColumn('lname','employees'))
            {
                $table->string('lname')->after('mname');

            }
            if(!\Schema::hasColumn('mnumber_two','employees'))
            {
                $table->string('mnumber_two')->after('number');

            }
            if(!\Schema::hasColumn('emerg_name','employees'))
            {
                $table->string('emerg_name')->before('emergency_number');

            }
            if(!\Schema::hasColumn('emerg_rel','employees'))
            {
                $table->string('emerg_rel')->before('emerg_name');

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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('mname');
            $table->dropColumn('lname');
            $table->dropColumn('mnumber_two');
            $table->dropColumn('emerg_name');
            $table->dropColumn('emerg_rel');
        });
    }
}
