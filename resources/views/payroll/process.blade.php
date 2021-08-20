@extends('template.master')

@section('CSS')

@endsection

@section('content')
<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Preview/Process Payroll</h3>
              <div class="card-tools">

                  <button type="button" class="btn bg-primary" onclick="submitFrm()">
                    <?php
                      //GET NEXT MONTH
                      $payroll_mon = date('n') + 1;
                      $yr = date('Y');
                      
                      $payroll_year = $yr;

                      if($payroll_mon == 13)
                      {
                        $payroll_mon = 1;
                        $payroll_year = $yr++;
                      }

                      $curr_mon = date('F',mktime(0, 0, 0, $payroll_mon, 10));

                      $months = array(1 => "JAN", 2 =>"FEB", 3 => "MAR", 4 => "APR", 5 => "MAY", 6 => "JUN", 7 => "JUL", 8 => "AUG", 9 => "SEP", 10 => "OCT", 11 => "NOV", 12 => "DEC");

                      $next_mon = $months[$payroll_mon];

                    ?>
                    <i class="fas fa-cog"></i> Proccess {{ $curr_mon }}
                  </button>
                  

                  <button type="button" class="btn bg-info">
                    <i class="fas fa-eye"></i> Preview
                  </button>

                  <!-- <form id="frm" method="POST"> -->
                  <form id="frm2" method="POST" action="{{ url('payroll/create') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('payroll/create') }}">
                    <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('payroll/process') }}">
                    <input type="hidden" name="path" value="{{ $payroll_year.'-'.date('m',strtotime('first day of +1 month')).'_'.$next_mon }}">
                    <input type="hidden" name="payrollmon" value="{{ $next_mon }}">
                  </form>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <table width="100%" class="table" style="border:1px solid #DDD;" cellpadding="5">
                  <thead>
                    <th>YEAR</th>
                    <th>MONTH</th>
                    <th>WEEK1</th>
                    <th>WEEK2</th>
                    <th>WEEK3</th>
                    <th>WEEK4</th>
                  </thead>
                  <tbody>
                    @foreach(getPayrollList() AS $dirs)
                        <?php
                            $details = explode("_", $dirs);

                            $dt = explode("-", $details[0]);
                            $mon = date('F',mktime(0, 0, 0, $dt[1], 10));

                            $dts = date('Y-m',strtotime($dt[0].'-'.$dt[1]));

                            //FILES
                            $files = getPayrollFileList($dirs);
                        ?>
                        <tr>
                            <td>{{ $dt[0] }}</td>
                            <td><span style="opacity: 0">{{ $dt[1] }}</span>{{ strtoupper($mon) }}</td>

                            
                            @foreach(getPayrollFileList($dirs) AS $index => $files)
                                  @if($dts <= '2017-04')
                                    @if($index != 0)
                                        <td><a href="{{ asset('../storage/app/payroll/'.$dirs.'/'.$files ) }}" target="_blank">{{ $files }}</a></td>
                                    @endif
                                  @else
                                    <td><a href="{{ asset('../storage/app/payroll/'.$dirs.'/'.$files ) }}" target="_blank">{{ $files }}</a></td>
                                  @endif
                            @endforeach
                        </tr>
                    @endforeach
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
    $('.table').DataTable({
        "order": [[ 0, "desc" ],[ 1, "desc" ]]
    } );


    function submitFrm()
    {
      $("#frm2").submit();
    }
</script>
@endsection