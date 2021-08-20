@extends('template.master')

@section('CSS')
<!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.2/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')

<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-12">
    <!-- STACKED BAR CHART -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><b>MAINTENANCE</b></h3>
                <div class="card-tools">
                    
                </div>
              </div>
              <div class="card-body">
                    <div class="row">
                      <div class="col-5 col-sm-3">
                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                          
                          <a class="nav-link active" id="maintenance-1-tab" data-toggle="pill" href="#maintenance-1" role="tab" aria-controls="maintenance-1" aria-selected="true">DTR Option</a>

                          <a class="nav-link" id="maintenance-2-tab" data-toggle="pill" href="#maintenance-2" role="tab" aria-controls="maintenance-2" aria-selected="false">Work Schedule</a>

                          <a class="nav-link" id="maintenance-3-tab" data-toggle="pill" href="#maintenance-3" role="tab" aria-controls="maintenance-3" aria-selected="false">Holidays</a>

                          <a class="nav-link" id="maintenance-4-tab" data-toggle="pill" href="#maintenance-4" role="tab" aria-controls="maintenance-4" aria-selected="false">Suspension of Work</a>

                          <a class="nav-link" id="maintenance-5-tab" data-toggle="pill" href="#maintenance-5" role="tab" aria-controls="maintenance-5" aria-selected="false">Leave Type</a>

                          <a class="nav-link" id="maintenance-6-tab" data-toggle="pill" href="#maintenance-6" role="tab" aria-controls="maintenance-6" aria-selected="false">Overtime Policy</a>

                          <a class="nav-link" id="maintenance-7-tab" data-toggle="pill" href="#maintenance-7" role="tab" aria-controls="maintenance-7" aria-selected="false">Leave Balances</a>

                          <a class="nav-link" id="maintenance-8-tab" data-toggle="pill" href="#maintenance-8" role="tab" aria-controls="maintenance-8" aria-selected="false">Special Service</a>

                          <a class="nav-link" id="maintenance-9-tab" data-toggle="pill" href="#maintenance-9" role="tab" aria-controls="maintenance-9" aria-selected="false">Updating DTR</a>

                          <a class="nav-link" id="maintenance-10-tab" data-toggle="pill" href="#maintenance-10" role="tab" aria-controls="maintenance-10" aria-selected="false">DTR Exemption</a>

                        </div>
                      </div>
                      <div class="col-7 col-sm-9">
                        <div class="tab-content" id="vert-tabs-tabContent">
                          <div class="tab-pane text-left fade show active" id="maintenance-1" role="tabpanel" aria-labelledby="maintenance-1">
                            <p align="right"><button class="btn btn-primary"> ADD </button></p>
                             <table class="table">
                               @foreach($data['dtr_option'] AS $key => $values)
                                <tr>
                                  <td>{{ ++$key }}</td>
                                  <td>{{ $values->fldDTROptDesc }}</td>
                                  <td style="width: 10%" align="center"><i class="fas fa-edit text-primary"></i>&nbsp<i class="fas fa-trash text-danger"></i></td>
                                </tr>
                               @endforeach
                             </table>
                          </div>
                          
                          <div class="tab-pane fade" id="maintenance-2" role="tabpanel" aria-labelledby="maintenance-2">

                            <form method="POST" id="frm_ws" enctype="multipart/form-data" role="form" action="{{ url('maintenance/work-schedule/update') }}">  
                            {{ csrf_field() }}
                            <input type="hidden" name="ws_id" value="{{ showActiveWS() }}">

                             <p>Pick Work Scheme</p>

                             <div class="form-group">
                                <div class="row">
                                  <div class="col-8 alert alert-warning">
                                    <label for="dtr_options">ACTIVE</label>
                                       <br>
                                       {{ showActiveWS('desc') }}
                                  </div>
                                </div>

                                 <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">DTR Options</label>
                                      <select class="form-control" name="dtroptions" id="dtroptions">
                                         @foreach($data['dtr_option'] AS $key => $values)
                                          <option value="{{ $values->id }}"> {{ $values->fldDTROptDesc }}</option>
                                         @endforeach
                                       </select>
                                       <br>
                                       <p align="right"><button class="btn btn-primary"> SET AS ACTIVE </button></p>
                                  </div>
                                </div>

                                

                              </div>
                            </form>


                              <!-- <div class="form-group">
                                <label for="dtr_options">Duration</label>
                                <div class="row">
                                  <div class="col-4">
                                    <input type="date" class="form-control" name="dur_from" id="dur_from" value="{{ date('Y-m-d') }}">
                                  </div>
                                  <div class="col-4">
                                    <input type="date" class="form-control" name="dur_to" id="dur_to" value="{{ date('Y-m-d') }}">
                                  </div>
                                </div>
                              </div> -->
                             
                          </div>

                          <div class="tab-pane fade" id="maintenance-3" role="tabpanel" aria-labelledby="maintenance-3">
                            <p align="right"><button class="btn btn-primary"> ADD </button></p>
                             <table class="table" id="tbl1" style="font-size: 12px">
                               <thead>
                                 <th style="width: 5%">#</th>
                                 <th>DESCRPTION</th>
                                 <th>DATE</th>
                                 <th></th>
                               </thead>
                               <tbody>
                               @foreach($data['holiday'] AS $keys => $values)
                                <tr>
                                    <td>{{ ++$keys }}</td>
                                    <td>{{ $values->holiday_desc }}</td>
                                    <td>{{ date('F, d Y',strtotime($values->holiday_date)) }}</td>
                                    <td style="width: 10%" align="center"><i class="fas fa-edit text-primary"></i>&nbsp<i class="fas fa-trash text-danger"></i></td>
                                </tr>
                               @endforeach
                               </tbody>
                             </table>
                          </div>

                          <div class="tab-pane fade" id="maintenance-4" role="tabpanel" aria-labelledby="maintenance-4">

                            <p align="right"><button class="btn btn-primary"> ADD </button></p>
                             <table class="table" id="tbl1" style="font-size: 12px">
                               <thead>
                                 <th style="width: 5%">#</th>
                                 <th>DATE</th>
                                 <th>TIME</th>
                                 <th>MIN HR</th>
                                 <th>REMARKS</th>
                                 <th></th>
                               </thead>
                               <tbody>
                               @foreach($data['suspension'] AS $keys => $values)
                                <tr>
                                    <td>{{ ++$keys }}</td>
                                    <td>{{ date('F, d Y',strtotime($values->fldSuspensionDate)) }}</td>
                                    <td>{{ $values->fldSuspensionTime }}</td>
                                    <td>{{ $values->fldMinHrs }}</td>
                                    <td>{{ $values->fldSuspensionRemarks }}</td>
                                    <td style="width: 10%" align="center"><i class="fas fa-edit text-primary"></i>&nbsp<i class="fas fa-trash text-danger"></i></td>
                                </tr>
                               @endforeach
                               </tbody>
                             </table>
                          </div>

                          <div class="tab-pane fade" id="maintenance-5" role="tabpanel" aria-labelledby="maintenance-5">
                            <table class="table" id="tbl4" style="font-size: 12px">
                               <thead>
                                 <th style="width: 5%">#</th>
                                 <th>ACRONYM</th>
                                 <th>LEAVE TYPE</th>
                                 <th></th>
                               </thead>
                               <tbody>
                               @foreach(getAllLeave() AS $keys => $values)
                                <tr>
                                    <td>{{ ++$keys }}</td>
                                    <td>{{ $values->leave_acro }}</td>
                                    <td>{{ $values->leave_desc }}</td>
                                    <td style="width: 10%" align="center"><i class="fas fa-edit text-primary"></i>&nbsp<i class="fas fa-trash text-danger"></i></td>
                                </tr>
                               @endforeach

                               </tbody>
                             </table>
                          </div>

                          <div class="tab-pane fade" id="maintenance-6" role="tabpanel" aria-labelledby="maintenance-6">

                          </div>

                          <div class="tab-pane fade" id="maintenance-7" role="tabpanel" aria-labelledby="maintenance-7">
                            <p>Update Leave Balances</p>
                             <div class="form-group">

                                <form method="POST" id="frm_ws" enctype="multipart/form-data" role="form" action="{{ url('dtr/add-leave') }}">  
                                {{ csrf_field() }}

                                 <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">Employee</label>
                                      <select class="form-control" name="emp_list_1" id="emp_list_1">
                                          @foreach(getAllUser() AS $users)
                                            <option value="{{ $users->id }}">{{ $users->lname.", ".$users->fname." ".$users->mname }}</option>
                                          @endforeach
                                       </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">Leave Type</label>
                                      <select class="form-control" name="leave_list_1" id="leave_list_1">
                                         @foreach(getAllLeave() AS $keys => $values)
                                            <option value="{{ $values->id }}">{{ $values->leave_desc }}</option>
                                           @endforeach
                                       </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">Balance</label>
                                      <input type="text" class="form-control" name="leave_bal" style="width: 50%">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">Negative</label>
                                      <input type="text" class="form-control" name="leave_bal_neg" style="width: 50%">
                                  </div>
                                </div>

                                <br>
                                <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">&nbsp</label>
                                      <button type='submit' class="btn btn-primary"> Update </button>
                                  </div>
                                </div>

                              </div>
                            </form>
                          </div>

                          <div class="tab-pane fade" id="maintenance-8" role="tabpanel" aria-labelledby="maintenance-8">
                             
                          </div>

                          <div class="tab-pane fade" id="maintenance-9" role="tabpanel" aria-labelledby="maintenance-9">
                             <p>
                                Updating of DTR<br>
                                Limit on updating of DTR: 15 days after month ends.</p>
                             <div class="form-group">

                              <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">No. of Days After End of Month:</label>
                                      <input type="text" class="form-control" name="limit_edit" style="width: 50%">
                                  </div>
                                </div>
                                <br>  
                                <div class="row">
                                  <div class="col-8">
                                    <label for="dtr_options">&nbsp</label>
                                      <button class="btn btn-primary"> Set Limit </button>
                                  </div>
                                </div>

                              </div>

                          </div>

                          <div class="tab-pane fade" id="maintenance-10" role="tabpanel" aria-labelledby="maintenance-10">
                            <p align="right"><button class="btn btn-primary"> ADD </button></p>
                             <table class="table" id="tbl4">
                               <thead>
                                 <th style="width: 5%">#</th>
                                 <th>EMPLOYEE</th>
                                 <th></th>
                               </thead>
                               <tbody>
                                  @foreach($data['exemption'] AS $keys => $exemptions)
                                    <tr>
                                      <td>{{ ++$keys }}</td>
                                      <td>{{ $exemptions->lname . ', ' .$exemptions->fname . ' ' . $exemptions->mname }}</td>
                                      <td style="width: 10%" align="center"><i class="fas fa-trash text-danger"></i></td>
                                    </tr> 
                                  @endforeach
                               </tbody>
                             </table>
                          </div>

                        </div>
                      </div>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  </div>
</div>

@endsection

@section('JS')

<!-- Sparkline -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.2/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.2/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('AdminLTE-3.0.2/plugins/chart.js/Chart.min.js') }}"></script>


<script type="text/javascript">
  $("#tbl1,#tbl2,#tbl3").DataTable();
</script>
@endsection