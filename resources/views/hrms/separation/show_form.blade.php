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
                            <span class="panel-title hidden-xs"> Resignation Form </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            <div>
                                @foreach($datas as $data)
                                <div>
                                    <label>Name : </label>
                                    {{ $data->employee['name'] }}
                                </div>
                           
                                <div>
                                    <label>Date of Resignation : </label>
                                    {{ $data->date_of_resignation }}
                                </div>

                                <div>
                                    <label>Notice Period : </label>
                                    {{ $data->notice_period }} days
                                </div>

                                <div>
                                    <label>Last Working Day : </label>
                                    {{ $data->last_working_day }}
                                </div>

                                <div>
                                    <label>Address : </label>
                                    {{ $data->employee['Address'] }}
                                </div>

                                
                                <div>
                                    <?php $question = $data->employee_form['question_answers'];
                                    $array = json_decode($question);    
                                    foreach($array as $item)
                                    {
                                        foreach($item as $key=>$value)
                                        {
                                            ?>
                                            <div>
                                            <label>Question  : </label>
                                            {{ $key }}
                                            </div>
                                            <div>
                                            <label>Answer : </label>
                                            {{ $value }}
                                            </div>
                                           <?php 

                                            
                                        }
                                    }

                                    
                                
                                    ?>

                                    
                                       
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