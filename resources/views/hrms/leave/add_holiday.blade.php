
@extends('hrms.layouts.base')

@section('content')
<body class="forms-wizard">
        <!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="/dashboard">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="/dashboard"> Dashboard </a>
                </li>

                <li class="breadcrumb-current-item"> Add Holiday</li>
            </ol>
        </div>
      
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Left -------------- -->
       
        <!-- -------------- /Column Left -------------- -->

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <div class="">

                <div class="tab-content mw900 center-block center-children">


                    <!-- -------------- Upload Form -------------- -->
                    <div class="allcp-form theme-primary tab-pane active mw320" id="login" role="tabpanel">
                        <div class="box box-success">
                        <div class="panel fluid-width">

                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="panel-body pn mv12">
                                <!-- -------------- /section -------------- -->

                                <div class="section">
                                    <label for="username" class="field prepend-icon"> <h6 > Occasion </h6> </label>
                                    <input type="text" class="gui-input" name="description" id="description"
                                           placeholder="Description" required>
                                </div>

                                <div class="section">
                                    <div class="input-group">
                                        <label for="date" class="field prepend-icon"> <h6> Select Date </h6></label>
                                        <input type="text" id="datepicker1" class="gui-input fs13 select2-single form-control" name="date" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="section">
                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                </div>

                                <!-- -------------- /section -------------- -->
                            </div>
                            {!! Form::close() !!}
                                    <!-- -------------- /Form -------------- -->
                            </form>
                        </div>
                            </div>
                        <!-- -------------- /Panel -------------- -->
                    </div>
                    <!-- -------------- /Login Form -------------- -->



                    <!-- -------------- Registration -------------- -->
               
                    <!-- -------------- /Registration -------------- -->

                </div>

            </div>
        </div>
        <!-- -------------- /Column Center -------------- -->

    </section>
    <!-- -------------- /Content -------------- -->
</div>
@endsection


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
{!! Html::script('/assets/js/custom.js') !!}

{!!  Html::script ('/assets/js/pages/forms-widgets.js')!!}
@push('scripts')
<script src="/assets/js/custom_form_wizard.js"></script>
@endpush

        <!-- -------------- Select2 JS -------------- -->
<script src="/assets/js/plugins/select2/select2.min.js"></script>
<script src="/assets/js/function.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<!-- -------------- /Scripts -------------- -->
