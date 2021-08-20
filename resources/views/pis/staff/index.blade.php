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
        @include('pis/staff/info-boxes')

<div class="row">
  <div class="col-md-6">
    <!-- STACKED BAR CHART -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><b>DTR</b></h3>
                <form method="POST" id="frm_dtr" enctype="multipart/form-data" action="{{ url('dtr/pdf') }}" target="_blank">  
                  {{ csrf_field() }}

              <div class="float-right">
                <h3 class="card-title float-right"><a class="btn btn-primary btn-sm" href="#" target="_blank" onclick="showDTR()"><i class="fas fa-print"></i></a></h3>
              </div>
              <div class="float-right" style="margin-right: 1%">

                <select class="form-control-sm" name="yr2" id="dtr-year">
                  <?php
                    for ($i = date('Y'); $i >= (date('Y') - 5) ; $i--) { 
                        echo "<option value='$i'>".$i."</option>";
                    }
                  ?>
                </select>

              </div>
                <div class="float-right" style="margin-right: 1%">
                <select class="form-control-sm" name="mon2" id="dtr_mon">
                  <option selected value='01'>January</option>
                  <option value='02'>February</option>
                  <option value='03'>March</option>
                  <option value='04'>April</option>
                  <option value='05'>May</option>
                  <option value='06'>June</option>
                  <option value='07'>July</option>
                  <option value='08'>August</option>
                  <option value='09'>September</option>
                  <option value='10'>October</option>
                  <option value='11'>November</option>
                  <option value='12'>December</option>
                </select>
              </div>
              @if(Auth::user()->usertype == 'Marshal' || Auth::user()->usertype == 'Director')
              <div class="float-right" style="margin-right: 1%">

                <select class="form-control-sm" name="userid" id="userid">
                  @foreach(getStaffDivision() AS $divs)
                    <option value="{{ $divs->id }}">{{ $divs->lname.', '.$divs->fname.' '.$divs->mname }}</option>
                  @endforeach
                </select>

              </div>
              @else
                  <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}">
              @endif
                <h3 class="card-title float-right" style="padding-right: 10px">
                    
                  </form>
                  
                </h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body">
                <h5><b><center>{{ date('F Y') }}</b></center></h5>
                <table class="table table-bordered" style="font-size: 12px">
                  <thead style="text-align: center">
                    <th style="text-align: left">Day</th><th>AM In</th><th>AM Out</th><th>PM In</th><th>PM Out</th>
                  </thead>
                  <tbody>
                    <?php
                      // function getEmpDTR($dt,$dtrs)
                      // {
                      //     $dtr = collect($dtrs);
                      //     $filtered = $dtr->where('fldEmpDTRdate', $dt);
                      //     return $filtered->first();
                      // }




                      $total = Carbon\Carbon::now()->daysInMonth;
                      $prevweek = 1;

                      $week_num = 2;

                      $mon = date('m');
                      $yr = date('Y');

                      echo "<tr><td colspan='5' align='center'>  <b>WEEK 1 </b> </td></tr>";
                      for($i = 1;$i <= $total;$i++)
                      {
                        $weeknum = weekOfMonth(date('Y-m-'.$i)) + 1;
                        if($weeknum == $prevweek)
                        {
                          
                        }
                        else
                        {
                          $prevweek = $weeknum;
                          echo "<tr><td colspan='5' align='center'> <b>WEEK $week_num </b> </td></tr>";
                          $week_num++;
                        }

                       $dtr_date = $yr.'-'.$mon.'-'.$i;

                       $dayDesc = weekDesc(date($yr.'-'.$mon.'-'.$i));

                       // echo "<tr><td><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center'>".getDTR($dtr_date,'am-in',$dayDesc,Auth::user()->id)."</td><td align='center'>".getDTR($dtr_date,'am-out',$dayDesc,Auth::user()->id)."</td><td align='center'>".getDTR($dtr_date,'pm-in',$dayDesc,Auth::user()->id)."</td><td align='center'>".getDTR($dtr_date,'pm-out',$dayDesc,Auth::user()->id)."</td></tr>";

                       $dtr_date2 = date("Y-m-d",strtotime($dtr_date));
                       // $dtrss = getEmpDTR($dtr_date2,$data['dtr']);

                      $dtrss = getDTRemp($dtr_date2,Auth::user()->id,1);

                       $amIn = "";
                       $amOut = "";
                       $pmIn = "";
                       $pmOut = "";

                       $req = "";

                       if($dayDesc == 'Sat' || $dayDesc == 'Sun')
                       {  
                          if(isset($dtrss))
                              {
                                $amIn = $dtrss['fldEmpDTRamIn'];
                                $amOut = $dtrss['fldEmpDTRamOut'];
                                $pmIn = $dtrss['fldEmpDTRpmIn'];
                                $pmOut = $dtrss['fldEmpDTRpmOut'];
                                $req = $dtrss['request'];
                              }
                       }
                       else
                       {

                          if($dtr_date2 <= date('Y-m-d'))
                           {
                              if(isset($dtrss))
                              {
                                $amIn = getWarning($dtrss['request'],$dtrss['fldEmpDTRamIn'],$dtrss['dtr_option_id']);
                                $amOut = getWarning($dtrss['request'],$dtrss['fldEmpDTRamOut'],$dtrss['dtr_option_id']);
                                $pmIn = getWarning($dtrss['request'],$dtrss['fldEmpDTRpmIn'],$dtrss['dtr_option_id']);
                                $pmOut = getWarning($dtrss['request'],$dtrss['fldEmpDTRpmOut'],$dtrss['dtr_option_id']);
                                $req = $dtrss['request'];
                              }
                              else
                              {
                                $amIn = getWarning(null,null);
                                $amOut = getWarning(null,null);
                                $pmIn = getWarning(null,null);
                                $pmOut = getWarning(null,null);
                              }
                              
                           }
                       }
                       
                       
                       echo "<tr><td><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center'>$amIn</td><td align='center'>$amOut</td><td align='center'>$pmIn</td><td align='center'>$pmOut</td></tr>";
                        
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  </div>
  <div class="col-md-6">
    <div class="card card-default">
              <form method="POST" id="frm3" enctype="multipart/form-data" action="{{ url('pdf/print-leave') }}" target="_blank">  
              {{ csrf_field() }}
              <div class="card-header">
                <h3 class="card-title"><b>LEAVE BALANCES</b></h3>
                <h3 class="card-title float-right"><button class="btn btn-primary btn-sm" ><i class="fas fa-print"></i></button></h3>
                <h3 class="card-title float-right" style="padding-right: 10px">
                <input type="hidden" id="payslip-year" name="payslip_year" value="{{ date('Y') }}">
                <input type="hidden" id="payslip-mon" name="payslip_mon" value="{{ date('m') }}">
                </form>
                </h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td style="width:30%"><b>LEAVE BALANCES</b></td>
                    <td style="width:9%" align="center"><b></b></td>
                    <td style="width:30%" align="center"><b>PENDING</b></td>
                    <td style="width:30%" align="center"><b>PROJECTED BALANCE</b></td>
                  </tr>
                  <tbody>
                    @foreach(showLeaves() AS $leaves)
                      <?php
                        $bal = getLeaves(Auth::user()->id,$leaves->id);
                        

                        if($leaves->id == 1 || $leaves->id == 2)
                        {
                          $bal = $bal + 1.25;
                        }

                        $pending = getPending($leaves->id);
                        $projected = $bal - $pending;
                      ?>
                      <tr>
                        <td>{{ $leaves->leave_desc }}</td>
                        <td align="center">{{ $bal }}</td>
                        <td align="center">{{ $pending }}</td>
                        <td align="center">{{ $projected }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer" style="display: none;">
                <h5><small>LEAVE RECORD</small></h5>
                <br>
                <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('pdf/print-leave-record') }}" target="_blank">

                  <div class="float-left">
                    <small><b>DURATION</b></small>
                  </div>

                  <div class="float-right" style="margin-left: 2%">
                    <button class="btn btn-primary btn-sm" ><i class="fas fa-print"></i></button>
                  </div>

                  <div class="float-right">
                      <select class="form-control-sm" id="payslip-year" name="payslip_year">
                      <?php
                        $total = date('Y') - 5;
                        for ($i = date('Y'); $i >= $total ; $i--) { 
                          # code...
                          echo "<option value='$i'>$i</option>";
                        }
                        
                      ?>
                    </select>
                  </div>
                  

                  <div class="float-right" style="margin-right: 1%">
                      <select class="form-control-sm" id="payslip-mon" name="payslip_mon">
                    <?php
                      $month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                      foreach ($month as $months) {
                        # code...
                        $style = "";
                        if($months == date('F'))
                        {
                          $style = "font-weight:bold";
                        }
                        echo "<option value='$months' style='$style'>$months</option>";
                      }
                    ?>
                  </select>
                  </div>

                  <div class="float-right">
                      <select class="form-control-sm" id="payslip-year" name="payslip_year">
                      <?php
                        $total = date('Y') - 5;
                        for ($i = date('Y'); $i >= $total ; $i--) { 
                          # code...
                          echo "<option value='$i'>$i</option>";
                        }
                        
                      ?>
                    </select>
                    &nbsp&nbsp-&nbsp&nbsp
                  </div>
                  <div class="float-right" style="margin-right: 1%">
                      <select class="form-control-sm" id="payslip-mon" name="payslip_mon">
                    <?php
                      $month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                      foreach ($month as $months) {
                        # code...
                        $style = "";
                        if($months == date('F'))
                        {
                          $style = "font-weight:bold";
                        }
                        echo "<option value='$months' style='$style'>$months</option>";
                      }
                    ?>
                  </select>
                  </div>
                </form>
              </div>
    </div>

    <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><b>PENDING FOR APPROVAL</b></h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td style="width:30%"><b>REQUEST TYPE</b></td>
                    <td style="width:30%" align="center"><b>DATE</b></td>
                    <td style="width:30%" align="center"><b>STATUS</b></td>
                  </tr>
                  <tbody>
                    @foreach(checkRequest() AS $values)
                      <tr>
                        <td>{{ $values['request_desc'] }}</td>
                        <td align="center">{{ $values['request_date'] }}</td>
                        <td align="center"><?php echo formatRequestStatus($values['request_action_status']) ?></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

    <!-- STACKED BAR CHART -->
            <div class="card card-default">
              <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('pdf/my-payslip') }}" target="_blank">  
              {{ csrf_field() }}
              <div class="card-header">
                <h3 class="card-title"><b>PAYSLIP</b></h3>
                <h3 class="card-title float-right"><button class="btn btn-primary btn-sm" ><i class="fas fa-print"></i></button></h3>
                <input type="hidden" id="payslip-year" name="payslip_year" value="{{ date('Y') }}">
                <input type="hidden" id="payslip-mon" name="payslip_mon" value="{{ date('m') }}">
                </form>
                </h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td style="width:33%"><b>GROSS PAY</b></td>
                    <td style="width:33%"><b>DEDUCTIONS</b></td>
                    <td style="width:33%"><b>OTHER DEDUCTIONS</b></td>
                    <td></td>
                  </tr>
                  <tbody>
                    <tr>
                      <?php
                        $plantilla = getPlantillaInfo(Auth::user()->username);

                        $deductions = getDeductions(Auth::user()->username);

                        $compensation = getCompensation(Auth::user()->username);

                        //RATA
                        $rata = 0;
                        foreach(getCompensation_rata(Auth::user()->username,true) AS $values)
                        {
                          $rata += $values->compAmount;
                        }

                        //TOTAL COMPESATION
                        $total_comp = 0;
                        foreach ($compensation as $key => $value) {
                          $total_comp += $value->compAmount;
                        }


                        $total_deduc = 0;
                        foreach ($deductions as $key => $value) {
                          $total_deduc += $value->deductAmount;
                        }

                        $loans = getPersonalLoans(Auth::user()->username);
                        foreach ($loans as $key => $value) {
                                $total_deduc += $value->DED_AMOUNT;
                            }
                      ?>
                      <td valign="top">
                        SALARY - {{ formatCash($plantilla['plantilla_salary']) }}<br>
                        @foreach($compensation AS $lists)
                          <?php echo $lists->compCode.' - '.formatCash($lists->compAmount).'<br/>' ?>
                        @endforeach
                      </td>
                      <td valign="top">
                        @foreach($deductions AS $lists)
                          <?php echo $lists->deductName.' - '.formatCash($lists->deductAmount).'<br/>' ?>
                        @endforeach
                      </td>
                      <td valign="top">
                        @foreach($loans AS $lists)
                          <?php echo $lists->ORG_ACRO.' - '.formatCash($lists->DED_AMOUNT).'<br/>' ?>
                        @endforeach
                      </td>
                    </tr>
                    <tr>
                      <td><b>TOTAL</b> - {{ formatCash($plantilla['plantilla_salary'] + $total_comp) }}</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>NET SALARY</b> - {{ formatCash(($plantilla['plantilla_salary'] + $total_comp) - $total_deduc) }}</td>
                      <td><b>PER WEEK</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <div class="row">
                          <?php
                            for ($i=1; $i <= 4 ; $i++) {
                                $salary = getSalaryWeek(Auth::user()->username,$plantilla['plantilla_salary'],$i);
                                echo "<div class='col-3'>".$salary."</div>";
                              }
                          ?>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

  </div>
</div>

<!-- RESET PASSWORD MODAL-->
      <div class="modal fade" id="modal-request-for">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i id="icon-title"></i> <span id="modal-request-for-title"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="POST" id="frm_request" enctype="multipart/form-data">
              {{ csrf_field() }}
              
              @if(Auth::user()->usertype == 'Marshal')
              <div class="form-group">
                <strong>Employee</strong>
              
                <p class="text-muted">
                      <select class="form-control" name="userid2" id="userid2">
                        @foreach(getStaffDivision() AS $divs)
                          <option value="{{ $divs->id }}">{{ $divs->lname.', '.$divs->fname.' '.$divs->mname }}</option>
                        @endforeach
                      </select>
                </p>
              </div>
              @else
                <input type="hidden" name="userid2"  id="userid2" value="{{ Auth::user()->id }}">
              @endif

              <!-- LEAVE TYPE -->
              <div class="div-request" id="div-request-leave">
                <div id="option-leave">
                  <strong>Leave Type</strong>
                    <br>
                    <p class="text-muted">
                      <select class="form-control" name='leave_id' id='leave_id'>
                        
                        <?php
                            $lv = App\Leave_type::whereNotIn('id',[4,13,14,15])->get();
                            foreach ($lv as $key => $lvs) {
                                echo '<option value="'.$lvs->id.'">'.$lvs->leave_desc.'</option>';
                            }
                        ?>
                      </select>
                    </p>
                    <!-- <small class="badge badge-warning">Pls note that .....</small> -->
                  </div>

                  <strong>Duration</strong>
                    <div class="form-group">

                      <div class="input-group" id="option-leave-duration">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="leave_duration" name="leave_duration">
                      </div>

                      <div class="input-group" id="option-leave-duration2">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="leave_duration2" name="leave_duration2">
                      </div>

                      <div class="input-group" id="option-leave-duration3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="leave_duration3" name="leave_duration3">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <p class="text-muted">
                      <div class="form-group clearfix">
                      <div id="leave_times" style="display: block">

                      <div class="icheck-primary d-inline" style="margin-right: 10px">
                        <input type="radio" id="leave_time_wholeday" name="leave_time" value="wholeday" checked>
                        <label for="leave_time_wholeday">
                          Whole day
                        </label>
                      </div>

                      <div class="icheck-primary d-inline" style="margin-right: 10px">
                        <input type="radio" id="leave_time_am" name="leave_time" value="AM">
                        <label for="leave_time_am">
                          AM
                        </label>
                      </div>
                      <div class="icheck-primary d-inline" style="margin-right: 10px">
                        <input type="radio" id="leave_time_pm" name="leave_time" value="PM">
                        <label for="leave_time_pm">
                          PM
                        </label>
                      </div>
                    </div>
                    </div>
                    </p>

                    <div id="option-vl-select">
                      <br>
                      <strong>In case of Vacation/Special Priviledge Leave</strong>
                      <br>
                      <p class="text-muted">
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="vl_select1" name="vl_select" value="Within the Philippines" checked>
                          <label for="vl_select1">
                            Within the Philippines
                          </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="vl_select2" name="vl_select" value="Abroad">
                          <label for="vl_select2">
                            Abroad
                          </label>
                        </div>
                      </p>
                      <input type="text" class="form-control" name="vl_select_specify" id="vl_select_specify"  placeholder="Specify" style="display:none">
                    </div>

                    <div id="option-sl-select">
                      <br>
                      <strong>In case of Sick Leave</strong>
                      <br>
                      <p class="text-muted">
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="sl_select1" name="sl_select" value="Hospital" checked>
                          <label for="sl_select1">
                            Hospital
                          </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="sl_select2" name="sl_select" value="Out Patient">
                          <label for="sl_select2">
                            Out Patient
                          </label>
                        </div>
                      </p>
                      <input type="text" class="form-control" name="sl_select_specify" id="sl_select_specify"  placeholder="Specify Illness">
                    </div>

                    <div id="option-to">
                      <strong>Vehicle</strong>
                      <br>
                      <p class="text-muted">
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="vehicle_official1" name="vehicle" value="Official" checked>
                          <label for="vehicle_official1">
                            Official
                          </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="vehicle_personal2" name="vehicle" value="Personal">
                          <label for="vehicle_personal2">
                            Personal
                          </label>
                        </div>

                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="vehicle_personal3" name="vehicle" value="Public Utility Vehicle">
                          <label for="vehicle_personal3">
                            Public Utility Vehicle
                          </label>
                        </div>
                      </p>

                      <strong>Per Diem</strong>
                      <br>
                      <p class="text-muted">
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="perdiem_yes" name="perdiem" value="YES" checked>
                          <label for="perdiem_yes">
                            Will Claim
                          </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="perdiem_no" name="perdiem" value="NO">
                          <label for="perdiem_no">
                            Will Not Claim
                          </label>
                        </div>
                      </p>

                      <strong>Place</strong>
                      <br>
                        <p class="text-muted">
                          <input type="text" class="form-control" name="place" id="place">
                        </p>

                      <strong>Purpose</strong>
                      <br>
                        <p class="text-muted">
                          <input type="text" class="form-control" name="purpose" id="purpose">
                        </p>

                    </div>

                    <div id="option-cto">
                      <strong>CTO</strong>
                      <br>
                      <p class="text-muted">
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="cto_yes" name="cto" value="YES">
                          <label for="cto_yes">
                            YES
                          </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-right: 10px">
                          <input type="radio" id="cto_no" name="cto" value="NO" checked>
                          <label for="cto_no">
                            NO
                          </label>
                        </div>
                      </p>
                      <strong>No. of Hours</strong>
                        <br>
                        <p class="text-muted">
                          <input type="number" class="form-control" name="cto_hours" id="cto_hours">
                        </p>
                    </div>

                    <div id="option-remarks">
                      <strong>Remarks</strong>
                      <br>
                      <p class="text-muted">
                        <input type="text" class="form-control" name="remarks" id="remarks">
                      </p>
                    </div>


                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="modalOnSubmit()">Submit</button>
            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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


<script>
  $(document).ready(function(){
    $("#payslip-mon").val("{{ date('F') }}");
    $("#dtr_mon").val("{{ date('m') }}");
    $("#dtr_year,#payslip-year").val({{ date('Y') }});

    $("#userid,#userid2").val({{ Auth::user()->id }});

   var now = new Date();
      now.setDate(now.getDate()+2);
      $('#leave_duration').daterangepicker({
          minDate:now,
          isInvalidDate: function(date) {
            if (date.day() == 0 || date.day() == 6)
              return true;
            return false;
          }   
      });
    

    var now2 = new Date();
    $('#leave_duration2').daterangepicker({
      maxDate: now2,
      isInvalidDate: function(date) {
          if (date.day() == 0 || date.day() == 6)
            return true;
          return false;
        }
    });

    $('#leave_duration3').daterangepicker();

    checkPendingRequest();

  });

  
  $('input:radio[name="vl_select"]').change(
    function(){
      $("#vl_select_specify").hide();
      if(this.value == 'Abroad')
            $("#vl_select_specify").show();
    });

  function modalOnSubmit()
  {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.value) {
        $("#overlay").show();
        $("#frm_request").submit();
      }
    })
  }

  //SUBMIT REQUEST

  //GET DATE
//   $('#leave_duration').on('apply.daterangepicker', function(ev, picker) {
//     var start = new Date(picker.startDate.format('YYYY-MM-DD')),
//     end   = new Date(picker.endDate.format('YYYY-MM-DD')),
//     diff  = new Date(end - start),
//     days  = diff/1000/60/60/24;
//     console.log(days);
//     if(days > 0)
//     {
//       console.log("pass");
//       $("#leave_times").hide();
//     }
//     else
//     {
//       $("#leave_times").show();
//     }
// });

  
  function showRequest(title)
  {
    $("#modal-request-for-title").text(title);
    $("#modal-request-for").modal("toggle");

    $("#option-leave,#option-remarks,#option-to,#option-cto").hide();

    $('#option-leave-duration,#option-leave-duration2,#option-leave-duration3,#option-vl-select,#option-sl-select').hide();

    switch(title)
    {
      case "Apply for Leave":
        $("#option-leave,#option-leave-duration,#option-vl-select").show();
        $("#frm_request").attr({"action" : "{{ url('dtr/send-leave-request') }}"});
      break;

      case "Request for T.O":
        $("#option-leave-duration3,#option-to").show();
        $("#frm_request").attr({"action" : "{{ url('dtr/send-to-request') }}"});
        // $("#frm_request").attr({"action" : "{{ url('test-leave') }}"});
      break;

      case "Request for O.T":
        $("#option-remarks,#option-leave-duration3,#option-cto").show();
        $("#frm_request").attr({"action" : "{{ url('dtr/send-ot-request') }}"});
      break;
    }
  }


  //CHECK TYPE OF LEAVE

  $("#leave_id").change(function(){

    $('#option-leave-duration,#option-leave-duration2,#option-leave-duration3,#option-vl-select,#option-sl-select').hide();


    if(this.value == 1)
    {
      $('#option-leave-duration,#option-vl-select').show();
    }
    else if(this.value == 2)
    {
      $('#option-leave-duration2,#option-sl-select').show();
    }
    else if(this.value == 16)
    {
      $('#option-leave-duration3').show();
    }
    else if(this.value == 3)
    {
      $('#option-leave-duration3,#option-vl-select').show();
    }
    else
    {
      $('#option-leave-duration').show();
    }

    switch(this.value)
    {
        case 1:
        break;
        case 2:
        break;
    }

  });

  function showDTR()
  {
    // var win = window.open('{{ url("dtr/print") }}', '_blank');
    $("#frm_dtr").submit();
  }

  function showPayslip()
  {
    var win = window.open('{{ url("pdf/my-payslip") }}/' + $("#dtr-mon").val() + '-' + $("#dtr-year").val(), '_blank');
  }

</script>
@endsection