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
                <li class="breadcrumb-current-item"> Asset Assignment </li>
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
                            <span class="panel-title hidden-xs"> Asset Assignment view </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            <div>
                                @foreach($assets as $asset)
                                @if($asset->asset->device == 0  || $asset->asset->device == 1)
                                <div>
                                    <label>Asset Owner  : </label>
                                    {{getOwner($asset->owner)}}
                                </div>
                              
                                <div>
                                    <label>Employee Name : </label>
                                    {{$asset->employee->name}}
                                </div>
                                <div>
                                    <label>Employee Email : </label>
                                    {{$asset->employee->email}}
                                </div>
                                <div>
                                    <label>Authority Name : </label>
                                    {{$asset->authority->name}}
                                </div>
                                <div>
                                    <label>Device  : </label>
                                    {{getDevice($asset->asset->device)}}
                                </div>
                                <div>
                                    <label>Device Sr : </label>
                                    {{ $asset->asset->device_sr }}
                                </div>
                                <label> Name : </label>
                                    {{$asset->asset->name}}
                                </div>
                                <div>
                                    <label>Processor : </label>
                                    {{ $asset->asset->processor }}
                                </div>
                                <div>
                                    <label>Ram : </label>
                                    {{ $asset->asset->ram }}
                                </div>
                                <div>
                                    <label>Storage Type : </label>
                                    {{ getStorageType($asset->asset->storage_type) }}
                                </div>
                                <div>
                                    <label>SSD  : </label>
                                    {{ isset($asset->asset->ssd)? $asset->asset->ssd : '' }}
                                </div>
                                <div>
                                    <label>HDD  : </label>
                                    {{ isset($asset->asset->hdd)? $asset->asset->hdd : '' }}
                                </div>
                                <div>
                                <div>
                                    <label>Accessories Taken : </label>
                                    <?php $local = $asset->accessory_name;
                                
                                            // $array = json_encode($local,true);  
                                            foreach($local as $items)
                                            {
                                                echo $items." ";
                                                echo " ,";

                                            }
                                        ?>
                                </div>
                                    <label>Description : </label>
                                    {{ isset($asset->asset->description)? $asset->asset->description : '' }}
                                </div>
                                <div>
                                    <label>Date Of Assignment : </label>
                                    {{date('d-m-Y',strtotime($asset->date_of_assignment))}}
                                </div>
                                <hr>
                                @endif
                                @if($asset->asset->device == 2  || $asset->asset->device == 3)
                                <div>
                                    <label>Asset Owner  : </label>
                                    {{getOwner($asset->owner)}}
                                </div>
                              
                                <div>
                                    <label>Employee Name : </label>
                                    {{$asset->employee->name}}
                                </div>
                                <div>
                                    <label>Employee Email : </label>
                                    {{$asset->employee->email}}
                                </div>
                                <div>
                                    <label>Authority Name : </label>
                                    {{$asset->authority->name}}
                                </div>
                                <div>
                                    <label>Device  : </label>
                                    {{getDevice($asset->asset->device)}}
                                </div>
                                <div>
                                    <label>Device Sr : </label>
                                    {{ $asset->asset->device_sr }}
                                </div>
                                <label> Name : </label>
                                    {{$asset->asset->name}}
                                </div>
                                <div>
                                    <label>Processor : </label>
                                    {{ $asset->asset->processor }}
                                </div>
                                <div>
                                    <label>Ram : </label>
                                    {{ $asset->asset->ram }}
                                </div>
                           
                                <div>
                                    <label>Storage  : </label>
                                    {{ isset($asset->asset->ssd)? $asset->asset->ssd : '' }}
                                </div>
                                <div>
                                    <label>OS  : </label>
                                    {{ isset($asset->asset->os)? $asset->asset->os : '' }}
                                </div>
                                <div>
                                    <label>IMEI  : </label>
                                    {{ isset($asset->asset->imei)? $asset->asset->imei : '' }}
                                </div>
                                <div>
                                <div>
                                    <label>Accessories Taken : </label>
                                    <?php $local = $asset->accessory_name;
                                            // $array = json_encode($local,true);  
                                            foreach($local as $items)
                                            {
                                                echo $items." ";
                                                echo " ,";

                                            }
                                        ?>
                                </div>
                                    <label>Description : </label>
                                    {{ isset($asset->asset->description)? $asset->asset->description : '' }}
                                </div>
                                <div>
                                    <label>Date Of Assignment : </label>
                                    {{date('d-m-Y',strtotime($asset->date_of_assignment))}}

                                </div>
                                @endif
                               

                                @if($asset->asset->device == 7 )
                                <div>
                                    <label>Employee Name : </label>
                                    {{$asset->employee->name}}
                                </div>
                                <div>
                                    <label>Employee Email : </label>
                                    {{$asset->employee->email}}
                                </div>
                                <div>
                                    <label>Device Owner : </label>
                                    {{getOwner($asset->owner)}}
                                </div>
                                <div>
                                    <label>Date Of Assignment : </label>
                                    {{date('d-m-Y',strtotime($asset->date_of_assignment))}}
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