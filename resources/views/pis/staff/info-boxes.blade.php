<!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <!-- <div class="info-box" style="cursor: pointer" onclick="window.location.replace('{{ url('dtr/request-leave') }}')"> -->
              <div class="info-box" style="cursor: pointer" onclick="showRequest('Apply for Leave')">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Apply for Leave</span>
                <span class="info-box-number">
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <!-- <div class="info-box mb-3 request-for" style="cursor: pointer" onclick="window.location.replace('{{ url('dtr/request-for-to') }}')"> -->
              <div class="info-box" style="cursor: pointer" onclick="showRequest('Request for T.O')">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shuttle-van"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Request for T.O.</span>
                <span class="info-box-number">
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <!-- <div class="info-box mb-3" style="cursor: pointer" onclick="window.location.replace('{{ url('dtr/request-for-ot') }}')"> -->
              <div class="info-box" style="cursor: pointer" onclick="showRequest('Request for O.T')">
              <span class="info-box-icon bg-success elevation-1"><i class="far fa-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Request for O.T.</span>
                <span class="info-box-number">
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3" style="display: none;">
            <div class="info-box mb-3 bg-warning" style="cursor: pointer" onclick="showRequest('Apply for Monetization')">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Apply for Monetization</span>
                <span class="info-box-number">
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          

        </div>
        <!-- /.row -->