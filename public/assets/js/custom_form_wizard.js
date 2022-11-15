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
       

        
        // Form Wizard
        var form = $("#custom-form-wizard");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
           
            
        });
        form.children(".wizard").steps({
            headerTag: ".wizard-section-title",
            bodyTag: ".wizard-section",
            onStepChanging: function (event, currentIndex, newIndex) {
                event.preventDefault();


                // var selected = $('#datepicker4').val();
                
                // var days = $('#probation_period').val();
    
                // var myInt = parseInt(days);                   
                // var newdate = new Date(selected);
                // newdate.setDate(newdate.getDate() + myInt);
    
                // var dd = newdate.getDate();
                // var mm = newdate.getMonth() + 1 ;
                // var y = newdate.getFullYear();
                // var someFormattedDate = mm + '/' + dd + '/' + y;
                // console.log(someFormattedDate);
    
                // $("#datepicker5").val(someFormattedDate);
                


                form.validate().settings.ignore = ":disabled,:hidden";
               

                return form.valid();
               

            },
            // onFinishing: function (event, currentIndex) {
            //     form.validate().settings.ignore = ":disabled";
            //     return form.valid();
            // },
            onFinished: function (event, currentIndex) {
                event.preventDefault();
                var emp_name = $('#emp_name').val();
         


                //alert(emp_name)
                var emp_code = $('#emp_code').val();
                var emp_email = $('#emp_email').val();
                console.log(emp_email);

                var personal_email = $('#personal_email').val();
                var aadhar_number = $('#aadhar_number').val();
                var esic_number = $('#esic_number').val();

                // console.log(personal_email);

                var emp_status = $("input[name='emp_status']:checked").val();
                var role = $('#role').val();
                var gender = $("input[name='gender']:checked").val();
                var datepicker1 = $('#datepicker1').val();
                var datepicker4 = $('#datepicker4').val();
                var mobile_phone = $('#mobile_phone').val();
                var qualification = $('.qualification_select').val();
                if (qualification == 'Other') {
                    qualification = $('.qualification_text').val();
                    console.log('my qualification' + qualification);
                }
                console.log('gender ' + gender);
                var emergency_number = $('#emergency_number').val();
                var pan_number = $('#pan_number').val();
                var father_name = $('#father_name').val();
                var address = $('#address').val();
                var permanent_address = $('#permanent_address').val();
                //var formalities = $('#formalities').val();
                var formalities = $("input[name='formalities']:checked").val();
                var offer_acceptance = $("input[name='offer_acceptance']:checked").val();
                var probation_period = $('#probation_period').val();
                if (probation_period == 'Other') {
                    probation_period = $('.probation_text').val();
                }
                var datepicker5 = $('#datepicker5').val();
                var department = $('#department').val();
                var salary = $('#salary').val();
                var bank_account_number = $('#bank_account_number').val();
                var bank_name = $('#bank_name').val();
                var ifsc_code = $('#ifsc_code').val();
                var pf_account_number = $('#pf_account_number').val();
                var un_number = $('#un_number').val();
                var full_final = $('#full_final').val();
                if($("#full_final").prop('checked') == false){
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                }
                var pf_status = $("input[name='pf_status']:checked").val();
                var token = $('#token').val();
                var mname = $('#mname').val();
                var lname = $('#lname').val();
                var mnumber_two = $('#mnumber_two').val();
                var emerg_name = $('#emerg_name').val();
                var emerg_rel = $('#emerg_rel').val();

                var photo = document.getElementById('photo_upload');
                var formData = new FormData();

                if (photo.value != '') {
                    formData.append('photo', photo.files[0], photo.value);
                }
                formData.append('mname', mname);
                formData.append('lname', lname);
                formData.append('mnumber_two', mnumber_two);
                formData.append('emerg_name', emerg_name);
                formData.append('emerg_rel', emerg_rel);


                formData.append('emp_name', emp_name);
                formData.append('personal_email', personal_email);
                formData.append('aadhar_number', aadhar_number);
                formData.append('esic_number', esic_number);
                formData.append('emp_email', emp_email);
                formData.append('emp_code', emp_code);
                formData.append('emp_status', emp_status);
                formData.append('role', role);
                formData.append('gender', gender);
                formData.append('date_of_birth', datepicker1);
                formData.append('date_of_joining', datepicker4);
                formData.append('number', mobile_phone);
                formData.append('qualification', qualification);
                formData.append('emergency_number', emergency_number);
                formData.append('pan_number', pan_number);
                formData.append('current_address', address);
                formData.append('permanent_address', permanent_address);
                formData.append('formalities', formalities);
                formData.append('offer_acceptance', offer_acceptance);
                formData.append('probation_period', probation_period);
                formData.append('date_of_confirmation', datepicker5);
                formData.append('father_name', father_name);
                formData.append('department', department);
                formData.append('salary', salary);
                formData.append('account_number', bank_account_number);
                formData.append('bank_name', bank_name);
                formData.append('ifsc_code', ifsc_code);
                formData.append('pf_account_number', pf_account_number);
                formData.append('un_number', un_number);
                formData.append('pf_status', pf_status);
                formData.append('_token', token);


                var url = $('#url').val();
                $.ajax({
                    type: 'POST',
                    url: '/' + url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        var parsed = JSON.parse(data);
                        //alert(parsed)
                        $('#modal-header').attr('class', 'modal-header ' + parsed.class);
                        $('.modal-title').append(parsed.title);
                        $('.modal-body').append(parsed.message);
                        $('#notification-modal').modal('show');
                    }
                });

            }
        });

        // Init Wizard
        var formWizard = $('.wizard');
        var formSteps = formWizard.find('.steps');

        $('.wizard-options .holder-style').on('click', function (e) {
            e.preventDefault();

            var stepStyle = $(this).data('steps-style');

            var stepRight = $('.holder-style[data-steps-style="steps-right"]');
            var stepLeft = $('.holder-style[data-steps-style="steps-left"]');
            var stepJustified = $('.holder-style[data-steps-style="steps-justified"]');

            if (stepStyle === "steps-left") {
                stepRight.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-right steps-justified');
            }
            if (stepStyle === "steps-right") {
                stepLeft.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-justified');
            }
            if (stepStyle === "steps-justified") {
                stepLeft.removeClass('holder-active');
                stepRight.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-right');
            }

            if ($(this).hasClass('holder-active')) {
                formWizard.removeClass(stepStyle);
            } else {
                formWizard.addClass(stepStyle);
            }

            $(this).toggleClass('holder-active');
        });
        
        
      
        $('#mobile_phone,#emergency_number,#salary,#aadhar_number,#salary,#mnumber_two,#bank_account_number').keypress(function(event) {
            var keycode = event.which;
            console.log(keycode);
            if (!(keycode >= 48 && keycode <= 57)) {
                event.preventDefault();
            
            }
        });
        $('#emp_name,#mname,#lname,#emerg_name,#emerg_rel,#bank_name,#father_name').keypress(function(event) {
            var keycode = event.which;
            if ((keycode >= 48 && keycode <= 57)) {
                event.preventDefault();
               
            }
        });
   
    
        $('#emp_email').change(function() {
            var val = $(this).val();
            if(val.indexOf('@techsevin.com') == -1)
                $(this).val(val+'@techsevin.com');
        }); 
        // $('#datepicker1,#datepicker4,#datepicker5').change(function() {
        //     var val = $(this).val();
        //     console.log(val);
         
        // }); 
    
        $('#full_final').change(function() {
            if($("#full_final").prop('checked') == false){
               
            }
        }); 
        
        $('#photo_upload').on("change", function(){
            var ext = $('#photo_upload').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                var text="Invalid Format(supported format:png,jpg,jpeg)";
            }else{
                var text = "";
            }
            $('#output').text(text);
        });
      
        $('#emp_email').on('change',function() {
            var emp_email = $('#emp_email').val(); 
            $.ajax({
                url:"/search-empemail",
                type:"GET",
                data:{'emp_email':emp_email},
                success: function(data){
                $('#mailError').html(data);
                }

            });
        });
        $('#emp_code').on('change',function() {
            var emp_code = $('#emp_code').val(); 
            $.ajax({
                url:"/search-empcode",
                type:"GET",
                data:{'emp_code':emp_code},
                success: function(data){
                $('#codeerror').html(data);
                }

            });
        });

        // $("#emp_email").keypress(function (e) {
        //     var keyCode = e.keyCode || e.which;
    
        //     $("#lblError").html("");
    
        //     //Regex for Valid Characters i.e. Alphabets and Numbers.
        //     var regex = /^[A-Za-z0-9]+$/;
    
        //     //Validate TextBox value against the Regex.
        //     var isValid = regex.test(String.fromCharCode(keyCode));
            
        //     return isValid;
        // });
    
    
       
            $('#datepicker1,#datepicker4,#datepicker5').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: 'dd-mm-yy',
            });
        
        $("#datepicker4").on("change",function(){
            var selected = $(this).val();
            var second_date = moment(selected).format('DD/MM/YYYY');  
            $("#probation_period").change(function()
            {
                let days = $(this).val();
                var myInt = parseInt(days);                   
                var newdate = new Date(second_date);
                newdate.setDate(newdate.getDate() + myInt);
    
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1 ;
                var yy = newdate.getFullYear();
                var someFormattedDate = dd + '-' + mm + '-' + yy;
                console.log(someFormattedDate);
                $("#datepicker5").val(someFormattedDate);
            });
        });    
    
        $("#datepicker4").on("change",function(){
        var selected = $(this).val();
        var second_date = moment(selected).format('DD/MM/YYYY');  

        
            // console.log(selected);
            let days = $('#probation_period').val();
            // console.log(days);
    
            var myInt = parseInt(days);                   
            var newdate = new Date(second_date);
            newdate.setDate(newdate.getDate() + myInt);
    
            var dd = newdate.getDate();
            var mm = newdate.getMonth() + 1 ;
            var yy = newdate.getFullYear();
            var someFormattedDate = dd + '-' + mm + '/' + yy;
            // console.log(someFormattedDate);
    
            $("#datepicker5").val(someFormattedDate);
        }); 
    });

})(jQuery);
