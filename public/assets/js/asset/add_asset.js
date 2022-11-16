/**
 * Created by Techsevin on 2/8/16.
 */

 'use strict';
 //  Author: ThemeREX.com
 //  forms-wizard.html scripts
 //
 
 
 
 (function ($) {
 
     $(document).ready(function () {
         
 
         "use strict";


         $("div.desc").hide();
        var device = $('input[name="device"]:checked').val();
        $("#" + device).show();
    $("input[name$='device']").click(function() {
        var testing = $(this).val();
        $('#set_device').val(testing);
        var test = $(this).val();
        $("div.desc").hide();
        $("#" + test).show();
    });

    $("input[name$='d_type']").click(function() {
        var testing = $(this).val();
        console.log(testing);
        if(testing == 7){
            $("div.disk").show();
            $("#cpu_hdd,#cpu_ssd").prop('required', true);

        }
        else{
            if(testing == 5){
                $("#cpu_ssd").prop('required', true);
                $("#cpu_hdd").prop('required', false);

            }
            if(testing == 6){
                $("#cpu_ssd").prop('required', false);
                $("#cpu_hdd").prop('required', true);
            }
            
          $("div.disk").hide();
            $("#" + testing).show(); 
        }
       
    });
    $("input[name$='disk_type']").click(function() {
        var testing = $(this).val();
        if(testing == 5){
            $("#laptop_ssd").prop('required', true);
            $("#laptop_hdd").prop('required', false);

            $("div.disk").hide();
            $("#ssd").show(); 
        }
        if(testing == 6){
            $("#laptop_hdd").prop('required', true);
            $("#laptop_ssd").prop('required', false);

            $("div.disk").hide();
            $("#hdd").show(); 
        }if(testing == 7){
            $("#laptop_hdd,#laptop_ssd").prop('required', true);
            $("div.disk").show();
        }
       
    });
    
        });
    

    })(jQuery);