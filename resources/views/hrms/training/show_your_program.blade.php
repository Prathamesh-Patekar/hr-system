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
                        <a href=""> Trainings </a>
                    </li>
                    <li class="breadcrumb-current-item"> Training Program Listings </li>
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
                                <span class="panel-title hidden-xs"> Training Program Lists </span>
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
                                            <th class="text-center">Training Program</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Days</th>
                                            <th class="text-center">Date From</th>
                                            <th class="text-center">Date To</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i =0;?>
                                        @foreach($data as $value)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{$value->name}}</td>
                                                <td class="text-center">{{$value->description}}</td>
                                                <td class="text-center">
                                                @if($value->days != 'null')
                                                <?php 
                                                $name = "";
                                                $days =json_decode($value->days) ;
                                                foreach($days as $day){
                                                    $name .= " ".$day.",";
                                                }
                                                $data = rtrim ($name , ","); 
                                                ?>{{$data}}</td>
                                                @else
                                                --
                                                @endif
                                                <td class="text-center">{{date('d-m-Y',strtotime($value->date_from))}}</td>
                                                @if($value->date_to == '0000-00-00')
                                                <td class="text-center">{{date('d-m-Y',strtotime($value->date_from))}}</td>
                                                @else
                                                <td class="text-center">{{date('d-m-Y',strtotime($value->date_to))}}</td>
                                                @endif
                                                <td class="text-center">{{$value->time}}</td>
                                            </tr>
                                        @endforeach    
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