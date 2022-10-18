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
                <li class="breadcrumb-current-item"> Exit Forms </li>
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
                            <span class="panel-title hidden-xs">Employee Lists</span><br />
                        </div><br />
                        @if(Session::has('failed'))
                            <div class="alert alert-danger">
                                {{ Session::get('failed') }}
                            </div>
                        @endif
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                    </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Date of Resignation</th>
                                        <th class="text-center">Notice Period</th>
                                        <th class="text-center">last of working</th>
                                        <th class="text-center">Form submited</th>
                                        <th class="text-center">View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    

                                    @foreach($emps as $emp)
                                    <tr>
                                        <td class="text-center">{{$i+=1}}</td>
                                        <td class="text-center">{{$emp->employee['name']}}</td>
                                        <td class="text-center">{{date('Y-m-d', strtotime($emp->date_of_resignation))}}</td>
                                        <td class="text-center">{{$emp->notice_period}} days</td>
                                        <td class="text-center">{{date('Y-m-d', strtotime($emp->last_working_day))}}</td>
                                        <td class="text-center"> <?php $data = $emp->employee_form ?>
                                            @if( $data != "" )
                                            Yes
                                            </td>
                                        <td class="text-center"><a href="/resignation_form/{{$emp->employee['id']}}">View</a></td>
                                            @else
                                            No
                                            </td>
                                        <td class="text-center">View</td>
                                            @endif
                                    </tr>
                                    @endforeach
                                    <tr><td colspan="10">
                                            {!! $emps->render() !!}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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