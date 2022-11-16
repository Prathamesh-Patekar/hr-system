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
                    <a href=""> Holidays </a>
                </li>
                <li class="breadcrumb-current-item"> Holiday Listings </li>
            </ol>
        </div>
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="topbar-right">
            <h4> <input type="submit" href="/holiday-listing" value="Export" name="button" class="btn btn-success">
            </h4>
        </div>
        {!! Form::close() !!}
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
                                <span class="panel-title hidden-xs"> Holiday Lists </span>
                            </div>
                            <div class="panel-body pn">
                                @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                                @endif
                                <!-- {!! Form::open(['class' => 'form-horizontal']) !!}
                                <div class="panel-menu allcp-form theme-primary mtn">
                        <div class="row">
                            {!! Form::open() !!}
                            <div class="col-md-3">
                                <input type="text" class="field form-control" placeholder="query string" style="height:40px" value="{{$string}}" name="string">
                            </div>
                            <div class="col-md-3">
                                <label class="field select">
                                    {!! Form::select('column', getHolidayDropDown(),$column) !!}
                                    <i class="arrow double"></i>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" value="Search" name="button" class="btn btn-primary">
                            </div>

                       
                            {!! Form::close() !!}
                            <div class="col-md-2">
                                <a href="/employee-manager" >
                                    <input type="submit" value="Reset" class="btn btn-warning"></a>
                            </div>
                        </div>
                            </div> -->
                                <div class="table-responsive">
                                    @if(count($holidays))
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Occasion</th>
                                                <th class="text-center">Date </th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $i =0;?>
                                            @foreach($holidays as $holiday)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{$holiday->occasion}}</td>
                                                <td class="text-center">
                                                    {{date('d-m-Y',strtotime(($holiday->date_from)))}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group text-right">
                                                        <button type="button"
                                                            class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Action
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="/edit-holiday/{{$holiday->id}}">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href="/delete-holiday/{{$holiday->id}}">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                {!! $holidays->render() !!}
                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="text-center">
                                        <h2>No holidays added</h2>
                                    </div>
                                    @endif
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