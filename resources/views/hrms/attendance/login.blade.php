@extends('hrms.layouts.base')

@section('content')


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
                        <a href=""> Attendance </a>
                    </li>
                    <li class="breadcrumb-current-item">Login/Logout</li>
                </ol>
            </div>
        </header>





    <!-- -------------- Content -------------- -->
   

    <section id="content" class="table-layout animated fadeIn">

     
        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <div class="">

                <div class="tab-content mw900 center-block center-children">


                    <!-- -------------- Upload Form -------------- -->
                    <div class="allcp-form theme-primary tab-pane active mw320" id="login" role="tabpanel">
                        <div class="box box-success">
                        <div class="panel fluid-width">

                            @if(Session::has('flash_message'))
                                <div class="alert alert-danger">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            @if(Session::has('flash_message1'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message1') }}
                                </div>
                            @endif

                                {!! Form::open(['class' => 'form-horizontal' ]) !!}
                                <div class="panel-body pn mv12">

                                
                                    @if($out != "out")
                                        <div class="section">
                                            <label for="task" class="field prepend-icon"> <h6 > Task </h6> </label>
                                            <textarea type="text" class="select2-single form-control"  rows="3" name="task" placeholder="Task" required></textarea>

                                        </div>
                                    
                                        <?php $late = '11:00:00';
                                        $last = '19:00:00';?>

                                        @if($time1 >= $late && $time1 <= $last)

                                            <div class="section">
                                                <label for="reason_box" class="field prepend-icon"> <h6 > Reason Box </h6> </label>
                                                <textarea type="text" class="select2-single form-control" rows="3" name="reason" placeholder="Reason" required></textarea>
                                            </div>
                                        @endif
                                

                                        <div class="section">
                                            <input type="submit" class="btn btn-bordered btn-info btn-block" value="Login">
                                        </div>

                                    @else
                                        <div class="section">
                                            <label for="task" class="field prepend-icon"> <h6 > Task </h6> </label>
                                            <textarea type="text"class="select2-single form-control"  rows="3" name="task1" placeholder="Task" required></textarea>
                                        </div>

                                        <div class="section">
                                            <input type="submit" class="btn btn-bordered btn-info btn-block" value="Logout">
                                        </div>
                                    @endif

                                    <!-- -------------- /section -------------- -->

                                </div>
                                {!! Form::close() !!}
                                <!-- -------------- /Form -------------- -->
                            </form>
                            </div>
                        </div>
                        <!-- -------------- /Panel -------------- -->
                    </div>
                    <!-- -------------- /Login Form -------------- -->



                 

                </div>

            </div>
        </div>
        <!-- -------------- /Column Center -------------- -->

    </section>

</div>
@endsection

