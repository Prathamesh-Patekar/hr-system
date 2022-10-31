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
                        <a href=""> Training </a>
                    </li>
                    <li class="breadcrumb-current-item"> Add Training Program </li>
                </ol>
            </div>
        </header>
        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn" >
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix" data-spy="affix" data-offset-top="200">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs"> Add Training Program </span>
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
                                            <label class="col-md-3 control-label"> Training Program </label>
                                            <div class="col-md-6">
                                                <input type="text" name="name" id="input002" class="select2-single form-control" placeholder="program" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Description </label>
                                            <div class="col-md-6">
                                                <textarea class="select2-single form-control" rows="3" id="textarea1" placeholder="Program Description" name="description" required></textarea>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="datepicker1" class="col-md-3 control-label"> Date From </label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar text-alert pr11"></i>
                                                    </div>
                                                    <input type="text" id="datepicker1" value="" class="select2-single form-control" name="date_from" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="datepicker4" class="col-md-3 control-label"> Date To </label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar text-alert pr11"></i>
                                                    </div>
                                                    <input type="text" id="datepicker4" value="" class="select2-single form-control" name="date_to" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Weekly/Daily </label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary"
                                                        name="lecture" id= "lecture" required>
                                                    <option value="" selected>Select One</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="daily">Daily</option>
                                                </select>
                                            </div>
                                        </div>
                                           
                                        <div class="form-group">
                                                <label for="multiselect2" class="col-md-3 control-label"> Select Days </label>
                                                <div class="col-md-6">
                                                    <select id="done" class="selectpicker form-control" multiple data-done-button="true"
                                                            name="day_ids[]" required>
                                                       
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                        
                                                    </select>
                                                </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">

                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">

                                            </div>
                                            <div class="col-md-2"><a href="/add-training-program" >
                                                    <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
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

    </section>

    </div>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="/assets/allcp/forms/css/bootstrap-select.css">
    @endpush
@endsection
@push('scripts')
    <script src="/assets/js/pages/forms-widgets.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/allcp/forms/js/bootstrap-select.js"></script>
    <script src="/assets/js/function.js"></script>
@endpush
