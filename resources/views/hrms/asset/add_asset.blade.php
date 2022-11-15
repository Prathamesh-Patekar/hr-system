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
                    <a href=""> Add Asset </a>
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
        <div class="topbar-right">
            <h4><a class="link-unstyled" href="/upload-asset" title="">
                <i class="fa fa-upload" aria-hidden="true"></i> Upload Asset </a></h4>
        </div>
    </header>
    <!-- -------------- Content -------------- -->

    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Left -------------- -->
        <!-- <aside class="chute chute-left chute290 bg-primary" data-chute-height="match">

            <div class="chute-bin1 stretch1 btn-dimmer mt20">

                <div class="tab-content pn br-n bg-none allcp-form-list">

                    <ul class="nav list-unstyled" role="tablist">

                        <li class="nav-label">General</li>
                        <li>
                            <a class="btn btn-primary btn-gradient btn-alt btn-block item-active br-n" href="#login"
                                role="tab" data-toggle="tab"> Add Device</a>
                        </li>

                        <li>
                            <a class="btn btn-danger btn-gradient btn-alt btn-block br-n" href="#register" role="tab"
                                data-toggle="tab"> Add acessories </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>  -->
        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <div class="">

                <div class="tab-content mw900 center-block center-children">


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
                                                

                                                    
                                                    {!! Form::open(['class' => 'form-horizontal']) !!}
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"> Device </label>
                                                        <div class="col-md-8">
                                                        @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                            <label class="field option mb5">
                                                                <input type="radio" value="0" name="device"
                                                                    id="device" class="device" required @if(isset($result))@if($result->device == '0') checked @endif @endif  >
                                                                    
                                                                <span>Desktop</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="1" name="device"
                                                                    id="device" class="device" @if(isset($result))@if($result->device == '1') checked @endif @endif  >
                                                                <span>Laptop</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="2" name="device"
                                                                    id="device" class="device" @if(isset($result))@if($result->device == '2') checked @endif @endif  >
                                                                <span>Phone</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="3" name="device"
                                                                    id="device" class="device" @if(isset($result))@if($result->device == '3') checked @endif @endif  >
                                                                <span>Tablet</span>
                                                            </label>
                                                            @else
                                                            <label class="field option mb5">
                                                                <input type="radio" value="0" name="device"
                                                                    id="device" class="device" checked required >
                                                                <span>Desktop</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="1" name="device"
                                                                    id="device" class="device">
                                                                <span>Laptop</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="2" name="device"
                                                                    id="device" class="device">
                                                                <span>Phone</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="3" name="device"
                                                                    id="device" class="device">
                                                                <span>Tablet</span>
                                                            </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="0" class="desc">
                                                        
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> CPU Name</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="cpu"
                                                                    id="cpu"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->name){{$result->name}}@endif" 
                                                                    required>
                                                                @else
                                                                <input type="text" name="cpu"
                                                                    id="cpu"
                                                                    class="select2-single form-control"
                                                                    placeholder="Model Name.." required>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Serial
                                                                No.</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="cpu_sr" id="cpu_sr"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->device_sr){{$result->device_sr}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="cpu_sr" id="cpu_sr"
                                                                    class="select2-single form-control"
                                                                    placeholder="Serial No.." required>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Processor
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="cpu_processor" id="cpu_processor"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->processor){{$result->processor}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="cpu_processor" id="cpu_processor"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg. intel i3,ryzen 5.."required >
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Ram </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="cpu_ram" id="cpu_ram"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ram){{$result->ram}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="cpu_ram" id="cpu_ram"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.8gb,16gb.."required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Storage Type
                                                            </label>
                                                            <div class="col-md-8">
                                                            @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="5" name="d_type"
                                                                        id="disk_type" required @if(isset($result))@if($result->storage_type == '5') checked @endif @endif >
                                                                    SSD</label>
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="6" name="d_type"
                                                                        id="disk_type"  @if(isset($result))@if($result->storage_type == '6') checked @endif @endif  > HDD
                                                                </label>

                                                                <label class="field option mb5">
                                                                    <input type="radio" value="7" name="d_type"
                                                                        id="disk_type"  @if(isset($result))@if($result->storage_type == '7') checked @endif @endif >
                                                                    SSD+HDD
                                                                </label>
                                                                @else
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="5" name="d_type"
                                                                        id="disk_type" required>
                                                                    SSD</label>
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="6" name="d_type"
                                                                        id="disk_type" > HDD
                                                                </label>

                                                                <label class="field option mb5">
                                                                    <input type="radio" value="7" name="d_type"
                                                                        id="disk_type" checked >
                                                                    SSD+HDD
                                                                </label>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div id="5" class="disk">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"> SSD
                                                                </label>
                                                                <div class="col-md-8">
                                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                    'edit-asset/{id}')
                                                                    <input type="text" name="cpu_ssd" id="cpu_ssd"
                                                                        class="select2-single form-control"
                                                                        value="@if($result && $result->ssd){{$result->ssd}}@endif"
                                                                        >
                                                                    @else
                                                                    <input type="text" name="cpu_ssd" id="cpu_ssd"
                                                                        class="select2-single form-control"
                                                                        placeholder="eg.256gb,480gb.." >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="6" class="disk">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"> HDD
                                                                </label>
                                                                <div class="col-md-8">
                                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                    'edit-asset/{id}')
                                                                    <input type="text" name="cpu_hdd" id="cpu_hdd"
                                                                        class="select2-single form-control"
                                                                        value="@if($result && $result->hdd){{$result->hdd}}@endif"
                                                                        >
                                                                    @else
                                                                    <input type="text" name="cpu_hdd" id="cpu_hdd"
                                                                        class="select2-single form-control"
                                                                        placeholder="eg.500gb,1TB.." >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Description
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <textarea class="select2-single form-control"
                                                                    rows="3"  name="cpu_description"
                                                                    id="description"
                                                                    >@if($result && $result->description){{$result->description}}@endif </textarea>
                                                                @else
                                                                <textarea class="select2-single form-control"
                                                                    rows="3" 
                                                                    placeholder="Desktop Description"
                                                                    name="cpu_description" id="cpu_description"
                                                                    ></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"></label>
                                                            <div class="col-md-3">

                                                                <input type="submit"
                                                                    class="btn btn-bordered btn-info btn-block"
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
                                                    {!! Form::open(['class' => 'form-horizontal']) !!}
                                                    
                                                    <div id="1" class="desc">
                                                    

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Laptop
                                                                Name</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="laptop"
                                                                    id="laptop"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->name){{$result->name}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="laptop"
                                                                    id="laptop"
                                                                    class="select2-single form-control"
                                                                    placeholder="Model Name.."required >
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
                                                            <label class="col-md-3 control-label"> Serial
                                                                No.</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="laptop_sr" id="laptop_sr"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->device_sr){{$result->device_sr}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="laptop_sr" id="laptop_sr"
                                                                    class="select2-single form-control"
                                                                    placeholder="Serial No.."required >
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Processor
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="laptop_processor" id="laptop_processor"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->processor){{$result->processor}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="laptop_processor" id="laptop_processor"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg. intel i3,ryzen 5.."required >
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Ram </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="laptop_ram" id="laptop_ram"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ram){{$result->ram}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="laptop_ram" id="laptop_ram"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.8gb,16gb.." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Storage Type
                                                            </label>
                                                            <div class="col-md-8">
                                                            @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="5" name="disk_type"
                                                                        id="disk_type" @if(isset($result))@if($result->storage_type == '5') checked @endif @endif >
                                                                    SSD</label>
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="6" name="disk_type"
                                                                        id="disk_type" @if(isset($result))@if($result->storage_type == '6') checked @endif @endif> HDD

                                                                </label>

                                                                <label class="field option mb5">
                                                                    <input type="radio" value="7" name="disk_type"
                                                                        id="disk_type" @if(isset($result))@if($result->storage_type == '7') checked @endif @endif >
                                                                    SSD+HDD
                                                                </label>
                                                                @else
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="5" name="disk_type"
                                                                        id="disk_type" required>
                                                                    SSD</label>
                                                                <label class="field option mb5">
                                                                    <input type="radio" value="6" name="disk_type"
                                                                        id="disk_type" > HDD

                                                                </label>

                                                                <label class="field option mb5">
                                                                    <input type="radio" value="7" name="disk_type"
                                                                        id="disk_type" checked>
                                                                    SSD+HDD
                                                                </label>

                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div id="ssd" class="disk">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"> SSD
                                                                </label>
                                                                <div class="col-md-8">
                                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                    'edit-asset/{id}')
                                                                    <input type="text" name="laptop_ssd" id="laptop_ssd"
                                                                        class="select2-single form-control"
                                                                        value="@if($result && $result->ssd){{$result->ssd}}@endif"
                                                                        >
                                                                    @else
                                                                    <input type="text" name="laptop_ssd" id="laptop_ssd"
                                                                        class="select2-single form-control"
                                                                        placeholder="eg.256gb,480gb.." >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="hdd" class="disk">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"> HDD
                                                                </label>
                                                                <div class="col-md-8">
                                                                    @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                    'edit-asset/{id}')
                                                                    <input type="text" name="laptop_hdd" id="laptop_hdd"
                                                                        class="select2-single form-control"
                                                                        value="@if($result && $result->hdd){{$result->hdd}}@endif"
                                                                        >
                                                                    @else
                                                                    <input type="text" name="laptop_hdd" id="laptop_hdd"
                                                                        class="select2-single form-control"
                                                                        placeholder="eg.500gb,1TB.." >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="form-group">
                                                            <label class="col-md-3 control-label"> Storage Size
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="disk_size" id="disk_size"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->name){{$result->name}}@endif"
                                                                    >
                                                                @else
                                                                <input type="text" name="disk_size" id="disk_size"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.500gb,1TB.." >
                                                                @endif
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Description
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <textarea class="select2-single form-control"
                                                                    rows="3"  name="laptop_description"
                                                                    id="laptop_description"
                                                                    >@if($result && $result->description){{$result->description}}@endif </textarea>
                                                                @else
                                                                <textarea class="select2-single form-control"
                                                                    rows="3" 
                                                                    placeholder="Laptop Description.."
                                                                    name="laptop_description" id="laptop_description"
                                                                    ></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"></label>
                                                            <div class="col-md-3">

                                                                <input type="submit"
                                                                    class="btn btn-bordered btn-info btn-block"
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
                                                    {!! Form::open(['class' => 'form-horizontal']) !!}
                                                    <div id="2" class="desc">
                                                        

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Phone
                                                                Name</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone"
                                                                    id="phone_brand"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->name){{$result->name}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone"
                                                                    id="phone_brand"
                                                                    class="select2-single form-control"
                                                                    placeholder="Model Name.." required>
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
                                                                >
                                                            @else
                                                            <input type="text" name="device_model" id="device_model"
                                                                class="select2-single form-control" placeholder="Model No.."
                                                                required>
                                                            @endif
                                                        </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Processor
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone_processor" id="phone_processor"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->processor){{$result->processor}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone_processor" id="phone_processor"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.Snapdragon 888.." required >
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Ram </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone_ram" id="phone_ram"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ram){{$result->ram}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone_ram" id="phone_ram"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.8gb,12gb.." required>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Storage </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone_storage" id="phone_storage"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ssd){{$result->ssd}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone_storage" id="phone_storage"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.128gb,256gb.." required>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Operating System
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone_os" id="phone_os"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->os){{$result->os}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone_os" id="phone_os"
                                                                    class="select2-single form-control"
                                                                    placeholder="Enter OS .." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> IMEI No.</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="phone_imei" id="phone_imei"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->imei){{$result->imei}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="phone_imei" id="phone_imei"
                                                                    class="select2-single form-control"
                                                                    placeholder="imei No.." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Description
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <textarea class="select2-single form-control"
                                                                    rows="3"  name="phone_description"
                                                                    id="phone_description"
                                                                    >@if($result && $result->description){{$result->description}}@endif </textarea>
                                                                @else
                                                                <textarea class="select2-single form-control"
                                                                    rows="3"
                                                                    placeholder="Asset Description.."
                                                                    name="phone_description" id="phone_description"
                                                                    ></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"></label>
                                                            <div class="col-md-3">

                                                                <input type="submit"
                                                                    class="btn btn-bordered btn-info btn-block"
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
                                                    {!! Form::open(['class' => 'form-horizontal']) !!}
                                                    <div id="3" class="desc">


                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Tablet
                                                                Name</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet"
                                                                    id="tablet"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->name){{$result->name}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="tablet"
                                                                    id="tablet"
                                                                    class="select2-single form-control"
                                                                    placeholder="Model Name.." required>
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
                                                            <label class="col-md-3 control-label"> Processor
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet_processor" id="tablet_processor"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->processor){{$result->processor}}@endif"
                                                                    requred>
                                                                @else
                                                                <input type="text" name="tablet_processor" id="tablet_processor"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.Snapdragon 888.." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Ram </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet_ram" id="tablet_ram"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ram){{$result->ram}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="tablet_ram" id="tablet_ram"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.8gb,12gb.."required >
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Storage </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet_storage" id="tablet_storage"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->ssd){{$result->ssd}}@endif"
                                                                    required >
                                                                @else
                                                                <input type="text" name="tablet_storage" id="tablet_storage"
                                                                    class="select2-single form-control"
                                                                    placeholder="eg.64gb,128gb.." required>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Operating System
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet_os" id="tablet_os"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->os){{$result->os}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="tablet_os" id="tablet_os"
                                                                    class="select2-single form-control"
                                                                    placeholder="Enter OS .." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> IMEI No.</label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <input type="text" name="tablet_imei" id="tablet_imei"
                                                                    class="select2-single form-control"
                                                                    value="@if($result && $result->imei){{$result->imei}}@endif"
                                                                    required>
                                                                @else
                                                                <input type="text" name="tablet_imei" id="tablet_imei"
                                                                    class="select2-single form-control"
                                                                    placeholder="imei No.." required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> Description
                                                            </label>
                                                            <div class="col-md-8">
                                                                @if(\Route::getFacadeRoot()->current()->uri() ==
                                                                'edit-asset/{id}')
                                                                <textarea class="select2-single form-control"
                                                                    rows="3" name="tablet_description"
                                                                    id="tablet_description"
                                                                    >@if($result && $result->description){{$result->description}}@endif </textarea>
                                                                @else
                                                                <textarea class="select2-single form-control"
                                                                    rows="3" 
                                                                    placeholder="Asset Description"
                                                                    name="tablet_description" id="tablet_description"
                                                                    ></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"></label>
                                                            <div class="col-md-3">

                                                                <input type="submit"
                                                                    class="btn btn-bordered btn-info btn-block"
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
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
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
<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}

<script>
$(document).ready(function() {
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
// $(document).click(function() {
//     device = $('input[name="device"]:checked').val();
//     console.log(device);
//     if (device == 0) {
//         $("#mouse_name,#mouse_sr,#keyboard_name,#keyboard_sr,#cpu_name,#cpu_sr").prop('required', true);

// }   else if (device == 1) {
//     $("#mouse_name,#mouse_sr,#adapter_name,#adapter_sr").prop('required', true);
// }
// });
</script>