<?php
    if(isset($data['nav']))
    {
      $dashboard = $data['nav']['dashboard'];
      $myprofile = $data['nav']['myprofile'];
      $hiring = $data['nav']['hiring'];
      $submission = $data['nav']['submission'];
      $attendance_menu = $data['nav']['attendance_menu'];
      $attendance = $data['nav']['attendance'];
      $attendance_approval = $data['nav']['attendance_approval'];
      $calendar = $data['nav']['calendar'];
      $icos = $data['nav']['icos'];
      $empdtr = $data['nav']['empdtr'];
      $dtr = $data['nav']['dtr'];
    }
    else
    {
      $dashboard = "";
      $myprofile = "";
      $hiring = "";
      $submission = "";
      $attendance_menu = "";
      $attendance = "";
      $attendance_approval = "";
      $calendar = "";
      $icos = "";
      $empdtr = "";
      $dtr = "";
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
          <li class="nav-header">MENU</li>
          <li class="nav-item">
            <a href="{{ url('personal-information/info') }}" class="nav-link {{ $myprofile }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Personal Information
              </p>
            </a>
          </li>

          
          @if(Auth::user()->division == 'O')
          <!-- BUDGET/ARMMS/OED -->
          <li class="nav-item">
            <a href="{{ url('learning-development/list-hrd-approval') }}" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                HRD Plan for Approval
              </p>
            </a>
          </li>
          @endif

          
          @if(Auth::user()->division == 'q' || Auth::user()->division == 'A' || Auth::user()->division == 'O')
          <!-- BUDGET/ARMMS/OED -->
          <li class="nav-item">
            <a href="{{ url('recruitment/letter-approval') }}" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Letter of Approval
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ url('letter-request') }}" class="nav-link {{ $hiring }}">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Documents
              </p>
            </a>
          </li>


          @if(countCallforSubmitDivision('total') > 0)
          <li class="nav-item">
            <a href="{{ url('submission-list/division') }}" class="nav-link {{ $submission }}">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Call for Submission <span class="badge badge-danger">{{ countCallforSubmitDivision('active') }}</span>
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item has-treeview {{ $attendance_menu }}">
            <a href="#" class="nav-link {{ $attendance }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Attendance Monitoring
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('request-for-approval') }}" class="nav-link {{ $attendance_approval }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request For Approval</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('dtr/employee') }}" class="nav-link {{ $empdtr }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proccess DTR</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('dtr/icos') }}" class="nav-link {{ $icos }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ICOS DTR</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ url('core-competency') }}" class="nav-link {{ $calendar }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Succession Planning and Retirement 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('dtr/report') }}" class="nav-link {{ $calendar }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Reports 
              </p>
            </a>
          </li>


          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->