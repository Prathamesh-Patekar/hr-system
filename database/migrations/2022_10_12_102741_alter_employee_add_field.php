<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeAddField extends Migration
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
            if(!\Schema::hasColumn('personal_email','employees'))
            {
                $table->string('personal_email')->after('photo');
            }
            if(!\Schema::hasColumn('esic_number','employees'))
            {
                $table->string('esic_number')->after('pan_number');

            }
            if(!\Schema::hasColumn('aadhar_number','employees'))
            {
                $table->string('aadhar_number')->after('un_number');

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
            $table->dropColumn('personal_email');
            $table->dropColumn('esic_number');
            $table->dropColumn('aadhar_number');
        });
    }
}
