@extends('hrms.layouts.base')

@section('content')
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
                <li class="breadcrumb-link">
                    <a href=""> Holiday </a>
                </li>
                <li class="breadcrumb-current-item"> Edit Holidays </li>
            </ol>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix" data-spy="affix" data-offset-top="200">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs"> Edit Holidays </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{Session::get('flash_message')}}
                                        </div>
                                        @endif
                                        {!! Form::open(['class' => 'form-horizontal']) !!}


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Occasion </label>
                                            <div class="col-md-6">
                                                <input type="text" name="occasion" id="input002" class=" form-control"
                                                    value="@if($holidays){{$holidays->occasion}}@endif" required>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="datepicker1" class="col-md-3 control-label"> Date </label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar text-alert pr11"></i>
                                                    </div>

                                                    <input type="text" id="datepicker1"
                                                        class="select2-single form-control" readonly="readonly"
                                                        name="date_from"
                                                        value="@if($holidays){{date('d-m-Y',strtotime($holidays->date_from))}}@endif"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group">
                                                <label for="datepicker1" class="col-md-3 control-label"> Date To </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>

                                                        <input type="text" id="datepicker2" class="select2-single form-control" name="date_to" value="@if($holidays){{$holidays->date_to}}@endif" required>
                                                    </div>
                                                </div>
                                            </div> -->


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">

                                                <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                    value="Submit">

                                            </div>
                                            <div class="col-md-2"><a href="/add-holiday">
                                                    <input type="button" class="btn btn-bordered btn-success btn-block"
                                                        value="Reset"></a>
                                            </div>
                                        </div>

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
<<!-- -------------- Scripts -------------- -->

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
