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
                <li class="breadcrumb-current-item"> Training Program </li>
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
                            <span class="panel-title hidden-xs"> Program details</span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                      
                            @foreach($data as $value)

                            <div>
                                <label>Training Name : </label>
                                    {{ $value->name }}
                            </div>
                            <div>
                                <label>Description : </label>
                                    {{ $value->description }}
                            </div>
                            <div>
                                <label>Lecture : </label>
                                    {{ $value->lecture }}
                            </div>
                
                            @if($value->days != NULL)
                                <?php 
                                $name = "";
                                $days =json_decode($value->days) ;
                                foreach($days as $day){
                                    $name .= " ".$day.",";
                                }
                                $result = rtrim ($name , ","); 
                                ?>
                                <div>
                                    <label>Days : </label>
                                        {{ $result }}
                                </div>
                            @endif
                           
                            <div>
                                <label>Timing : </label>
                                    {{ $value->time }}
                            </div>
                            <div>
                                <label>Date From : </label>
                                    {{ date('d-m-Y', strtotime($value->date_from)) }}
                            </div>
                            @if($value->date_to == '0000-00-00')
                            <div>          
                                <label>Date To : </label>
                                {{ date('d-m-Y', strtotime($value->date_from)) }}
                            </div>
                            @else
                            <div>           
                                <label>Date To : </label>
                                {{ date('d-m-Y', strtotime($value->date_to)) }}
                            </div>
                            @endif
                                                         
                            @endforeach
                        </div>
                    </div>
                </div>  
            </div>
        </div>
            </div>
    </section>

</div>
@endsection