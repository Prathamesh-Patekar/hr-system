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
                    <a href=""> Leaves </a>
                </li>
                <li class="breadcrumb-current-item"> Add Leaves </li>
            </ol>
        </div>
        <div class="topbar-right">
            <h5>April - March</h5>
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
                            <span class="panel-title hidden-xs"> Total Leave Lists </span><br />
                        </div><br />
                      
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
                                        <th class="text-center">sr. no</th>
                                        <th class="text-center">Employee</th>
                                        <th class="text-center">Balance leaves</th>
                                        <th class="text-center">Allow_leaves</th>
                                        <th class="text-center">Taken_leaves</th>
                                        <th class="text-center">Add leaves</th>
                                        <th class="text-center">Reset</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($data as $value)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center" id = "name">{{$value->name}}</td>
                                            @if($value->holiday_employee != null)
                                            <td class="text-center">{{$value->holiday_employee['allow_leaves'] - $value->holiday_employee['taken_leaves'] }}</td>
                                            <td class="text-center">{{$value->holiday_employee['allow_leaves']}}</td>
                                            <td class="text-center">{{$value->holiday_employee['taken_leaves']}}</td>
                                            @else
                                            <td class="text-center">--</td>
                                            <td class="text-center">--</td>
                                            <td class="text-center">--</td>
                                            @endif
                                            <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                            <td class="text-center">
                                                <input type = 'number' class = "number" style="width: 10%;" value = "">
                                                <input type="submit" class = 'addvalue  btn btn-xs btn-success' value = 'Add' name="button">
                                            </td>
                                            <td class="text-center">
                                                <input type="submit" class = 'reset btn btn-xs btn-warning' value = 'Reset'>
                                            </td>
                                        </tr>
                                    @endforeach  
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
    <!-- Notification modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="modal-header" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div id="remarkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>
                        <input type="hidden" id="leave_id">
                        <input type="hidden" id="type">

                    <div id="loader" class="hidden text-center">
                        <img src="/photos/76.gif" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- /Notification Modal -->
</div>
@endsection
@push('scripts')
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/function.js"></script>
@endpush