
@extends('hrms.layouts.base')

@section('content')
<body class="forms-wizard">
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

                <li class="breadcrumb-current-item"> Add Holiday</li>
            </ol>
        </div>
        <div class="topbar-right">
            <h4><a class="link-unstyled" href="/sample_sheet/Holiday_sample_sheet.xlsx" title="">
                    <i class="fa fa-cloud-download text-purple pr10"></i> Sample Sheet </a></h4>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Left -------------- -->
     
        <!-- -------------- /Column Left -------------- -->

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <div class="">

                <div class="tab-content mw900 center-block center-children">


                    <!-- -------------- Upload Form -------------- -->
                    <div class="allcp-form theme-primary tab-pane active mw320" id="login" role="tabpanel">
                        <div class="box box-success">
                        <div class="panel fluid-width">

                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="panel-body pn mv12">
                                <!-- -------------- /section -------------- -->

                                <div class="section">
                                    <label for="file1"><h6> Upload File </h6></label>
                                    <label class="field prepend-icon append-button file">
                                        <span class="button">Choose File</span>
                                        <input type="file" class="gui-file" name="upload_file" id="file1"
                                               onChange="document.getElementById('uploader1').value = this.value;">
                                        <input type="text" class="gui-input" id="uploader1"
                                               placeholder="Select File" required>
                                    </label>
                                </div>

                                <div class="section">
                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                </div>

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



                    <!-- -------------- Registration -------------- -->
                  
                    <!-- -------------- /Registration -------------- -->

                </div>

            </div>
        </div>
        <!-- -------------- /Column Center -------------- -->

    </section>
    <!-- -------------- /Content -------------- -->
</div>
@endsection

<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}
<script>
    $(document).ready(function() {
        $("#datepicker1").datepicker({
            changeMonth:true,
            changeYear:true,
               
        });
    });
</script>
