@extends('hrms.layouts.base')

@section('content')

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="alt">
                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-active">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-link">
                            <a href="#"> Separation </a>
                        </li>
                        <li class="breadcrumb-current-item">Exit Formailites</li>
                    </ol>
                </div>
        </header>
        <!-- -------------- /Topbar -------------- -->

        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">

            <div class="mw1000 center-block">
                @if(session('message'))
                    {{session('message')}}
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ session::get('flash_message') }}
                    </div>
                    @endif

                            <!-- -------------- Wizard -------------- -->
                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">

                        <form method="post" action="" id="custom-form-wizard">

                        {{ csrf_field() }}
                            <!-- <div class="wizard steps-bg steps-left"> -->

                                <!-- -------------- step 1 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user pr5"></i>Exit Formalities</h4>
                                <section class="wizard-section">
                                    
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                    <!-- -------------- /section -------------- -->

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Employee Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            
                                                <input type="text" name="get_emp1" id="get_emp1" class="gui-input"
                                                       placeholder="employee name..." >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                        </label>
                                        <div id ="emp_list1"></div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Designation </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                           
                                                <input type="text" name="emp_design" id="emp_design" class="gui-input"
                                                       placeholder="employee Designation..." >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                         
                                        </label>
                                    </div>     
                                    <div class="section" style = "display: none">
                                        <label for="input002"><h6 class="mb20 mt40">Email</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                           
                                                <input type="text" name="emp_email" id="emp_email" class="gui-input"
                                                       placeholder="employee Email..." >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                         
                                        </label>
                                    </div>  

                                    <div class="section" style = "display: none">
                                        <label for="input002"><h6 class="mb20 mt40">Name</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                           
                                                <input type="text" name="emp_id" id="emp_id" class="gui-input"
                                                       placeholder="employee id..." >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                         
                                        </label>
                                    </div>  
                                    
                                    
                                    <button type= "submit" class="btn btn-bordered btn-info btn-block" style="margin-top: 3rem; width: auto; float:right" >submit</button>
                                  
                                    <!-- -------------- /section -------------- -->
                                </section>
                   
                            <!-- -------------- /Wizard -------------- -->

                        </form>
                        <!-- -------------- /Form -------------- -->

                    </div>
                    <!-- -------------- /Spec Form -------------- -->

            </div>

        </section>
        <!-- -------------- /Content -------------- -->

    </section>

   
    <!-- -------------- /Sidebar Right -------------- -->

</div>

<!-- -------------- /Body Wrap  -------------- -->

<!-- Notification modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /Notification Modal -->
<style>
    /*page demo styles*/
    .wizard .steps .fa,
    .wizard .steps .glyphicon,
    .wizard .steps .glyphicon {
        display: none;
    }
</style>

<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->

{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}

        <!-- -------------- HighCharts Plugin -------------- -->
{!! Html::script('/assets/js/plugins/highcharts/highcharts.js') !!}

        <!-- -------------- MonthPicker JS -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery-ui-monthpicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery-ui-datepicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.spectrum.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.stepper.min.js') !!}


        <!-- -------------- Plugins -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery.validate.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.steps.min.js') !!}

        <!-- -------------- Theme Scripts -------------- -->
{!! Html::script('/assets/js/utility/utility.js') !!}
{!! Html::script('/assets/js/demo/demo.js') !!}
{!! Html::script('/assets/js/main.js') !!}
{!! Html::script('/assets/js/demo/widgets_sidebar.js') !!}
{!! Html::script('/assets/js/custom_form_wizard.js') !!}

{!!  Html::script ('/assets/js/pages/forms-widgets.js')!!}
@push('scripts')
<script src="/assets/js/custom_form_wizard.js"></script>
@endpush

        <!-- -------------- Select2 JS -------------- -->
<script src="/assets/js/plugins/select2/select2.min.js"></script>
<script src="/assets/js/function.js"></script>





<!-- -------------- /Scripts -------------- -->
@endsection