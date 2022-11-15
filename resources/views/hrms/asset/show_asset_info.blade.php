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
                    <a href=""> Asset </a>
                </li>
                <li class="breadcrumb-current-item"> Asset listing </li>
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
                            <span class="panel-title hidden-xs"> Asset view </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            <div>
                                @foreach($assets as $value)
                                @if($value->device == 0  || $value->device == 1)
                                <div>
                                    <label>Device : </label>
                                    {{ getDevice($value->device) }}
                                </div>
                                <div>
                                    <label>Name : </label>
                                    {{ $value->name }}
                                </div>
                                <div>
                                    <label>Device Sr : </label>
                                    {{ $value->device_sr }}
                                </div>
                                <div>
                                    <label>Processor : </label>
                                    {{ $value->processor }}
                                </div>
                                <div>
                                    <label>Ram : </label>
                                    {{ $value->ram }}
                                </div>
                                <div>
                                    <label>Storage Type : </label>
                                    {{ getStorageType($value->storage_type) }}
                                </div>
                                <div>
                                    <label>SSD  : </label>
                                    {{ isset($value->ssd)? $value->ssd : '' }}
                                </div>
                                <div>
                                    <label>HDD  : </label>
                                    {{ isset($value->hdd)? $value->hdd : '' }}
                                </div>
                                <div>
                                    <label>Description : </label>
                                    {{ isset($value->description)? $value->description : '' }}
                                </div>
                                <div>
                                    <label>Status  : </label>
                                    {{ getStatus($value->status) }}
                                </div>
                               
                                
                           
                                @endif

                                @if($value->device == 2  || $value->device == 3)
                                <div>
                                    <label>Device : </label>
                                    {{ getDevice($value->device) }}
                                </div>
                                <div>
                                    <label>Name : </label>
                                    {{ $value->name }}
                                </div>
                                <div>
                                    <label>Device Sr : </label>
                                    {{ $value->device_sr }}
                                </div>
                                <div>
                                    <label>Processor : </label>
                                    {{ $value->processor }}
                                </div>
                                <div>
                                    <label>Ram : </label>
                                    {{ $value->ram }}
                                </div>
                               
                                <div>
                                    <label>Storage  : </label>
                                    {{ isset($value->ssd)? $value->ssd : '' }}
                                </div>
                                <div>
                                    <label>OS : </label>
                                    {{ $value->os }}
                                </div>
                                <div>
                                    <label>IMEI : </label>
                                    {{ $value->imei }}
                                </div>
                                <div>
                                    <label>Description : </label>
                                    {{ isset($value->description)? $value->description : '' }}
                                </div>
                               
                                <div>
                                    <label>Status  : </label>
                                    {{ getStatus($value->status) }}
                                </div>
                               
                                
                           
                                @endif
                                @if($value->device == 4  || $value->device == 5 || $value->device == 6)
                                <div>
                                    <label>Device : </label>
                                    {{ getDevice($value->device) }}
                                </div>
                                <div>
                                    <label>Name : </label>
                                    {{ $value->name }}
                                </div>
                                <div>
                                    <label>Device Sr : </label>
                                    {{ $value->device_sr }}
                                </div>
                               
                                <div>
                                    <label>Description : </label>
                                    {{ isset($value->description)? $value->description : '' }}
                                </div>
                               
                                <div>
                                    <label>Status  : </label>
                                    {{ getStatus($value->status) }}
                                </div>
                               
                                @endif
                           
                                @endforeach
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