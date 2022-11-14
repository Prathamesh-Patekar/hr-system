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
                    <a href=""> Assets </a>
                </li>
                <li class="breadcrumb-current-item"> Asset Listings </li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Asset Lists </span>
                        </div>
                        @if(Session::has('failed'))
                            <div class="alert alert-danger">
                                {{ Session::get('failed') }}
                            </div>
                        @endif
                        <div class="panel-menu allcp-form theme-primary mtn">
                            <div class="row">
                                {!! Form::open() !!}
                                <!-- <div class="col-md-3">
                                    <input type="text" class="field form-control" placeholder="query string" style="height:40px" value="" name="string">
                                </div> -->
                                <div class="col-md-3">
                                    <label class="field select">
                                    {!! Form::select('column', getDeviceDropDown(),$column) !!}
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Search" name="button" class="btn btn-primary">
                                </div>

                                <div class="col-md-2">
                                    <input type="submit" href="/asset-listing" value="Export" name="button" class="btn btn-success">
                                </div>
                                {!! Form::close() !!}
                                <div class="col-md-2">
                                    <a href="/asset-listing" >
                                        <input type="submit" value="Reset" class="btn btn-warning"></a>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body pn">

                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            {!! Form::open(['class' => 'form-horizontal']) !!}
                            
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Device Type</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Processor</th>  
                                        <th class="text-center">Ram</th>
                                        <th class="text-center">PRIMARY STORAGE</th>
                                        <th class="text-center">HDD</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i =0;?>
                                @foreach($assets as $asset)
                                    <tr>
                                        <td class="text-center">{{$i+=1}}</td>
                                        <td class="text-center">{{getDevice($asset->device)}}</td>
                                        <td class="text-center">{{$asset->name}}</td>
                                        <td class="text-center">{{empty($asset->processor) ? 'NA' :$asset->processor}}</td>
                                        <td class="text-center">{{empty($asset->ram) ? 'NA' :$asset->ram}}</td>
                                        <td class="text-center">{{empty($asset->ssd) ? 'NA' :$asset->ssd}}</td>
                                        <td class="text-center">{{empty($asset->hdd) ? 'NA' :$asset->hdd}}</td>
                                        <td class="text-center">{{getStatus($asset->status)}}</td>
                                        <td class="text-center">
                                            <div class="btn-group text-right">
                                                <button type="button"
                                                        class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"> Action
                                                    <span class="caret ml5"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                    <?php if($asset->device == 4 || $asset->device == 5 || $asset->device == 6){?>
                                                            <a href="/edit-accessory/{{$asset->id}}">Edit</a>
                                                    <?php }else{ ?>
                                                            <a href="/edit-asset/{{$asset->id}}">Edit</a>
                                                    <?php } ?>
                                                    </li>
                                                    <li>
                                                        <a href="/asset-show/{{$asset->id}}">View</a>
                                                    </li>
                                                    <li>
                                                        <a href="/delete-asset/{{$asset->id}}">Delete</a>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    {!! $assets->render() !!}
                                </tr>
                                </tbody>
                                </table>
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