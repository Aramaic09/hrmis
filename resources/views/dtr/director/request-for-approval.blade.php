@extends('template.master')

@section('CSS')

@endsection

@section('content')
<!-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('request/action') }}">  -->
<form method="POST" id="frm" enctype="multipart/form-data">

{{ csrf_field() }}
<input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('request/action') }}">
<input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('request-for-approval') }}">

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                     
              <h3 class="card-title">Requests for Approval</h3>
              @if(Auth::user()->usertype == 'Director')
              <input type="hidden" name="leave_action_status" id="leave_action_status" value="">
              <div class="float-right"><button class="btn btn-danger request_btn" id="request_btn_dissapprove" onclick="frmSubmit('Disapproved')" disabled><i class="fas fa-trash"></i></button></div> <div class="float-right" style="margin-right: 10px"><button class="btn btn-primary request_btn" id="request_btn_approve" onclick="frmSubmit('Approved')" disabled><i class="fas fa-check"></i></button></div>

              @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 2%">
                    <input type="checkbox" id="icheck_all" name="icheck_all" class="check" value="all">
                  </th>
                  <th style="width: 30%">Name</th>
                  <th>Type of Request</th>
                  <th>Date</th>
                  <th>Duration</th>
                  <th>Remarks</th>
                  @if(Auth::user()->usertype == 'Marshal')
                  <th>Status</th>
                  <th></th>
                  @endif
                </tr>
                </thead>
                <tbody>
                  <?php $i = 0; ?>
                  @foreach(getRequestForApproval() AS $lists)
                  @if($lists->leave_id != 6)
                    <tr>
                      <td>
                        <input type="checkbox" name="check_request[]" class="check" value="{{ $i }}">
                      </td>
                      <td><input type="hidden" name="userid[]" value="{{ $lists->user_id }}">{{ $lists->fullname }}</td>
                      <td><input type="hidden" name="requestid[]" value="{{ $lists->id }}">{{ $lists->leave_desc }}</td>
                      <td>
                        <input type="hidden" name="leavedates[]" value="{{ $lists->leave_date }}">
                        <input type="hidden" name="leaveid[]" value="{{ $lists->leave_id }}">
                        <input type="hidden" name="requestype[]" value="leave">
                        <?php
                          if($lists->leave_date_from == $lists->leave_date_to)
                          {
                            $dt = date("M d, Y",strtotime($lists->leave_date_from));
                          }
                          else
                          {
                            $dt = date("M d, Y",strtotime($lists->leave_date_from))." - ".date("M d, Y",strtotime($lists->leave_date_to));
                          }

                          echo $dt;
                        ?>
                      </td>
                      <td>{{ $lists->leave_deduction_time }}</td>
                      <td></td>
                      @if(Auth::user()->usertype == 'Marshal')
                      <td align="center"><?php echo formatRequestStatus($lists->leave_action_status) ?></td>
                      <td>
                            <a href="{{ url('request/print') }}" target="_blank"><i class="fas fa-print" ></i></a>
                      </td>
                      @endif
                    </tr>
                    <?php $i++; ?>
                    @endif
                  @endforeach

                   @foreach(getRequestForTOApproval() AS $lists)
                    <tr>
                      <td>
                        <input type="checkbox" name="check_request[]" class="check" value="{{ $i }}">
                      </td>
                      <td><input type="hidden" name="userid[]" value="{{ $lists->userid }}">{{ $lists->employee_name }}</td>
                      <td><input type="hidden" name="requestid[]" value="{{ $lists->id }}">Travel Order</td>
                      <td>
                        <input type="hidden" name="leavedates[]" value="{{ $lists->to_date }}">
                        <input type="hidden" name="requestype[]" value="TO">
                        <?php
                            echo date("M d, Y",strtotime($lists->to_date));
                        ?>
                      </td>
                      <td>{{ $lists->to_deduction_time }}</td>
                      <td>{{ $lists->to_remarks }}</td>
                      @if(Auth::user()->usertype == 'Marshal')
                      <td align="center"><?php echo formatRequestStatus($lists->to_status) ?></td>
                      <td>
                            <a href="{{ url('request/print') }}" target="_blank"><i class="fas fa-print" ></i></a>
                      </td>
                      @endif
                    </tr>
                    <?php $i++; ?>
                  @endforeach

                  @foreach(getRequestForOTApproval() AS $lists)
                    <tr>
                      <td>
                        <input type="checkbox" name="check_request[]" class="check" value="{{ $i }}">
                      </td>
                      <td><input type="hidden" name="userid[]" value="{{ $lists->userid }}">{{ $lists->employee_name }}</td>
                      <td><input type="hidden" name="requestid[]" value="{{ $lists->id }}">Overtime</td>
                      <td>
                        <input type="hidden" name="leavedates[]" value="{{ $lists->ot_date }}">
                        <input type="hidden" name="requestype[]" value="OT">
                        <?php
                            echo date("M d, Y",strtotime($lists->ot_date));
                        ?>
                      </td>
                      <td>{{ $lists->ot_deduction_time }}</td>
                      <td>{{ $lists->ot_remarks }}</td>
                      @if(Auth::user()->usertype == 'Marshal')
                      <td align="center"><?php echo formatRequestStatus($lists->ot_status) ?></td>
                      <td>
                            <a href="{{ url('request/print') }}" target="_blank"><i class="fas fa-print"></i></a>
                      </td>
                      @endif
                    </tr>
                    <?php $i++; ?>
                  @endforeach
                </form>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>



@endsection

@section('JS')


<script>
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_minimal',
    radioClass: 'iradio_minimal',
    increaseArea: '20%' // optional
  });
});
</script>

<script>
  $(function () {
    var t = $("#tbl").DataTable();

  //   t.on('order.dt search.dt', function () {
  //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
  //         cell.innerHTML = i+1;
  //     });
  // }).draw();

  });

  // Remove the checked state from "All" if any checkbox is unchecked
$('.check').on('ifUnchecked', function (event) {
    if(this.value == 'all')
    {
      $(".check").iCheck('uncheck');
      $(".request_btn").prop({"disabled":true});
    }
    else
    {
      $(".request_btn").prop({"disabled":true});
      $(this).iCheck('uncheck');
      $("#icheck_all").iCheck('uncheck');
    }
});

// Make "All" checked if all checkboxes are checked
$('.check').on('ifChecked', function (event) {
     $(".request_btn").prop({"disabled":false});
    if(this.value == 'all')
    {
      $(".check").iCheck('check');
    }
    else
    {
      $(this).iCheck('check');
    }
    // if ($('.check').filter(':checked').length == $('.check').length) {
    //     $('#icheck_all').iCheck('check');
    // }
});

function frmSubmit(status)
{
  $("#leave_action_status").val(status);
  $("#frm").submit();
}
</script>
@endsection