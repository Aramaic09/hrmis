<?php
    if(isset($data['nav']))
    {
      $dashboard = $data['nav']['dashboard'];
      $myprofile = $data['nav']['myprofile'];
      $hiring = $data['nav']['hiring'];
      $vacant = $data['nav']['vacant'];
      $submission = $data['nav']['submission'];
      $pislibrary = $data['nav']['pislibrary'];
      $calendar = $data['nav']['calendar'];
      $servicerecord = $data['nav']['servicerecord'];

      $numemp = $data['nav']['numemp'];
      $arvemp = $data['nav']['arvemp'];

      $retiree = $data['nav']['retiree'];
      $jos = $data['nav']['jos'];

      $recruit = $data['nav']['recruit'];
      $learn = $data['nav']['learn'];
      $performance = $data['nav']['performance'];

      $payroll_emp = $data['nav']['payroll_emp'];
      $payroll_process = $data['nav']['payroll_process'];
      $payroll_lib = $data['nav']['payroll_lib'];
      $payroll_report = $data['nav']['payroll_report'];
    }
    else
    {
      $dashboard = "";
      $myprofile = "";
      $hiring = "";
      $vacant = "";
      $submission = "";
      $pislibrary = "";
      $calendar = "";
      $servicerecord = "";

      $numemp = "";
      $arvemp = "";

      $retiree = "";
      $jos = "";

      $recruit = "";
      $learn = "";
      $performance = "";

      $payroll_emp = "";
      $payroll_process = "";
      $payroll_lib = "";
      $payroll_report = "";
    }
?>
<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="font-size: 15px">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ $dashboard }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">PERSONNEL INFO</li>

          <li class="nav-item">
            <a href="{{ url('recruitment/index') }}" class="nav-link {{ $recruit }}">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Recruitment <span class="badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('learning-development/index') }}" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Learning And Development 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('performance/index') }}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Performance Management
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('rewards/index') }}" class="nav-link">
              <i class="nav-icon fas fa-medal"></i>
              <p>
                Rewards and Recognitions
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('retiree/ALL') }}" class="nav-link">
              <i class="nav-icon fas fa-chart-line" style="top:0px"></i>
              <p>
                Succession Planning<br/>and Retirement 
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ url('list-of-employees') }}" class="nav-link {{ $numemp }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Number of Employees
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('archived-employees') }}" class="nav-link {{ $arvemp }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Archived of Employees
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('vacant-position') }}" class="nav-link {{ $vacant }}">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Plantilla Positions <span class="badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('contract-of-service') }}" class="nav-link {{ $jos }}">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Contract of Service/JO <span class="badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('pis-library/division') }}" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Maintenance
              </p>
            </a>
          </li>

          


          <li class="nav-header">ATTENDANCE MONITORING</li>

          <li class="nav-item">
            <a href="{{ url('dtr/report') }}" class="nav-link">
              <i class="nav-icon fas fa-chart-area"></i>
              <p>
                Reports
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('maintenance') }}" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Maintenance
              </p>
            </a>
          </li>


          <li class="nav-header">PAYROLL</li>

          <li class="nav-item">
            <a href="{{ url('payroll/emp') }}" class="nav-link {{ $payroll_emp }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employee Info
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('payroll/process') }}" class="nav-link {{ $payroll_process }}">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Processing
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('payroll/library') }}" class="nav-link {{ $payroll_lib }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Library
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('payroll/report') }}" class="nav-link {{ $payroll_report }}">
              <i class="nav-icon fas fa-chart-area"></i>
              <p>
                Reports
              </p>
            </a>
          </li>



          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->