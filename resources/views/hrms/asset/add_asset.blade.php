@extends('hrms.layouts.base')

@section('content')
<!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">

            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset/{id}')

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
                <li class="breadcrumb-current-item"> Edit {{$result->name}} </li>
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
                <li class="breadcrumb-current-item"> Add Asset </li>
            </ol>
            @endif
        </div>
    </header>
    <!-- -------------- Content -------------- -->

    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset/{id}')
                                <span class="panel-title hidden-xs"> Edit Asset </span>
                                @else
                                <span class="panel-title hidden-xs"> Add Asset </span>
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

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Device </label>
                                            <div class="col-md-8">
                                                <label class="field option mb5">
                                                    <input type="radio" value="0" name="device" id="device"
                                                        class="device" required>
                                                    <span>Desktop</span>
                                                </label>
                                                <label class="field option mb5">
                                                    <input type="radio" value="1" name="device" id="device"
                                                        class="device">
                                                    <span>Laptop</span>
                                                </label>
                                                <label class="field option mb5">
                                                    <input type="radio" value="2" name="device" id="device"
                                                        class="device">
                                                    <span>Phone</span>
                                                </label>
                                                <label class="field option mb5">
                                                    <input type="radio" value="3" name="device" id="device"
                                                        class="device">
                                                    <span>Tablet</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="0" class="desc">


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> CPU Name</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control" placeholder="Model Name.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Serial No.</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_sr" id="device_sr"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_sr" id="device_sr"
                                                        class="select2-single form-control" placeholder="Serial No.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Processor </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        placeholder="eg. intel i3,ryzen 5.." required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Ram </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control" placeholder="eg.8gb,16gb.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Storage Type </label>
                                                <div class="col-md-8">
                                                    <label class="field option mb5">
                                                        <input type="radio" value="0" name="disk_type" id="disk_type">
                                                        SSD</label>
                                                    <label class="field option mb5">
                                                        <input type="radio" value="1" name="disk_type" id="disk_type"
                                                            checked> HDD

                                                    </label>

                                                    <label class="field option mb5">
                                                        <input type="radio" value="2" name="disk_type" id="disk_type">
                                                        SSD+HDD
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Storage Size </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control" placeholder="eg.500gb,1TB.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Description </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" name="description" id="description"
                                                        required>@if($result && $result->description){{$result->description}}@endif </textarea>
                                                    @else
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" placeholder="Asset Description"
                                                        name="description" id="description" required></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-3">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                        value="Submit">

                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/add-asset">
                                                        <input type="button"
                                                            class="btn btn-bordered btn-success btn-block"
                                                            value="Reset">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="1" class="desc">


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Laptop Name</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control" placeholder="Model Name.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-md-3 control-label"> Model Name</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_model" id="device_model"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_model" id="device_model"
                                                        class="select2-single form-control" placeholder="Model No.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Serial No.</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_sr" id="device_sr"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_sr" id="device_sr"
                                                        class="select2-single form-control" placeholder="Serial No.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Processor </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        placeholder="eg. intel i3,ryzen 5.." required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Ram </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control" placeholder="eg.8gb,16gb.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Storage Type </label>
                                                <div class="col-md-8">
                                                    <label class="field option mb5">
                                                        <input type="radio" value="0" name="disk_type" id="disk_type">
                                                        SSD</label>
                                                    <label class="field option mb5">
                                                        <input type="radio" value="1" name="disk_type" id="disk_type"
                                                            checked> HDD

                                                    </label>

                                                    <label class="field option mb5">
                                                        <input type="radio" value="2" name="disk_type" id="disk_type">
                                                        SSD+HDD
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Storage Size </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control" placeholder="eg.500gb,1TB.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Description </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" name="description" id="description"
                                                        required>@if($result && $result->description){{$result->description}}@endif </textarea>
                                                    @else
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" placeholder="Asset Description"
                                                        name="description" id="description" required></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-3">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                        value="Submit">

                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/add-asset">
                                                        <input type="button"
                                                            class="btn btn-bordered btn-success btn-block"
                                                            value="Reset">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="2" class="desc">


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Phone Name</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_brand" id="device_brand"
                                                        class="select2-single form-control" placeholder="Model Name.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-md-3 control-label"> Model Name</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="device_model" id="device_model"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="device_model" id="device_model"
                                                        class="select2-single form-control" placeholder="Model No.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div> -->

                                      


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Processor </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="processor" id="processor"
                                                        class="select2-single form-control"
                                                        placeholder="eg. intel i3,ryzen 5.." required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Ram </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="ram" id="ram"
                                                        class="select2-single form-control" placeholder="eg.8gb,16gb.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                  
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Storage </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="disk_size" id="disk_size"
                                                        class="select2-single form-control" placeholder="eg.500gb,1TB.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Operating System </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="os" id="os"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="os" id="os"
                                                        class="select2-single form-control" placeholder="Enter OS .."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> IMEI No.</label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <input type="text" name="imei" id="imei"
                                                        class="select2-single form-control"
                                                        value="@if($result && $result->name){{$result->name}}@endif"
                                                        required>
                                                    @else
                                                    <input type="text" name="imei" id="imei"
                                                        class="select2-single form-control" placeholder="Serial No.."
                                                        required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Description </label>
                                                <div class="col-md-8">
                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                    'edit-asset/{id}')
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" name="description" id="description"
                                                        required>@if($result && $result->description){{$result->description}}@endif </textarea>
                                                    @else
                                                    <textarea class="select2-single form-control" rows="3"
                                                        id="textarea1" placeholder="Asset Description"
                                                        name="description" id="description" required></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-3">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                        value="Submit">

                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/add-asset">
                                                        <input type="button"
                                                            class="btn btn-bordered btn-success btn-block"
                                                            value="Reset">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </section>
</div>


@endsection
<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}

<script>
$(document).ready(function() {
    $("div.desc").hide();
    $("input[name$='device']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#" + test).show();
    });
});
// $(document).click(function() {
//     device = $('input[name="device"]:checked').val();
//     if (device == 0) {
//         $("#mouse_name,#mouse_sr,#keyboard_name,#keyboard_sr,#cpu_name,#cpu_sr").prop('required', true);

// }   else if (device == 1) {
//     $("#mouse_name,#mouse_sr,#adapter_name,#adapter_sr").prop('required', true);
// }
// });
</script>