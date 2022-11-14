@extends('hrms.layouts.base')

@section('content')
<!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">

            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-accessory/{id}')

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
                    <a href=""> Add Accessory  </a>
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
                <li class="breadcrumb-current-item"> Add Accessory </li>
            </ol>
            @endif
        </div>
        <div class="topbar-right">
            <h4><a class="link-unstyled" href="/upload-accessory" title="">
                <i class="fa fa-upload" aria-hidden="true"></i> Upload Accessory </a></h4>
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
        </aside> -->
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
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-accessory/{id}')
                                            <span class="panel-title hidden-xs"> Edit Accessories </span>
                                            @else
                                            <span class="panel-title hidden-xs"> Add Accessories </span>
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
                                                        <label class="col-md-3 control-label"> Accessory </label>
                                                        <div class="col-md-8">
                                                        @if(\Route::getFacadeRoot()->current()->uri() ==
                                                            'edit-accessory/{id}')
                                                            <label class="field option mb5">
                                                                <input type="radio" value="4" name="accessory"
                                                                    id="accessory" class="accessory" @if(isset($result))@if($result->device == '4') checked @endif @endif>
                                                                <span>Mouse</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="5" name="accessory"
                                                                    id="accessory" class="accessory" @if(isset($result))@if($result->device == '5') checked @endif @endif>
                                                                <span>Keyboard</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="6" name="accessory"
                                                                    id="accessory" class="accessory" @if(isset($result))@if($result->device == '6') checked @endif @endif>
                                                                <span>Monitor</span>
                                                            </label>
                                                            @else
                                                            <label class="field option mb5">
                                                                <input type="radio" value="4" name="accessory"
                                                                    id="accessory" class="accessory" checked>
                                                                <span>Mouse</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="5" name="accessory"
                                                                    id="accessory" class="accessory">
                                                                <span>Keyboard</span>
                                                            </label>
                                                            <label class="field option mb5">
                                                                <input type="radio" value="6" name="accessory"
                                                                    id="accessory" class="accessory">
                                                                <span>Monitor</span>
                                                            </label>

                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"> Accessory
                                                            Name</label>
                                                        <div class="col-md-8">
                                                            @if(\Route::getFacadeRoot()->current()->uri() ==
                                                            'edit-accessory/{id}')
                                                            <input type="text" name="accessory_name"
                                                                id="accessory_name"
                                                                class="select2-single form-control"
                                                                value="@if($result && $result->name){{$result->name}}@endif"
                                                                required>
                                                            @else
                                                            <input type="text" name="accessory_name"
                                                                id="accessory_name"
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
                                                            'edit-accessory/{id}')
                                                            <input type="text" name="accessory_sr" id="accessory_sr"
                                                                class="select2-single form-control"
                                                                value="@if($result && $result->device_sr){{$result->device_sr}}@endif" required>
                                                            @else
                                                            <input type="text" name="accessory_sr" id="accessory_sr"
                                                                class="select2-single form-control"
                                                                placeholder="Serial No.." required >
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"> Description
                                                        </label>
                                                        <div class="col-md-8">
                                                            @if(\Route::getFacadeRoot()->current()->uri() ==
                                                            'edit-accessory/{id}')
                                                            <textarea class="select2-single form-control"
                                                                rows="3" name="accessory_description"
                                                                id="accessory_description" 
                                                                required> @if($result && $result->description){{$result->description}}@endif</textarea>
                                                            @else
                                                            <textarea class="select2-single form-control"
                                                                rows="3" 
                                                                placeholder="Accessory Description.."
                                                                name="accessory_description" id="accessory_description"
                                                                required></textarea>
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

</script>