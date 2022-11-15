@extends('hrms.layouts.base')

@section('content')
<!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">
            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset-assignment/{id}')
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
                    <a href=""> Assets </a>
                </li>
                <li class="breadcrumb-current-item"> Edit </li>
            </ol>


            @else
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
                    <a href=""> Assets </a>
                </li>
                <li class="breadcrumb-current-item"> Assign Assets </li>
            </ol>
            @endif
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
                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset-assignment/{id}')
                                <span class="panel-title hidden-xs"> Edit Asset Assignment </span>
                                @else
                                <span class="panel-title hidden-xs"> Assign Asset</span>
                                @endif
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
                                        {!! Form::open(['class' => 'form-horizontal']) !!}
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Asset Owner </label>
                                            <div class="col-md-8">

                                                <label class="field option mb5">
                                                    <input type="radio" value="0" name="owner" id="owner" class="owner"
                                                        @if(isset($assigns))@if($assigns->owner == '0') checked @endif
                                                    @endif >
                                                    <span>Compony</span>
                                                </label>
                                                <label class="field option mb5">
                                                    <input type="radio" value="1" name="owner" id="owner" class="owner"
                                                        @if(isset($assigns))@if($assigns->owner == '1') checked @endif
                                                    @endif>
                                                    <span>Personal</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="0" class="desc">

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Employee </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="emp_id" required>
                                                        @foreach($emps as $emp)
                                                        @if($emp->id == $assigns->user_id)
                                                        <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                        @else
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Asset </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="asset_id" required>
                                                        <option value="{{$assigns->asset_id}}" selected>
                                                            {{getDevice($assigns->asset->device)}}:{{$assigns->asset->name}}:{{$assigns->asset->processor}}:{{$assigns->asset->ram}}
                                                        </option>

                                                        @foreach($assets as $asset)

                                                        <option value="{{$asset->id}}">
                                                            {{getDevice($asset->device)}}:{{isset($asset->name)?$asset->name:""}},
                                                            processor:{{isset($asset->processor)?$asset->processor:""}},
                                                            ram:{{isset($asset->ram)?$asset->ram:""}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Accessories </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="accessory_id[]" multiple>

                                                        <?php 
                                                            if (!empty($assigns->accessory_id ) || !empty($assigns->accessory_name) ) {
                                                        
                                                    
                                                                $local=[];
                                                                $local []= $assigns->accessory_id; 
                                                                $local []=$assigns->accessory_name;
                                                               \Log::info($local[0]);
                                                                $assigns->device;
                                                                ?>
                                                        @foreach($accessories as $accessory)

                                                        @endforeach
                                                        <?php
                                                                $i=0;
                                                                    foreach($local[0] as $item)
                                                                    {
                                                                        ?>

                                                        <option value="{{$local[0][$i]}}" selected>{{$local[1][$i]}}
                                                        </option>

                                                        <?php 
                                                                          $i++;
                                                                    }
                                                                      
                                                                  
                                                            }
                                                        ?>
                                                        @foreach($accessories as $accessory)
                                                        <option value="{{$accessory->id}}">
                                                            {{getDevice($accessory->device)}}:{{$accessory->name}}
                                                        </option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Issuing Authority </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="authority_id" required>
                                                        <option value="" selected>Select One</option>
                                                        @foreach($issueAuth as $emp)
                                                        @if($emp->user->id == $assigns->authority_id)
                                                        <option value="{{$emp->user->id}}" selected>{{$emp->user->name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$emp->user->id}}">{{$emp->user->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="datepicker1" class="col-md-3 control-label"> Date of
                                                    Assignment </label>
                                                <div class="col-md-6">

                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                        <input type="text" id="datepicker1"
                                                            class=" select2-single form-control" name="doa"
                                                            value="@if($assigns){{date('d-m-Y',strtotime($assigns->date_of_assignment))}}@endif"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                        value="Submit">

                                                </div>
                                                <div class="col-md-2"><a href="/edit-asset-assignment/{id}">
                                                        <input type="button"
                                                            class="btn btn-bordered btn-success btn-block"
                                                            value="Reset"></a></div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        {!! Form::open(['class' => 'form-horizontal']) !!}
                                        <div id="1" class="desc">

                                            <div class="form-group" style="display:none">
                                                <label class="col-md-3 control-label"> Select Employee </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="owner_id" id="owner_id" value="">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Employee </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="emp_id" required>
                                                        <option value="" selected>Select One</option>
                                                        @foreach($emps as $emp)
                                                        @if($emp->id == $assigns->user_id)
                                                        <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                        @else
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>

                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Issuing Authority </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                        name="authority_id" required>
                                                        <option value="" selected>Select One</option>
                                                        @foreach($issueAuth as $emp)
                                                        @if($emp->user->id == $assigns->authority_id)
                                                        <option value="{{$emp->user->id}}" selected>{{$emp->user->name}}
                                                        </option>
                                                        @else
                                                        <option value="{{$emp->user->id}}">{{$emp->user->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="datepicker2" class="col-md-3 control-label"> Date of
                                                    Assignment </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                        <input type="text" id="datepicker2"
                                                            class=" select2-single form-control" name="doa"
                                                            value="@if($assigns){{date('d-m-Y',strtotime($assigns->date_of_assignment))}}@endif"
                                                            autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                        value="Submit">
                                                </div>
                                                <div class="col-md-2"><a href="/assign-asset">
                                                        <input type="button"
                                                            class="btn btn-bordered btn-success btn-block"
                                                            value="Reset"></a></div>
                                            </div>
                                        </div>

                                    </div>

                                    {!! Form::close() !!}
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
@push('scripts')
<script src="/assets/js/pages/forms-widgets.js"></script>
<script src="/assets/js/custom.js"></script>
@endpush

<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}
<script>
$(document).ready(function() {
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
});
$(document).ready(function() {
    $("#datepicker1,#datepicker2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
});
</script>