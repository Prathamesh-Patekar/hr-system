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
                    <a href=""> Separation </a>
                </li>
                <li class="breadcrumb-current-item"> Resignation Form </li>
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
                            <span class="panel-title hidden-xs"> Tasks view </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            <div>
                                @foreach($data as $value)
                                <div>
                                    <label>Name : </label>
                                    {{ $value->employee['name'] }}
                                </div>
                                <div>
                                    <label>Task : </label>
                                    {{ $value->in_task }}
                                </div>
                                <div>
                                    <label>Department : </label>
                                    {{ $value->employee['department'] }}
                                </div>
                                <div>
                                    <label>Location : </label>

                                    <?php $local = $value->location;
                                    $array = json_decode($local);    
                                    foreach($array as $items)
                                    {
                                        echo $items." ";
                                    }
                                    ?>

                                </div>
                                <div>
                                    <label>In Date : </label>
                                    {{date('d-m-Y', strtotime($value->in_date))}}
                                </div>
                                <div>
                                    <label>In Time : </label>
                                    {{ $value->in_time }}
                                </div>
                                <div>
                                    <label>Out Date : </label>
                                    {{date('d-m-Y', strtotime($value->out_date))}}
                                </div>
                                <div>
                                    <label>Out Time : </label>
                                    {{ $value->out_time }}
                                </div>
                                <div>
                                    <label>Worked time : </label>
                                    {{ $diff->h }} hours {{ $diff->i }} minutes {{$diff->s}} seconds
                                </div>
                           
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