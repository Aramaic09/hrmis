@extends('template.master')

@section('CSS')

@endsection

@section('content')

<div class="row">
        <div class="col-10">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title"></h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table" id="tbl">
                <thead>
                  <th style="width: 2%">#</th>
                  <th>Fullname</th>
                  <th>Division</th>
                  <th>Age</th>
                  <th>COURSE</th>
                  <th style="width: 5%"></th>
                </thead>
                <tbody>
                  @foreach($data['retiree'] as $retirees)
                    <tr><td></td><td>{{ $retirees->lname.", ".$retirees->fname." ".$retirees->mname }}</td><td>{{ getDivision($retirees->division) }}</td><td>{{ $retirees->age }}</td>
                      <td>{{ getLastEduc($retirees->id) }}</td>
                      <td>

                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-list"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" onclick="showComputation()"><i class="fas fa-calculator"></i> Computation</a>
                        </div>

                      </td>
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
        <div class="col-2">
          <div class="card">
            <div class="card-body">
              <table class="table table-stripped">
                <thead>
                  <th>Division</th>
                  <th class="text-center">#</th>
                </thead>
                <tbody>
                  @foreach($data['division'] as $divisions)
                        <tr><td>{{ $divisions->division_acro }}</td><td class="text-center"><span class="badge badge-danger">{{ $divisions->total }}</span></td></tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-option">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i id="icon-title"></i> Computation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form method="POST" id="frm" enctype="multipart/form-data" role="form">  
              <!-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('plantilla/assign') }}">   -->
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12">
                  <center><strong>Terminal Leave Balances</strong></center>
                  <span>Available : </span><strong>-</strong><br>
                  <span>Initial Computation : </span><strong>-</strong>
                </div>
              </div>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
@endsection

@section('JS')
<script type="text/javascript">
    $(function () {
    var t = $("#tbl").DataTable();

    t.on('order.dt search.dt', function () {
      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      });
  }).draw();

  });

    function showComputation()
    {
      $("#modal-option").modal("toggle");
    }
</script>
@endsection