<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('assets' , function(Blueprint $table)
        {
           
            if(!\Schema::hasColumn('device','assets'))
            {
                $table->tinyInteger('device')->after('name');

            }
        
            if(!\Schema::hasColumn('device_sr','assets'))
            {
                $table->string('device_sr')->after('device');

            }
            if(!\Schema::hasColumn('device_model','assets'))
            {
                $table->string('device_model')->after('device_sr');

            }
            if(!\Schema::hasColumn('processor','assets'))
            {
                $table->string('processor')->after('device_model');

            }
            if(!\Schema::hasColumn('ram','assets'))
            {
                $table->string('ram')->after('processor');

            }  
            if(!\Schema::hasColumn('storage_type','assets'))
            {
                $table->tinyInteger('storage_type')->after('ram');

            }
            if(!\Schema::hasColumn('ssd','assets'))
            {
                $table->string('ssd')->after('storage_type');

            } 
            if(!\Schema::hasColumn('hdd','assets'))
            {
                $table->string('hdd')->after('ssd');

            } 
            if(!\Schema::hasColumn('os','assets'))
            {
                $table->string('os')->after('hdd');

            }
            if(!\Schema::hasColumn('imei','assets'))
            {
                $table->string('imei')->after('os');

            }
            if(!\Schema::hasColumn('status','assets'))
            {
                $table->string('status')->after('imei');

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
        \Schema::table('assets' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('device','assets'))
            {
                $table->dropColumn('device');
        
            }
            if(!\Schema::hasColumn('device_sr','assets'))
            {
                $table->dropColumn('device_sr');
        
            }
            if(!\Schema::hasColumn('device_model','assets'))
            {
                $table->dropColumn('device_model');
        
            }
            if(!\Schema::hasColumn('processor','assets'))
            {
                $table->dropColumn('processor');
        
            }
            if(!\Schema::hasColumn('ram','assets'))
            {
                $table->dropColumn('ram');
        
            }  
            if(!\Schema::hasColumn('storage_type','assets'))
            {
                $table->dropColumn('storage_type');
        
            }
            if(!\Schema::hasColumn('ssd','assets'))
            {
                $table->dropColumn('ssd');
        
            }
            if(!\Schema::hasColumn('hdd','assets'))
            {
                $table->dropColumn('hdd');
        
            }
            if(!\Schema::hasColumn('imei','assets'))
            {
                $table->dropColumn('imei');
            }
            if(!\Schema::hasColumn('os','assets'))
            {
                $table->dropColumn('os');
            }
            if(!\Schema::hasColumn('status','assets'))
            {
                $table->dropColumn('status');
            }
            
        });
    }
}
