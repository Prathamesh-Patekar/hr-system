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
        var device = $('input[name="owner"]:checked').val();
        $("#" + device).show();
    
        $("input[name$='owner']").click(function() {
            var testing = $(this).val();
            if (testing == 1) {
                $('#owner_id').val(testing);
            }
            $('#set_device').val(testing);
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
        $("#datepicker1,#date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: "-100:+100",
        });
    });





})(jQuery);