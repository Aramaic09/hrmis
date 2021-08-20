@extends('template.master')
@section('CSS')
  <link rel="stylesheet" href="{{ asset('multidate/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<?php
//TO SET AN ACTIVE TAB
$tab_info = "";
$tab_info_content = "";
$tab_addinfo = "";
$tab_addinfo_content = "";
$tab_address = "";
$tab_address_content = "";
$tab_family = "";
$tab_family_content = "";
$tab_org = "";
$tab_org_content = "";
$tab_eligibility = "";
$tab_eligibility_content = "";
$tab_work = "";
$tab_work_content = "";
$tab_education = "";
$tab_education_content = "";
$tab_training = "";
$tab_training_content = "";
$tab_competency = "";
$tab_competency_content = "";
$tab_other = "";
$tab_other_content = "";
$tab_files = "";
$tab_files_content = "";



switch ($data['active_tab']) {
  case 'addinfo':
    # code...
      $tab_addinfo = "active";
      $tab_addinfo_content = "show active";
    break;
  case 'address':
    # code...
      $tab_address = "active";
      $tab_address_content = "show active";
    break;
  case 'family':
    # code...
      $tab_family = "active";
      $tab_family_content = "show active";
    break;
  case 'organization':
    # code...
      $tab_org = "active";
      $tab_org_content = "show active";
    break;
  case 'eligibility':
    # code...
      $tab_eligibility = "active";
      $tab_eligibility_content = "show active";
    break;
  case 'training':
    # code...
      $tab_training = "active";
      $tab_training_content = "show active";
    break;
  case 'competency':
    # code...
      $tab_competency = "active";
      $tab_competency_content = "show active";
    break;
  case 'work':
    # code...
      $tab_work = "active";
      $tab_work_content = "show active";
    break;
    case 'education':
    # code...
      $tab_education = "active";
      $tab_education_content = "show active";
    break;
  case 'other':
    # code...
      $tab_other = "active";
      $tab_other_content = "show active";
    break;
  case 'files':
    # code...
      $tab_files = "active";
      $tab_files_content = "show active";
    break;
  default:
      $tab_info = "active";
      $tab_info_content = "show active";
  break;
}

?>

      <div class="modal fade" id="modal-photo">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i id="icon-title"></i> <span id="modal-title">UPLOAD PHOTO</span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" id="frm-photo" enctype="multipart/form-data" role="form" action="{{ url('basicinfo/update-photo') }}">  
            {{ csrf_field() }}
            <!-- <input type="hidden" name="tblid" id="tblid" value=""> -->
            <div class="modal-body">
              <input type="file" class="form-control" name="uploadphoto" id="uploadphoto">
            </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Photo</button>
            </form>
            </div>
        </div>
      </div>
    </div>
<div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">

              <a href="{{ url('pdf/pds') }}" class="float-right btn btn-info btn-sm" target="_blank"><i class="fas fa-print"></i> Print PDS</a>
              <br>
              <br>
                <div class="text-center">
                  <img class="profile-user-img img-fluid"
                       src="{{ asset('../storage/app/'.$data['empinfo']['image_path']) }}"
                       alt="User profile picture" style="width: 400px !important">
                </div>

                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                <p class="text-muted text-center"></p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> -->

                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-photo"><b>Upload Photo</b></button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <!-- <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div> 
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
            </div> -->


            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills" style="font-size: 14px">
                  <li class="nav-item"><a class="nav-link {{ $tab_info }}" href="#basicinfo" data-toggle="tab">Employee Information</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_addinfo }}" href="#addinfo" data-toggle="tab">Additional Info</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_address }}" href="#address" data-toggle="tab">Address</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_family }}" href="#family" data-toggle="tab">Family</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_education }}" href="#education" data-toggle="tab">Educational Background</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_org }}" href="#organization" data-toggle="tab">Organization</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_eligibility }}" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_work }}" href="#workexp" data-toggle="tab">Work Experience</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_training }}" href="#trainings" data-toggle="tab">Learning and Development</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_competency }}" href="#competency" data-toggle="tab">Competency</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_other }}" href="#otherinfo" data-toggle="tab">Other Info</a></li>
                  <li class="nav-item"><a class="nav-link {{ $tab_files }}" href="#files" data-toggle="tab">Files</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="{{ $tab_info_content }} tab-pane" id="basicinfo">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('basicinfo',{{ $data['empinfo']['id'] }})"><i class="fas fa-edit"></i> <b>EDIT</b></p>
                    <div class="row">
                      <div class="col-md-3">
                          <strong>Fullname</strong>
                          <p class="text-muted">

                            {{ $data['empinfo']['lname'].', '.$data['empinfo']['fname'].' '.$data['empinfo']['mname'].' '.$data['empinfo']['exname'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                          <strong>Birthdate</strong>
                          <p class="text-muted">
                            {{ date('M d, Y',strtotime($data['empinfo']['birthdate'])) }}
                          </p>
                      </div>
                      <div class="col-md-6">
                          <strong>Place of Birth</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_placeofbirth'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Sex</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_sex'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Civil Status</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_civilstatus'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Citizenship</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_citizenship'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Citizen Type</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_citizentype'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Height</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_height'] }} cm
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Weight</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_weight'] }} kg
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Blood Type</strong>
                          <p class="text-muted">
                            {{ $data['basicinfo']['basicinfo_bloodtype'] }}
                          </p>
                      </div>
                    </div>
                     <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Email Address</strong>
                          <p class="text-muted">
                            {{ Auth::user()->email }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Cellphone No.</strong>
                          <p class="text-muted">
                            {{ $data['contact']['contact_cellnum'] }}
                          </p>
                      </div>
                    </div>
                  </div>

                   

                  <div class="{{ $tab_addinfo_content }} tab-pane" id="addinfo">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('addinfo',{{ $data['empinfo']['id'] }})"><i class="fas fa-edit"></i> <b>EDIT</b></p>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Pag-ibig No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_pagibig'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>PhilHealth No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_philhealth'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>SSS No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_sss'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>TIN</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_tin'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>GSIS ID No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gsis_id'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>GSIS Policy No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gsis_policy'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>GSIS Business Partner No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gsis_bp'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Landbank Account Number</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_landbank'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Govt. Issued ID</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gov'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>ID No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gov_id'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Date/Place Issued</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_gov_place_   date'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>CTC No.</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_ctc'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Date Issued</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_ctc_date'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Place Issued</strong>
                          <p class="text-muted">
                            {{ $data['addinfo']['addinfo_ctc_place'] }}
                          </p>
                      </div>
                    </div>
                  </div>

                  <div class="{{ $tab_address_content }} tab-pane" id="address">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('address',{{ $data['empinfo']['id'] }})"><i class="fas fa-edit"></i> <b>EDIT</b></p>
                    <div class="row">
                      <div class="col-md-12">
                        <strong>Residential Address:</strong>
                          <p class="text-muted">
                             {{ $data['add_residential']['residential_add_street']." ".$data['add_residential']['residential_add_no']." ".$data['add_residential']['residential_add_subd']." ".$data['add_residential']['brgy_desc'].", ".$data['add_residential']['mun_desc'].", ".$data['add_residential']['prov_desc'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Zipcode</strong>
                          <p class="text-muted">
                            {{ $data['add_residential']['residential_add_zipcode'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Telephone No.</strong>
                          <p class="text-muted">
                            {{ $data['contact']['contact_residential'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <strong>Permanent Address:</strong>
                          <p class="text-muted">
                            {{ $data['add_permanent']['permanent_add_street']." ".$data['add_permanent']['permanent_add_no']." ".$data['add_permanent']['permanent_add_subd']." ".$data['add_permanent']['brgy_desc'].", ".$data['add_permanent']['mun_desc'].", ".$data['add_permanent']['prov_desc'] }}
                          </p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-3">
                        <strong>Zipcode</strong>
                          <p class="text-muted">
                            {{ $data['add_permanent']['permanent_add_zipcode'] }}
                          </p>
                      </div>
                      <div class="col-md-3">
                        <strong>Telephone No.</strong>
                          <p class="text-muted">
                            {{ $data['contact']['contact_permanent'] }}
                          </p>
                      </div>
                    </div>
                  </div>

                  <div class="{{ $tab_family_content }} tab-pane" id="family">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('family',{{ $data['empinfo']['id'] }})"><i class="fas fa-edit"></i> <b>EDIT</b></p>
                    <div class="row">
                      <div class="col-md-4">
                          <strong>Spouse's Information</strong>
                          <p class="text-muted">
                              <b>Name : </b> {{ $data['family']['fam_spouse_lname'].', '.$data['family']['fam_spouse_fname'].' '.$data['family']['fam_spouse_mname'].' '.$data['family']['fam_spouse_exname'] }}<br/>
                              <b>Occupation : </b>{{ $data['family']['fam_spouse_occ'] }}<br/>
                              <b>Employer's Name : </b>{{ $data['family']['fam_spouse_emp'] }}<br/>
                              <b>Business Address : </b>{{ $data['family']['fam_spouse_emp_add'] }}<br/>
                              <b>Telephone No. : </b>{{ $data['family']['fam_spouse_tel'] }}<br/>
                          </p>
                      </div>

                      <div class="col-md-4">
                          <strong>Father's Name</strong>
                          <p class="text-muted">
                            {{ $data['family']['fam_father_lname'].', '.$data['family']['fam_father_fname'].' '.$data['family']['fam_father_mname'].' '.$data['family']['fam_father_exname'] }}
                          </p>
                      </div>

                      <div class="col-md-4">
                          <strong>Mother's Maiden Name</strong>
                          <p class="text-muted">
                            {{ $data['family']['fam_mother_lname'].', '.$data['family']['fam_mother_fname'].' '.$data['family']['fam_mother_mname'] }}
                          </p>
                      </div>
    
                    </div>
                  </div>

                  <div class="{{ $tab_education_content }} tab-pane" id="education">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-education',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD</b></p>
                    <div class="row">
                        <div class="col-md-12">
                          <strong>Educational Background</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Level</th>
                                <th>Name of School</th>
                                <th>Degree Course</th>
                                <th>Dates</th>
                                <th style="width: 10% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['education'] as $educations)
                                  @if($educations->approved == null)
                                  <tr style="color: #AAA;">
                                    <td>{{ $ctr }}</td>
                                    <td><i class="badge badge-warning">pending for approval</i><br>{{ $educations->educ_level_desc }}</td>
                                    <td><br>{{ $educations->educ_school }}</td>
                                    <td><br>{{ $educations->educ_course }}</td>
                                    <td><br>{{ $educations->educ_date_from.'-'.$educations->educ_date_to }}</td>
                                    <td><br><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-education',{{ $educations->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-education',{{ $educations->id }})"></i></td>
                                  </tr>
                                  @else
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $educations->educ_level_desc }}</td>
                                    <td>{{ $educations->educ_school }}</td>
                                    <td>{{ $educations->educ_course }}</td>
                                    <td>{{ $educations->educ_date_from.'-'.$educations->educ_date_to }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-education',{{ $educations->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-education',{{ $educations->id }})"></i></td>
                                  </tr>
                                  @endif
                              <?php $ctr++ ?>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

                  <div class="{{ $tab_org_content }} tab-pane" id="organization">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-organization',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD</b></p>
                    <div class="row">
                        <div class="col-md-12">
                          <strong>Civic/Non-Government/People/Voluntary Organizations</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Inclusive Dates</th>
                                <th>Number of Hours</th>
                                <th>Position</th>
                                <th>Nature of Work</th>
                                <th style="width: 10% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['organization'] as $organizations)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $organizations->org_name }}</td>
                                    <td>{{ $organizations->org_add }}</td>
                                    <td>{{ formatDate($organizations->org_date_from)." to ".formatDate($organizations->org_date_to) }}</td>
                                    <td>{{ $organizations->org_hours }}</td>
                                    <td>{{ $organizations->org_position }}</td>
                                    <td>{{ $organizations->org_nature }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-organization',{{ $organizations->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-organization',{{ $organizations->id }})"></i></td>
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

                  <div class="{{ $tab_eligibility_content }} tab-pane" id="eligibility">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-eligibility',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD</b></p>
                    <div class="row">
                      <div class="col-md-12">
                          <strong>Career Service Eligibility</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Career Service/RA 1080</th>
                                <th>Rating</th>
                                <th>Date of Exam</th>
                                <th>Place of Examination</th>
                                <th>License Number</th>
                                <th>Date of Validity</th>
                                <th></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['eligibility'] as $eligibilities)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $eligibilities->cse_title }}</td>
                                    <td>{{ $eligibilities->cse_rating }}</td>
                                    <td>{{ $eligibilities->cse_date}}</td>
                                    <td>{{ $eligibilities->cse_place }}</td>
                                    <td>{{ $eligibilities->cse_license_num }}</td>
                                    <td>{{ $eligibilities->cse_license_date }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-eligibility',{{ $eligibilities->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-eligibility',{{ $eligibilities->id }})"></i></td>
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div> 
                  </div>

                  <div class="{{ $tab_work_content }} tab-pane" id="workexp">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-work',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD</b></p>

                    <div class="row">
                      <div class="col-md-12">
                          <table class="table" style="font-size: 12px">
                            <thead>
                                <th>#</th>
                                <th>Inclusive Dates</th>
                                <th>Company</th>
                                <th>Position Title</th>
                                <th>Monthly Salary</th>
                                <th>Salary Grade & Step Increment</th>
                                <th>Appointment Status</th>
                                <th>Gov't. Service</th>
                                <th style="width: 7% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['work'] as $works)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>
                                      <?php
                                        if($works->workexp_date_to == NULL)
                                        {
                                          $date_to = 'Present';
                                        }
                                        else
                                        {
                                          $date_to = date('M d, Y',strtotime($works->workexp_date_to));
                                        }
                                      ?>
                                    {{ date('M d, Y',strtotime($works->workexp_date_from)).' - '. $date_to }}
                                    </td>
                                    <td>{{ $works->workexp_company }}</td>
                                    <td>{{ $works->workexp_title }}</td>
                                    <td>P {{ formatNumber('currency',$works->workexp_salary) }}</td>
                                    <td>{{ $works->workexp_salary_grade }}</td>
                                    <td>{{ $works->workexp_empstatus }}</td>
                                    <td>{{ $works->workexp_gov }}</td>
                                    <td>
                                      @if($works->workexp_gov == 'NO')
                                      <i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-work',{{ $works->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-work',{{ $works->id }})"></i></td>
                                      @endif
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div> 
                  </div>

                  <div class="{{ $tab_training_content }} tab-pane" id="trainings">
                    <p class="float-left"><h4>Total Hours : <b><u>{{ formatNumber('number',$data['total_training_hours'][0]) }}</u></b> &nbsp&nbsp&nbsp&nbsp Total Investment : <b><u>{{ formatNumber('currency',$data['total_training_amount'][0]) }}</u></b></h4></p>
                    <p align="right" onclick="modalOption('add-training')" style="cursor: pointer;color: #0074c2"><i class="fas fa-plus"></i> <b>ADD</b></p>
                    <table class="table tbl" style="font-size: 14px">
                      <thead>
                        <th>#</th>
                        <th style="width: 100px !important">Title of Seminar</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>No. of Hours</th>
                        <th>Date</th>
                        <th>Certificate</th>
                        <th>Training Report</th>
                        <th></th>
                      </thead>
                      <tbody>
                        <?php $ctr = 1 ?>
                        @foreach($data['training'] as $trainings)
                            <?php
                                if($trainings->training_approved_by != null)
                                {
                                    $tr = "";
                                    $panel = '';
                                }
                                else
                                {
                                    $tr = "style='color:#AAA'";
                                    $panel = '<span class="badge badge-secondary">Pending for Approval</span><br>';
                                }
                            ?>
                            <tr <?php echo $tr; ?>><td>{{ $ctr }}</td><td><?php echo $panel; ?>{{ $trainings->training_title }}</td><td>{{ $trainings->training_type }}</td><td>{{ formatNumber('currency',$trainings->training_amount) }}</td><td>{{ $trainings->training_hours }}</td><td>
                              <?php
                                $arr = explode(',',$trainings->training_inclusive_dates);
                                foreach ($arr as $value) {
                                  # code...
                                      echo date('Y-m-d',strtotime($value))."<br/>";
                                }
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                if(isset($trainings->training_certificate))
                                {
                                  echo "<a href='".asset('../storage/app/'.$trainings->training_certificate)."' target='_blank'><i  class='fas fa-paperclip'></i></a>";
                                }
                               ?>    
                            </td>

                            <td align="center">
                              <?php
                                if(isset($trainings->training_report))
                                {
                                  echo "<a href='".asset('../storage/app/'.$trainings->training_report)."' target='_blank'><i  class='fas fa-paperclip'></i></a>";
                                }
                               ?>    
                            </td>

                               <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-training',{{ $trainings->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-training',{{ $trainings->id }})"></i></td></tr>
                            <?php $ctr++ ?>
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                  <div class="{{ $tab_competency_content }} tab-pane" id="competency">
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-competency-duty',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD DUTY</b></p>
                    <div class="row">
                        <div class="col-md-12">
                          <strong>Duties and Responsibilities</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Task</th>
                                <th>% of Work</th>
                                <th style="width: 10% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['competency_duty'] as $duties)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $duties->task }}</td>
                                    <td>{{ $duties->task_percent }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-competency-duty',{{ $duties->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-competency-duty',{{ $duties->id }})"></i></td>
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-competency',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD COMPETENCY</b></p>
                    <div class="row">
                        <div class="col-md-12">
                          <strong>Competencies</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Description</th>
                                <th style="width: 30% !important">Degree of Importance to Job</th>
                                <th style="width: 30% !important">Curret Skill Level</th>
                                <th style="width: 10% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['competency'] as $competencies)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $competencies->competency_desc }}</td>
                                    <td>{{ $competencies->competency_job }}</td>
                                    <td>{{ $competencies->competency_skill }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-competency',{{ $competencies->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-competency',{{ $competencies->id }})"></i></td>
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-competency-training',{{ $data['empinfo']['id'] }})"><i class="fas fa-plus"></i> <b>ADD TRAININGS NEEDED</b></p>
                    <div class="row">
                        <div class="col-md-12">
                          <strong>Training Programs Needed</strong>
                          <br>
                          <br>
                          <table class="table" style="font-size: 14px">
                            <thead>
                                <th>#</th>
                                <th>Description</th>
                                <th style="width: 10% !important"></th>
                            </thead>
                            <tbody>
                              <?php $ctr = 1 ?>
                              @foreach($data['competency_training'] as $trainings)
                                  <tr>
                                    <td>{{ $ctr }}</td>
                                    <td>{{ $trainings->training_desc }}</td>
                                    <td><i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-competency-training',{{ $trainings->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-competency-training',{{ $trainings->id }})"></i></td>
                                  </tr>
                              <?php $ctr++ ?>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

                  <div class="{{ $tab_other_content }} tab-pane" id="otherinfo">
                    <div class="row">
                      <div class="col-md-12">
                          <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="font-size: 13px">
                            <li class="nav-item">
                              <a class="nav-link active" id="tab-skills-id" data-toggle="pill" href="#tab-skills" role="tab" aria-controls="tab-skills" aria-selected="true">Special Skills/Hobbies</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="tab-recognition-id" data-toggle="pill" href="#tab-recognition" role="tab" aria-controls="tab-recognition" aria-selected="false">Non-Academic Distinctions/Recognition</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="tab-association-id" data-toggle="pill" href="#tab-association" role="tab" aria-controls="tab-association" aria-selected="false">Membership in Association/Organization</a>
                            </li>
                            <!-- <li class="nav-item">
                              <a class="nav-link" id="tab-cases-id" data-toggle="pill" href="#tab-cases" role="tab" aria-controls="tab-cases" aria-selected="false">Administrative Cases</a>
                            </li> -->
                            <li class="nav-item">
                              <a class="nav-link" id="tab-references-id" data-toggle="pill" href="#tab-references" role="tab" aria-controls="tab-references" aria-selected="false">References</a>
                            </li>
                          </ul>

                            <div class="tab-content" id="custom-content-below-tabContent">
                              <div class="tab-pane fade show active" id="tab-skills" role="tabpanel" aria-labelledby="tab-skills">
                                <br>
                                <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-skill')"><i class="fas fa-plus"></i> <b>ADD</b></p>
                                 <table class="table tbl">
                                   <thead>
                                     <th style="width: 50px !important">#</th>
                                     <th>Description</th>
                                     <th style="width: 50px"></th>
                                   </thead>
                                   <tbody>
                                     <?php $ctr = 1 ?>
                                      @foreach($data['skill'] as $skills)
                                          <tr>
                                            <td>{{ $ctr }}</td>
                                            <td>{{ $skills->skill_desc }}</td>
                                            <td>
                                              <i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-skill',{{ $skills->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-skill',{{ $skills->id }})"></i></td>
                                          </tr>
                                      <?php $ctr++ ?>
                                      @endforeach
                                   </tbody>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="tab-recognition" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <br>
                                <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-recognition')"><i class="fas fa-plus"></i> <b>ADD</b></p>
                                 <table class="table tbl">
                                   <thead>
                                     <th style="width: 50px !important">#</th>
                                     <th>Description</th>
                                     <th style="width: 50px"></th>
                                   </thead>
                                   <tbody>
                                     <?php $ctr = 1 ?>
                                      @foreach($data['recognition'] as $recognitions)
                                          <tr>
                                            <td>{{ $ctr }}</td>
                                            <td>{{ $recognitions->recog_desc }}</td>
                                            <td>
                                              <i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-recognition',{{ $recognitions->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-recognition',{{ $recognitions->id }})"></i></td>
                                          </tr>
                                      <?php $ctr++ ?>
                                      @endforeach
                                   </tbody>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="tab-association" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <br>
                                <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-association')"><i class="fas fa-plus"></i> <b>ADD</b></p>
                                 <table class="table tbl">
                                   <thead>
                                     <th style="width: 50px !important">#</th>
                                     <th>Description</th>
                                     <th style="width: 50px"></th>
                                   </thead>
                                   <tbody>
                                     <?php $ctr = 1 ?>
                                      @foreach($data['association'] as $associations)
                                          <tr>
                                            <td>{{ $ctr }}</td>
                                            <td>{{ $associations->assoc_desc }}</td>
                                            <td>
                                              <i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-association',{{ $associations->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-association',{{ $associations->id }})"></i></td>
                                          </tr>
                                      <?php $ctr++ ?>
                                      @endforeach
                                   </tbody>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="tab-cases" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                <br>
                                 <table class="table tbl">
                                   <thead>
                                     <th style="width: 50px !important">#</th>
                                     <th>Description</th>
                                     <th style="width: 10%"></th>
                                   </thead>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="tab-references" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                <br>
                                <p align="right" style="cursor: pointer;color: #0074c2" onclick="modalOption('add-reference')"><i class="fas fa-plus"></i><b>ADD</b></p> 
                                 <table class="table tbl">
                                   <thead>
                                     <th style="width: 50px !important">#</th>
                                     <th>Name</th>
                                     <th>Address</th>
                                     <th>Tel No.</th>
                                     <th style="width: 10%"></th>
                                  </thead>
                                     <?php $ctr = 1 ?>
                                      @foreach($data['reference'] as $references)
                                          <tr>
                                            <td>{{ $ctr }}</td>
                                            <td>{{ $references->reference_name }}</td>
                                            <td>{{ $references->reference_add }}</td>
                                            <td>{{ $references->reference_telno }}</td>
                                            <td>
                                              <i class="fas fa-edit" style="cursor: pointer;color: #17a2b8" onclick="modalOption('edit-reference',{{ $references->id }})"></i> <i class="fas fa-trash" style="cursor: pointer;color: red" onclick="modalOption('delete-reference',{{ $references->id }})"></i></td>
                                          </tr>
                                      <?php $ctr++ ?>
                                      @endforeach
                                   
                                 </table>
                              </div>
                            </div>
                      </div> 
                    </div>
                  </div>

                  <div class="{{ $tab_files_content }} tab-pane" id="files">
                    <div class="row">

                <div class="col-12">
                 <div class="card card-primary card-outline card-outline-tabs">

                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs-ipcr" role="tab" aria-controls="tabs-ipcr" aria-selected="true">IPCR</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="tabs-saln-tab" data-toggle="pill" href="#tabs-saln" role="tab" aria-controls="tabs-saln-tab" aria-selected="false">SALN</a>
                      </li>

                      <!-- <li class="nav-item">
                        <a class="nav-link" id="tabs-hrd-tab" data-toggle="pill" href="#tabs-hrd" role="tab" aria-controls="tabs-hrd-tab" aria-selected="false">HRD</a>
                      </li> -->

                      <li class="nav-item">
                        <a class="nav-link" id="tabs-others-tab" data-toggle="pill" href="#tabs-others" role="tab" aria-controls="tabs-others-tab" aria-selected="false">OTHERS</a>
                      </li>

                    </ul>
                  </div>

              <div class="card-body">

                <div class="tab-content" id="custom-tabs-three-tabContent">

                  <div class="tab-pane fade show active" id="tabs-ipcr" role="tabpanel" aria-labelledby="tabs-hrdplan-tab">
                    <button class="btn btn-primary float-right" onclick="modalOption('add-files-ipcr')"><i class="fas fa-plus"></i></button>
                    <br>
                    <br>
                    <table id="tbl" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 2%">#</th>
                        <th>Year</th>
                        <th>Period</th>
                        <th>Ave Rating</th>
                        <th>Date Submitted</th>
                        <th>File</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $ctr = 1 ?>
                        @foreach($data['ipcr'] AS $ipcrs)
                                <tr>
                                  <td>{{ $ctr }}</td>
                                  <td>{{ $ipcrs->dpcr_year }}</td>
                                  <td>{{ $ipcrs->dpcr_period }}</td>
                                  <td>{{ $ipcrs->ipcr_score }}</td>
                                  <td>{{ $ipcrs->ipcr_submitted_at }}</td>
                                  <td><center><a href="{{ asset('../storage/app/'.$ipcrs->ipcr_file_path) }}"><i class="fas fa-download"></i></a></center></td>
                                </tr>
                              <?php $ctr++ ?>
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                  <div class="tab-pane fade" id="tabs-saln" role="tabpanel" aria-labelledby="tabs-saln-tab">
                    <button class="btn btn-primary float-right" onclick="modalOption('add-files-saln')"><i class="fas fa-plus"></i></button>
                    <br>
                    <br>
                     <table id="tbl-degree" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 2%">#</th>
                        <th>Year</th>
                        <th>Date Submitted</th>
                        <th>File</th>
                        <th style="width: 5%"></th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  </div>

                  <div class="tab-pane fade" id="tabs-hrd" role="tabpanel" aria-labelledby="tabs-hrd-tab">
                     
                     <table id="tbl-non-degree" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 2%">#</th>
                        <th>Year</th>
                        <th>Date Submitted</th>
                        <th>File</th>
                        <th style="width: 5%"></th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  </div>

                  <div class="tab-pane fade" id="tabs-others" role="tabpanel" aria-labelledby="tabs-others-tab">
                     <button class="btn btn-primary float-right" onclick="modalOption('add-files-others')"><i class="fas fa-plus"></i></button>
                    <br>
                    <br>
                     <table id="tbl-non-degree" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 2%">#</th>
                        <th>Description</th>
                        <th style="width: 5%"></th>
                      </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>

                  </div>

                </div>
              </div>
              <!-- /.card -->
            </div>
  </div>
</div>
                  </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
</div>


      <div class="modal fade" id="modal-option">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i id="icon-title"></i> <span id="modal-title"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" id="frm" enctype="multipart/form-data" role="form">  
            <!-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('performance/ipcr-staff/create') }}">   -->
            {{ csrf_field() }}
            <input type="hidden" name="frm_url_action" id="frm_url_action" value="">
            <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="">
            <!-- <input type="hidden" name="trainingid" id="trainingid" value="">
            <input type="hidden" name="organizationid" id="organizationid" value="">
            <input type="hidden" name="eligibilityid" id="eligibilityid" value=""> -->
            <input type="hidden" name="tblid" id="tblid" value="">
            <div class="modal-body">

              <!-- ADD NEW TRANING -->
              <div class="div-content" id="div-add-new-training">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Title of Seminar/Training</strong>
                        <br>
                        <p class="text-muted">
                          <input type="text" class="form-control training" name="training_title" id="training_title" placeholder="" autocomplete="off">
                        </p>
                    <strong>Conducted By</strong>
                        <br>
                        <p class="text-muted">
                          <input type="text" class="form-control training" name="training_conducted_by" id="training_conducted_by" placeholder="" autocomplete="off">
                        </p>
                    <strong>Inclusive Dates</strong>
                        <br>
                        <p class="text-muted">
                          <input type="text" class="form-control date training" name="training_inclusive_date" id="training_inclusive_date" autocomplete="off"/>
                        </p>
                    <strong>Type</strong>
                        <br>
                        <p class="text-muted">
                          <select class="form-control training" name="training_type" id="training_type">
                            <option value="Free">Free</option>
                            <option value="Funded">PCAARRD Funded</option>
                            <option value="Personal">Personal</option>
                          </select>
                        </p>

                    <div id="div-amount" style="display: none">
                      <strong>Amount</strong>
                        <br>
                        <p class="text-muted">
                          <input type="number" name="training_amount" id="training_amount" class="form-control training">
                        </p>
                  </div>
                </div>
                  <div class="col-md-6">
                    <strong>Training Hours</strong>
                        <br>
                        <p class="text-muted">
                          <input type="number" class="form-control training" name="training_hours" id="training_hours" autocomplete="off"/>
                        </p>
                    <strong>LD</strong>
                        <br>
                        <p class="text-muted">
                          <select class="form-control select2 training" name="training_ld[]" id="training_ld" multiple>
                            <option value="Managerial">Managerial</option>
                            <option value="Supervisory">Supervisory</option>
                            <option value="Technical">Technical</option>
                          </select>
                        </p>

                    <!-- <div id="div-others" style="display: none">
                      <strong>Others</strong>
                        <br>
                        <p class="text-muted">
                          <input type="text" name="training_ld_others" id="training_ld_others" class="form-control">
                        </p>
                    </div> -->

                   
                    <strong>Areas of Discipline</strong>
                        <br>
                        <p class="text-muted">
                          <select class="form-control training" name="areasdiscip" id="areasdiscip">                            
                            <option value=""></option>
                            <option value="Management/ Supervisory/ Leadership">Management/ Supervisory/ Leadership</option>
                            <option value="R&d Related Trainings">R&d Related Trainings</option>
                            <option value="Skills Enhancement">Skills Enhancement</option>
                            <option value="Information & Communication Technology (ICT)">Information & Communication Technology (ICT)</option>
                            <option value="Information, Education & Communication (ICT)">Information, Education & Communication (IEC)</option>
                            <option value="Value Enhancement">Value Enhancement</option>
                            <option value="General Administration/ Governance">General Administration/ Governance</option>
                          </select>
                        </p>

                       <strong>Certificate</strong>
                        <br>
                        <p>
                          <input type="file" name="certificate" class="form-control training" accept="application/pdf">
                        </p>
                       <strong>Training Report</strong>
                        <br>
                        <p>
                          <input type="file" name="trainingreport" class="form-control training" accept="application/pdf">
                        </p>
                  </div>
                </div>
              </div>
              <!-- END ADD NEW TRANING -->

              <!-- BASIC INFO -->
              <div class="div-content" id="div-basic-info">
                <div class="row">
                  <div class="col-md-3">
                      <strong>Fullname</strong>
                      <input type="text" class="form-control basicinfo" name="lname" id="lname" placeholder="Last name">
                  </div>
                  <div class="col-md-4">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control basicinfo" name="fname" id="fname" placeholder="First name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control basicinfo" name="mname" id="mname" placeholder="Middle name">
                  </div>
                  <div class="col-md-2">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control basicinfo" name="exname" id="exname" placeholder="Extension">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Birthdate</strong>
                      <input type="date" class="form-control basicinfo" name="birthdate" id="birthdate">
                  </div>
                  <div class="col-md-4">
                      <strong>Place of Birth</strong>
                      <input type="text" class="form-control basicinfo" name="placeofbirth" id="placeofbirth" placeholder="Place of birth">
                  </div>
                  <div class="col-md-2">
                      <strong>Sex</strong>
                      <select class="form-control basicinfo" name="sex" id="sex">
                        <option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <strong>Civil Status</strong>
                      <select class="form-control select2 basicinfo" name="civilstatus" id="civilstatus">
                        <option value=""></option>
                        <option value="Annuled">Annuled</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Married">Married</option>
                        <option value="Single">Single</option>
                        <option value="Seperated">Separated</option>
                        <option value="Widowed">Widowed</option>
                      </select>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Citizenship</strong>
                      <select class="form-control select2 basicinfo" name="citizenship[]" id="citizenship" multiple="multiple">
                        <option value=""></option>
                        <option value="Filipino">Filipino</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <strong>Citizen Type</strong>
                      <select class="form-control basicinfo" name="citizentype" id="citizentype">
                        <option value=""></option>
                        <option value="By birth">By birth</option>
                        <option value="By naturalization">By naturalization</option>
                        <option value="Dual Citinzenship">Dual Citizenship</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <strong>Height(cm)</strong>
                      <input type="number" class="form-control basicinfo" name="info_height" id="info_height">
                  </div>
                  <div class="col-md-3">
                      <strong>Weight(kg)</strong>
                      <input type="number" class="form-control basicinfo" name="info_weight" id="info_weight">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Blood Type</strong>
                      <select class="form-control basicinfo" name="bloodtype" id="bloodtype">
                        <option value="A">A</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="AB">AB</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="B">B</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O">O</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                      </select>
                  </div>
                </div>

                <hr>
                <div class="row">
                  <div class="col-md-4">
                      <strong>Email</strong>
                      <input type="email" class="form-control address" name="email" id="email" value="{{ Auth::user()->email }}">
                  </div>
                  <div class="col-md-4">
                      <strong>Cell number</strong>
                      <input type="text" class="form-control address" name="contact_cellnum" id="contact_cellnum">
                  </div>
                </div>
              </div>
              <!-- END BASIC INFO -->

              <!-- ADD INFO -->
              <div class="div-content" id="div-add-info">
                <div class="row">
                  <div class="col-md-3">
                      <strong>Pagibig No.</strong>
                      <input type="text" class="form-control basicinfo" name="pagibig" id="pagibig" value="">
                  </div>
                  <div class="col-md-3">
                      <strong>PhilHealth No.</strong>
                      <input type="text" class="form-control basicinfo" name="philhealth" id="philhealth">
                  </div>
                  <div class="col-md-3">
                      <strong>SSS No.</strong>
                      <input type="text" class="form-control basicinfo" name="sss" id="sss">
                  </div>
                  <div class="col-md-3">
                      <strong>TIN</strong>
                      <input type="text" class="form-control basicinfo" name="tin" id="tin">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>GSIS ID No.</strong>
                      <input type="text" class="form-control basicinfo" name="gsis_id" id="gsis_id">
                  </div>
                  <div class="col-md-3">
                      <strong>GSIS Policy No.</strong>
                      <input type="text" class="form-control basicinfo" name="gsis_policy" id="gsis_policy">
                  </div>
                  <div class="col-md-3">
                      <strong style="font-size: 13px">GSIS Business Partner No.</strong>
                      <input type="text" class="form-control basicinfo" name="gsis_bp" id="gsis_bp">
                  </div>
                  <div class="col-md-3">
                      <strong style="font-size: 13px">Landbank Account Number</strong>
                      <input type="text" class="form-control basicinfo" name="landbank" id="landbank">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Govt. Issued ID</strong>
                      <!-- <input type="text" class="form-control basicinfo" name="gov" id="gov"> -->
                      <select class="form-control" name="gov" id="gov">
                        <option value="Passport">Passport</option>
                        <option value="Driver’s License">Driver’s License</option>
                        <option value="Voter’s ID">Voter’s ID</option>
                        <option value="Postal ID">Postal ID</option>
                        <option value="PRC ID">PRC ID</option>
                        <option value="Senior Citizen ID">Senior Citizen ID</option>
                        <option value="OFW ID">OFW ID</option>
                        <option value="UMID">UMID</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <strong>ID No.</strong>
                      <input type="text" class="form-control basicinfo" name="gov_id" id="gov_id">
                  </div>
                  <div class="col-md-3">
                      <strong>Date/Place Issued</strong>
                      <input type="text" class="form-control basicinfo" name="gov_place_date" id="gov_place_date">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>CTC No.</strong>
                      <input type="text" class="form-control basicinfo" name="ctc" id="ctc">
                  </div>
                  <div class="col-md-3">
                      <strong>Date Issued</strong>
                      <input type="text" class="form-control basicinfo" name="ctc_date" id="ctc_date">
                  </div>
                  <div class="col-md-3">
                      <strong>Place Issued</strong>
                      <input type="text" class="form-control basicinfo" name="ctc_place" id="ctc_place">
                  </div>
                </div>
              </div>
              <!-- END ADD INFO -->

               <!-- ADDRESS INFO -->
              <div class="div-content" id="div-address">
                <h5>Residential Address</h5>
                <div class="row">
                  <div class="col-md-4">
                      <strong>Street</strong>
                      <input type="text" class="form-control address" name="residential_add_street" id="residential_add_street" value="">
                  </div>
                  <div class="col-md-5">
                      <strong>Subdvision</strong>
                      <input type="text" class="form-control address" name="residential_add_subd" id="residential_add_subd">
                  </div>
                  <div class="col-md-3">
                      <strong>#</strong>
                      <input type="text" class="form-control address" name="residential_add_no" id="residential_add_no">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                      <strong>Province</strong>
                      <select class="form-control location_select_province" name="residential_add_prov" id="residential_add_prov" onchange="changeMun('residential_add_prov',this.value)"> 
                        @foreach(list_location('province') AS $value)
                          <option value="{{ $value->id }}">{{ $value->prov_desc }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="col-md-4">
                      <strong>Municipality</strong>
                      <select class="form-control location_select_municipal" name="residential_add_mun" id="residential_add_mun" onchange="changeBrgy('residential_add_mun',this.value)">
                        <!-- GET INITIAL VALUE PARA DI MADAMI -->
                        <option value="{{ $data['add_residential']['residential_add_mun'] }}">{{ $data['add_residential']['mun_desc'] }}</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                      <strong>Bgry</strong>
                      <select class="form-control" name="residential_add_brgy" id="residential_add_brgy">
                        <!-- GET INITIAL VALUE PARA DI MADAMI -->
                        <option value="{{ $data['add_residential']['residential_add_brgy'] }}">{{ $data['add_residential']['brgy_desc'] }}</option>
                      </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                      <strong>Zipcode</strong>
                      <input type="text" class="form-control address" name="residential_add_zipcode" id="residential_add_zipcode" value="">
                  </div>
                  <div class="col-md-4">
                      <strong>Telephone</strong>
                      <input type="text" class="form-control address" name="contact_residential" id="contact_residential">
                  </div>
                </div>
                <hr>
                <h5>Permanent Address</h5>
                <div class="row">
                  <div class="col-md-4">
                      <strong>Street</strong>
                      <input type="text" class="form-control address" name="permanent_add_street" id="permanent_add_street" value="">
                  </div>
                  <div class="col-md-5">
                      <strong>Subdvision</strong>
                      <input type="text" class="form-control address" name="permanent_add_subd" id="permanent_add_subd">
                  </div>
                  <div class="col-md-3">
                      <strong>#</strong>
                      <input type="text" class="form-control address" name="permanent_add_no" id="permanent_add_no">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                      <strong>Province</strong>
                      <select class="form-control location_select_province" name="permanent_add_prov" id="permanent_add_prov" onchange="changeMun('permanent_add_prov',this.value)">
                        @foreach(list_location('province') AS $value)
                          <option value="{{ $value->id }}">{{ $value->prov_desc }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="col-md-4">
                      <strong>Municipality</strong>
                      <select class="form-control location_select_municipal" name="permanent_add_mun" id="permanent_add_mun" onchange="changeBrgy('permanent_add_mun',this.value)">
                        <!-- GET INITIAL VALUE PARA DI MADAMI -->
                        <option value="{{ $data['add_permanent']['permanent_add_mun'] }}">{{ $data['add_permanent']['mun_desc'] }}</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                      <strong>Bgry</strong>
                      <select class="form-control" name="permanent_add_brgy" id="permanent_add_brgy">
                        <!-- GET INITIAL VALUE PARA DI MADAMI -->
                        <option value="{{ $data['add_permanent']['permanent_add_brgy'] }}">{{ $data['add_permanent']['brgy_desc'] }}</option>
                      </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                      <strong>Zipcode</strong>
                      <input type="text" class="form-control address" name="permanent_add_zipcode" id="permanent_add_zipcode" value="">
                  </div>
                  <div class="col-md-4">
                      <strong>Telephone</strong>
                      <input type="text" class="form-control address" name="contact_permanent" id="contact_permanent">
                  </div>
                </div>
                
              </div>
              <!-- END ADD INFO -->

              <!-- FAMILY INFO -->
              <div class="div-content" id="div-family">
                <div class="row">
                  <div class="col-md-3">
                      <strong>Spouse</strong>
                      <input type="text" class="form-control family" name="spouse_lname" id="spouse_lname" placeholder="Last Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="spouse_fname" id="spouse_fname" placeholder="First Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="spouse_mname" id="spouse_mname" placeholder="Middle Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="spouse_exname" id="spouse_exname" placeholder="Extension">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Occupation</strong>
                      <input type="text" class="form-control family" name="spouse_occ" id="spouse_occ" >
                  </div>
                  <div class="col-md-3">
                      <strong>Employer</strong>
                      <input type="text" class="form-control family" name="spouse_emp" id="spouse_emp" >
                  </div>
                  <div class="col-md-3">
                      <strong>Employer's Address</strong>
                      <input type="text" class="form-control family" name="spouse_emp_add" id="spouse_emp_add" >
                  </div>
                  <div class="col-md-3">
                      <strong>Telephone</strong>
                      <input type="text" class="form-control family" name="spouse_tel" id="spouse_tel" >
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Father's Name</strong>
                      <input type="text" class="form-control family" name="father_lname" id="father_lname" placeholder="Last Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="father_fname" id="father_fname" placeholder="First Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="father_mname" id="father_mname" placeholder="Middle Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="father_exname" id="father_exname" placeholder="Extension">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Mother's Maiden Name</strong>
                      <input type="text" class="form-control family" name="mother_lname" id="mother_lname" placeholder="Last Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="mother_fname" id="mother_fname" placeholder="First Name">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="text" class="form-control family" name="mother_mname" id="mother_mname" placeholder="Middle Name">
                  </div>
                </div>
              </div>
              <!-- END FAMILY INFO -->

              <!-- EDUCATION INFO -->
              <div class="div-content" id="div-education">
                
                <div class="row">
                  <div class="col-md-4">
                      <strong>Level</strong>
                      <select class="form-control" name="educ_level" id="educ_level">
                        <option value=""></option>
                        <option value="Primary">Primary</option>
                        <option value="Secondary">Secondary</option>
                        <option value="Vocational Course/Trade Course">Vocational Course/Trade Course</option>
                        <option value="College">College</option>
                        <option value="Master of Science">Master of Science</option>
                        <option value="Doctor of Philosophy">Doctor of Philosophy</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post-Graduate Diploma">Post-Graduate Diploma</option>
                      </select>
                  </div>
                  <div class="col-md-8">
                      <strong>Name of School</strong>
                      <input type="text" class="form-control education" name="educ_school" id="educ_school">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      
                  </div>
                  <div class="col-md-8">
                      <strong>Course</strong>
                      <input type="text" class="form-control education" name="educ_course" id="educ_course">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Inclusive Dates(year)</strong>
                      <input type="number" class="form-control family" name="educ_date_from" id="educ_date_from">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="number" class="form-control family" name="educ_date_to" id="educ_date_to">
                  </div>
                  <div class="col-md-6">
                      <strong>Highest grade/Units earned</strong>
                      <input type="text" class="form-control family" name="educ_highest" id="educ_highest">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                      <strong>Scholarsip/Academic : Honors Received</strong>
                      <input type="text" class="form-control family" name="educ_awards" id="educ_awards">
                  </div>
                </div>
              </div>
              <!-- END EDUCATION INFO -->

              <!-- ORANIZATION INFO -->
              <div class="div-content" id="div-org">
                <div class="row">
                  <div class="col-md-6">
                      <strong>Name of the Organization</strong>
                      <input type="text" class="form-control family" name="org_name" id="org_name">
                  </div>
                  <div class="col-md-6">
                      <strong>Address</strong>
                      <input type="text" class="form-control family" name="org_add" id="org_add">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3">
                      <strong>Inclusive Dates</strong>
                      <input type="date" class="form-control family" name="org_date_from" id="org_date_from">
                  </div>
                  <div class="col-md-3">
                      <strong>&nbsp</strong>
                      <input type="date" class="form-control family" name="org_date_to" id="org_date_to">
                  </div>
                  <div class="col-md-3">
                      <strong>No. of Hours</strong>
                      <input type="number" class="form-control family" name="org_hours" id="org_hours">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                      <strong>Position</strong>
                      <input type="text" class="form-control family" name="org_position" id="org_position">
                  </div>
                  <div class="col-md-6">
                      <strong>Nature of Work</strong>
                      <input type="text" class="form-control family" name="org_nature" id="org_nature">
                  </div>
                </div>
              </div>
              <!-- END ORANIZATION INFO -->

              <!-- ELIGIBILTY INFO -->
              <div class="div-content" id="div-eligibility">
                <div class="row">
                  <div class="col-md-4">
                      <strong>Career Service/RA 1080</strong>
                      <input type="text" class="form-control family" name="cse_title" id="cse_title">
                  </div>
                  <div class="col-md-4">
                      <strong>Rating</strong>
                      <input type="text" class="form-control family" name="cse_rating" id="cse_rating">
                  </div>
                  <div class="col-md-4">
                      <strong>Date of Exam</strong>
                      <input type="date" class="form-control family" name="cse_date" id="cse_date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <strong>Place of Examination</strong>
                      <input type="text" class="form-control family" name="cse_place" id="cse_place">
                  </div>
                  <div class="col-md-4">
                      <strong>License Number</strong>
                      <input type="text" class="form-control family" name="cse_license_num" id="cse_license_num">
                  </div>
                  <div class="col-md-4">
                      <strong>Date of Validity  </strong>
                      <input type="date" class="form-control family" name="cse_license_date" id="cse_license_date">
                  </div>
                </div>
              </div>
              <!-- END ELIGIBILTY INFO -->

              <!-- WORK INFO -->
              <div class="div-content" id="div-work">
                <div class="row">
                  <div class="col-md-4">
                    <strong>Company</strong>
                      <input type="text" class="form-control work" name="workexp_company" id="workexp_company">
                  </div>
                <div class="col-md-4">
                    <strong>Position Title</strong>
                      <input type="text" class="form-control work" name="workexp_position" id="workexp_position">
                  </div>
                  <div class="col-md-4">
                    <strong>Monthly Salary</strong>
                      <input type="number" class="form-control work" name="workexp_salary" id="workexp_salary">
                  </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4">
                    <strong>Inclusive Date</strong>
                      <input type="date" class="form-control work" name="workexp_date_from" id="workexp_date_from">
                  </div>
                <div class="col-md-4">
                    <strong>&nbsp</strong>
                      <input type="date" class="form-control work" name="workexp_date_to" id="workexp_date_to">
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-4">
                    <strong>Salary Grade & Step Increment</strong>
                      <input type="text" class="form-control work" name="workexp_salary_grade" id="workexp_salary_grade">
                  </div>
                <div class="col-md-4">
                    <strong>Appointment Status</strong>
                      <input type="text" class="form-control work" name="workexp_empstatus" id="workexp_empstatus">
                  </div>
                  <div class="col-md-4">
                    <strong>Gov't. Service</strong>
                    <br>
                    <input type="radio" name="workexp_gov" value="YES"> YES <input type="radio" name="workexp_gov" value="NO" checked> NO
                  </div>
              </div>
            </div>
              <!-- END WORK INFO -->

            <!-- SKILL INFO -->
              <div class="div-content" id="div-skill">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Description</strong>
                      <input type="text" class="form-control skill" name="skill_desc" id="skill_desc">
                  </div>
                </div>
            </div>
            <!-- END SKILL INFO -->

            <!-- COMPETENCY INFO -->
              <div class="div-content" id="div-competency">
                <div class="row">
                  <div class="col-md-12">
                    <strong>Description</strong>
                      <input type="text" class="form-control" name="competency_desc" id="competency_desc">
                  </div>
                  <br>
                  <br>
                  <br>
                  <div class="col-md-12">
                    <strong>Degree of Importance to the Job</strong>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary1" name="competency_job" checked value="1">
                        <label for="radioPrimary1">
                          1 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary2" name="competency_job" value="2">
                        <label for="radioPrimary2">
                          2 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary3" name="competency_job" value="3">
                        <label for="radioPrimary3">
                          3 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary4" name="competency_job" value="4">
                        <label for="radioPrimary4">
                          4 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary4" name="competency_job" value="5">
                        <label for="radioPrimary5">
                          5
                        </label>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <div class="col-md-12">
                    <strong>Current Level Skill</strong>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="skillRadioPrimary1" name="competency_skill" checked value="1">
                        <label for="skillRadioPrimary1">
                          1 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="skillRadioPrimary2" name="competency_skill" value="2">
                        <label for="skillRadioPrimary2">
                          2 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="skillRadioPrimary3" name="competency_skill" value="3">
                        <label for="skillRadioPrimary3">
                          3 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="skillRadioPrimary4" name="competency_skill" value="4">
                        <label for="skillRadioPrimary4">
                          4 &nbsp&nbsp&nbsp
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="skillRadioPrimary4" name="competency_skill" value="5">
                        <label for="skillRadioPrimary5">
                          5
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- END COMPETENCY INFO -->

            <!-- DUTY INFO -->
              <div class="div-content" id="div-competency-duty">
                <div class="row">
                  <div class="col-md-8">
                    <strong>Task</strong>
                      <input type="text" class="form-control" name="task" id="task">
                  </div>

                  <div class="col-md-4">
                    <strong>% of Work</strong>
                      <input type="text" class="form-control" name="task_percent" id="task_percent">
                  </div>
                </div>
            </div>
            <!-- END DUTY INFO -->

            <!-- TRAINING INFO -->
              <div class="div-content" id="div-competency-training">
                <div class="row">
                  <div class="col-md-12">
                    <strong>Training Programs Needed</strong>
                      <input type="text" class="form-control" name="training_desc" id="training_desc">
                  </div>
                </div>
            </div>
            <!-- END TRAINING INFO -->

            <!-- RECOGNITION INFO -->
              <div class="div-content" id="div-recognition">
                <div class="row">
                  <div class="col-md-12">
                    <strong>Description</strong>
                      <textarea class="form-control" name="recognition_desc" id="recognition_desc"></textarea>
                  </div>
                </div>
            </div>
            <!-- END RECOGNITION INFO -->

            <!-- ASSOCIATION INFO -->
              <div class="div-content" id="div-association">
                <div class="row">
                  <div class="col-md-12">
                    <strong>Description</strong>
                      <textarea class="form-control" name="association_desc" id="association_desc"></textarea>
                  </div>
                </div>
            </div>
            <!-- END ASSOCIATION INFO -->


            <!-- REFERENCES INFO -->
              <div class="div-content" id="div-references">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Name</strong>
                      <input type="text" class="form-control" name="reference_name" id="reference_name">
                  </div>
                  <div class="col-md-6">
                    <strong>Tel No.</strong>
                      <input type="text" class="form-control" name="reference_telno" id="reference_telno">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <strong>Address</strong>
                      <input type="text" class="form-control" name="reference_add" id="reference_add">
                  </div>
                </div>
            </div>
            <!-- END REFERENCES INFO -->

            <!-- REFERENCES INFO -->
              <div class="div-content" id="div-files-ipcr">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Year</strong>
                      <input type="number" class="form-control" name="files_ipcr_year" id="files_ipcr_year">
                  </div>
                  <div class="col-md-3">
                    <strong>Period</strong>
                      <select class="form-control" name="files_ipcr_period" id="files_ipcr_period">
                        <option value="January-June">January-June</option>
                        <option value="July-December">July-December</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                    <strong>Ave Rating</strong>
                      <input type="text" class="form-control" name="files_ipcr_score" id="files_ipcr_score">
                  </div>
                  <div class="col-md-3">
                    <strong>File</strong>
                      <input type="file" class="form-control" name="files_ipcr_file" id="files_ipcr_file">
                  </div>
                </div>
            </div>
            <!-- END REFERENCES INFO -->

            
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
<script src="{{ asset('multidate/bootstrap-datepicker.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var t = $('.tbl').DataTable();

    t.on('order.dt search.dt', function () {
      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      });
  }).draw();


      $('.date').datepicker({
        multidate: true,
        format: "yyyy-mm-dd",
        });
    } );


  $("#training_type").change(function(){
      $("#div-amount").hide();
      if(this.value == "Funded") {
          $("#div-amount").show();
      }
  });

  // $("#training_ld").change(function(){
  //     $("#div-others").hide();
  //     alert(alert($(this).find(':selected:last').val()));
  //     if(this.value == "Others") {
  //         $("#div-others").show();
  //     }
  // });

//   $('#training_ld').on('select2:select', function (e) {
//       $("#div-others").hide();
//       var data = e.params.data;
//       if(data.text == "Others") {
//           $("#div-others").show();
//       }
// });

  function modalOption(type,id = null)
  {
    // $("#trainingid").val(id);
    // $("#organizationid").val(id);
    // $("#eligibilityid").val(id);
    $("#tblid").val(id);
    $(".div-content").hide();

    switch(type)
    {
      case "basicinfo":

          $("#modal-option").modal('toggle');
          $("#modal-title").text("BASIC INFORMATION");
          $("#frm_url_action").val("{{ url('basicinfo/check') }}");
          $("#frm_url_reset").val("{{ url('personal-information/info') }}");
          $("#div-basic-info").show();

          //USER INFO
          $("#lname").val("{{ $data['empinfo']['lname'] }}");
          $("#fname").val("{{ $data['empinfo']['fname'] }}");
          $("#mname").val("{{ $data['empinfo']['mname'] }}");
          $("#exname").val("{{ $data['empinfo']['exname'] }}");
          $("#birthdate").val("{{ $data['empinfo']['birthdate'] }}");

          //BASIC INFO
          $("#placeofbirth").val("{{ $data['basicinfo']['basicinfo_placeofbirth'] }}");
          $("#info_height").val("{{ $data['basicinfo']['basicinfo_height'] }}");
          $("#info_weight").val("{{ $data['basicinfo']['basicinfo_weight'] }}");
          //SELECT
          $("#sex").val("{{ $data['basicinfo']['basicinfo_sex'] }}");
          $("#bloodtype").val("{{ $data['basicinfo']['basicinfo_bloodtype'] }}");
          $("#citizentype").val("{{ $data['basicinfo']['basicinfo_citizentype'] }}");


         $("#contact_cellnum").val("{{ $data['contact']['contact_cellnum'] }}");
          //SELECT2
          var vals = [
            <?php
              $arr = explode(",", $data['basicinfo']['basicinfo_citizenship']);

              foreach ($arr as $value){
                # code...
                echo '"'.$value.'",';
              }
            ?>
          ];
          var s2 = $("#citizenship");
          $("#citizenship").val(null).trigger("change"); 

          vals.forEach(function(e){
          if(!s2.find('option:contains(' + e + ')').length) 
            s2.append($('<option>').text(e));
          });

          s2.val(vals).trigger("change");

          $("#civilstatus").val("{{ $data['basicinfo']['basicinfo_civilstatus'] }}");
          $("#civilstatus").trigger('change');

      break;

      case "addinfo":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("ADDIONAL INFORMATION");
        $("#frm_url_action").val("{{ url('addinfo/check') }}");
        $("#frm_url_reset").val("{{ url('personal-information/addinfo') }}");
        $("#div-add-info").show();

        $("#pagibig").val("{{ $data['addinfo']['addinfo_pagibig'] }}");
        $("#philhealth").val("{{ $data['addinfo']['addinfo_philhealth'] }}");
        $("#sss").val("{{ $data['addinfo']['addinfo_sss'] }}");
        $("#tin").val("{{ $data['addinfo']['addinfo_tin'] }}");
        $("#gsis_id").val("{{ $data['addinfo']['addinfo_gsis_id'] }}");
        $("#gsis_policy").val("{{ $data['addinfo']['addinfo_gsis_policy'] }}");
        $("#gsis_bp").val("{{ $data['addinfo']['addinfo_gsis_bp'] }}");
        // $("#partner").val("{{ $data['addinfo']['addinfo_partner'] }}");
        $("#landbank").val("{{ $data['addinfo']['addinfo_landbank'] }}");
        $("#gov").val("{{ $data['addinfo']['addinfo_gov'] }}");
        $("#gov_id").val("{{ $data['addinfo']['addinfo_gov_id'] }}");
        $("#gov_place_date").val("{{ $data['addinfo']['addinfo_gov_place_date'] }}");
        $("#ctc").val("{{ $data['addinfo']['addinfo_ctc'] }}");
        $("#ctc_date").val("{{ $data['addinfo']['addinfo_ctc_date'] }}");
        $("#ctc_place").val("{{ $data['addinfo']['addinfo_ctc_place'] }}");
      break;

      case "address":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("ADDRESS");
        $("#frm_url_action").val("{{ url('address/check') }}");
        $("#frm_url_reset").val("{{ url('personal-information/address') }}");
        $("#div-address").show();

        $("#residential_add_street").val("{{ $data['add_residential']['residential_add_street'] }}");
        $("#residential_add_subd").val("{{ $data['add_residential']['residential_add_subd'] }}");
        $("#residential_add_no").val("{{ $data['add_residential']['residential_add_no'] }}");
        $("#residential_add_zipcode").val("{{ $data['add_residential']['residential_add_zipcode'] }}");
        $("#residential_add_prov").val("{{ $data['add_residential']['residential_add_prov'] }}");
        $("#contact_residential").val("{{ $data['contact']['contact_residential'] }}");

        $("#permanent_add_street").val("{{ $data['add_permanent']['permanent_add_street'] }}");
        $("#permanent_add_subd").val("{{ $data['add_permanent']['permanent_add_subd'] }}");
        $("#permanent_add_no").val("{{ $data['add_permanent']['permanent_add_no'] }}");
        $("#permanent_add_zipcode").val("{{ $data['add_permanent']['permanent_add_zipcode'] }}");
        $("#permanent_add_prov").val("{{ $data['add_permanent']['permanent_add_prov'] }}");
        $("#contact_permanent").val("{{ $data['contact']['contact_permanent'] }}");
      break;

      case "family":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("FAMILY BACKGROUND");
        $("#frm_url_action").val("{{ url('family/check') }}");
        $("#frm_url_reset").val("{{ url('personal-information/family') }}");
        $("#div-family").show();

        $("#spouse_lname").val("{{ $data['family']['fam_spouse_lname'] }}");
        $("#spouse_fname").val("{{ $data['family']['fam_spouse_fname'] }}");
        $("#spouse_mname").val("{{ $data['family']['fam_spouse_mname'] }}");
        $("#spouse_exname").val("{{ $data['family']['fam_spouse_exname'] }}");
        $("#spouse_occ").val("{{ $data['family']['fam_spouse_occ'] }}");
        $("#spouse_emp").val("{{ $data['family']['fam_spouse_emp'] }}");
        $("#spouse_emp_add").val("{{ $data['family']['fam_spouse_emp_add'] }}");
        $("#spouse_tel").val("{{ $data['family']['fam_spouse_tel'] }}");

        $("#father_lname").val("{{ $data['family']['fam_father_lname'] }}");
        $("#father_fname").val("{{ $data['family']['fam_father_fname'] }}");
        $("#father_mname").val("{{ $data['family']['fam_father_mname'] }}");
        $("#father_exname").val("{{ $data['family']['fam_father_exname'] }}");

        $("#mother_lname").val("{{ $data['family']['fam_mother_lname'] }}");
        $("#mother_fname").val("{{ $data['family']['fam_mother_fname'] }}");
        $("#mother_mname").val("{{ $data['family']['fam_mother_mname'] }}");
      break;

       case "add-education":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("EDUCATION BACKGROUND");
        $("#frm_url_action").val("{{ url('education/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/education') }}");
        $("#div-education").show();
      break;

      case "add-competency":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency").show();
      break;

      case "add-competency-duty":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency-duty/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency-duty").show();
      break;

      case "add-competency-training":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency-training/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency-training").show();
      break;

      case "edit-competency-duty":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency-duty/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency-duty").show();

        $.getJSON( "{{ url('competency-duty/json') }}/"+id, function( datajson ) {
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#task").val(obj.task);
                         $("#task_percent").val(obj.task_percent);
                    });
            }).fail(function() {
            });
      break;

      case "edit-competency-training":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency-training/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency-training").show();

        $.getJSON( "{{ url('competency-training/json') }}/"+id, function( datajson ) {
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#training_desc").val(obj.training_desc);
                    });
            }).fail(function() {
            });
      break;

      case "edit-competency":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("COMPETENCY");
        $("#frm_url_action").val("{{ url('competency/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#div-competency").show();

        $.getJSON( "{{ url('competency/json') }}/"+id, function( datajson ) {
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#competency_desc").val(obj.competency_desc);
                         $("input[name=competency_job][value=" + obj.competency_job + "]").prop('checked', true);
                         $("input[name=competency_skill][value=" + obj.competency_skill + "]").prop('checked', true);
                    });
            }).fail(function() {
            });
      break;

      case "delete-competency":
        $("#frm_url_action").val("{{ url('competency/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#frm").submit();
      break;

      case "delete-competency-duty":
        $("#frm_url_action").val("{{ url('competency-duty/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#frm").submit();
      break;

      case "delete-competency-training":
        $("#frm_url_action").val("{{ url('competency-training/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/competency') }}");
        $("#frm").submit();
      break;

      case "edit-education":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("EDUCATION BACKGROUND");
        $("#frm_url_action").val("{{ url('education/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/education') }}");
        $("#div-education").show();

        $.getJSON( "{{ url('education/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#educ_level").val(obj.educ_level);
                         $("#educ_school").empty().val(obj.educ_school);
                         $("#educ_course").empty().val(obj.educ_course);
                         $("#educ_date_from").empty().val(obj.educ_date_from);
                         $("#educ_date_to").empty().val(obj.educ_date_to);
                         $("#educ_highest").empty().val(obj.educ_highest);
                         $("#educ_awards").empty().val(obj.educ_awards);
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-education":
        $("#frm_url_action").val("{{ url('education/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/education') }}");
        $("#frm").submit();
      break;

      case "add-organization":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("ORGANIZATION");
        $("#frm_url_action").val("{{ url('organization/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/organization') }}");
        $("#div-org").show();
      break;

      case "edit-organization":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("ORGANIZATION");
        $("#frm_url_action").val("{{ url('organization/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/organization') }}");
        $("#div-org").show();

        $.getJSON( "{{ url('organization/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#org_name").empty().val(obj.org_name); 
                         $("#org_add").empty().val(obj.org_add);
                         $("#org_date_from").empty().val(obj.org_date_from);
                         $("#org_date_to").empty().val(obj.org_date_to);
                         $("#org_hours").empty().val(obj.org_hours);
                         $("#org_position").empty().val(obj.org_position);
                         $("#org_nature").empty().val(obj.org_nature);
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-organization":
        $("#frm_url_action").val("{{ url('organization/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/organization') }}");
        $("#frm").submit();
      break;

      case "add-eligibility":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("CAREER SERVICE ELIGIBILITY");
        $("#frm_url_action").val("{{ url('eligibility/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/eligibility') }}");
        $("#div-eligibility").show();
      break;

      case "delete-eligibility":
        $("#frm_url_action").val("{{ url('eligibility/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/eligibility') }}");
        $("#frm").submit();
      break;

      case "edit-eligibility":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("CAREER SERVICE ELIGIBILITY");
        $("#frm_url_action").val("{{ url('eligibility/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/eligibility') }}");
        $("#div-eligibility").show();

        $.getJSON( "{{ url('eligibility/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#cse_title").empty().val(obj.cse_title);
                         $("#cse_rating").empty().val(obj.cse_rating);
                         $("#cse_date").empty().val(obj.cse_date);
                         $("#cse_place").empty().val(obj.cse_place);
                         $("#cse_license_num").empty().val(obj.cse_license_num);
                         $("#cse_license_date").empty().val(obj.cse_license_date);
                         
                    });
            }).fail(function() {
            });
      break;

      case "add-work":
        $("#modal-option").modal('toggle');
        $("#frm_url_action").val("{{ url('work/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/work') }}");
        $("#modal-title").empty().text("WORK EXPERIENCE");
        $("#div-work").show();
      break;

      case "edit-work":
            $("#modal-option").modal('toggle');
            $("#modal-title").empty().text("WORK EXPERIENCE");
            $("#frm_url_action").val("{{ url('training/update') }}");
            $("#frm_url_reset").val("{{ url('personal-information/training') }}");
            $("#div-work").show();
            $("#trainingid").val(id);
      break;

      case "delete-work":
        $("#frm_url_action").val("{{ url('work/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/work') }}");
        $("#frm").submit();
      break;

      case "add-training":
        $("#modal-option").modal('toggle');
        $("#frm_url_action").val("{{ url('training/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/training') }}");
        $("#modal-title").empty().text("TRAINING");
        $("#div-add-new-training").show();
      break;

      case "edit-training":
            $("#modal-option").modal('toggle');
            $("#modal-title").empty().text("TRAINING");
            $("#frm_url_action").val("{{ url('training/update') }}");
            $("#frm_url_reset").val("{{ url('personal-information/training') }}");
            $("#div-add-new-training").show();
            $("#trainingid").val(id);
            $.getJSON( "{{ url('training/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#training_title").empty().val(obj.training_title); 
                         $("#training_conducted_by").empty().val(obj.training_conducted_by);
                         $("#training_hours").empty().val(obj.training_hours);

                         //Multiple Dates
                         $("#training_inclusive_date").empty().val(obj.training_inclusive_dates);

                                var dt = obj.training_inclusive_dates;
                                var parsedDates = dt.split(",");

                                // console.log(parsedDates);

                                $('#training_inclusive_date').datepicker({
                                    startDate: new Date(),
                                    multidate: true,
                                    format: "yyyy-mm-dd",
                                    daysOfWeekHighlighted: "5,6",
                                    language: 'en'
                                });

                                $('#training_inclusive_date').datepicker('setDates',parsedDates);

                          //Multiple LD
                          vals = obj.training_ld;
                          vals = vals.split(",");

                          // var vals = ["Trade Fair", "CA", "Party"];
                          var s2 = $("#training_ld");
                          $("#training_ld").val(null).trigger("change"); 

                          vals.forEach(function(e){
                          if(!s2.find('option:contains(' + e + ')').length) 
                            s2.append($('<option>').text(e));
                          });

                          s2.val(vals).trigger("change");


                         $("#training_type").val(obj.training_type); 
                         $("#areasdiscip").val(obj.areas_of_discipline); 
                         $("#div-amount").hide();
                         if(obj.training_type == 'Funded')
                         {
                            $("#div-amount").show(); 
                            $("#training_amount").empty().val(obj.training_amount);
                         }
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-training":
        $("#frm_url_action").val("{{ url('training/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/training') }}");
        $("#frm").submit();
      break;

      case "add-skill":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("SPECIAL SKILLS/HOBBIES");
        $("#frm_url_action").val("{{ url('skill/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-skill").show();
      break;

      case "edit-skill":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("SPECIAL SKILLS/HOBBIES");
        $("#frm_url_action").val("{{ url('skill/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-skill").show();

        $.getJSON( "{{ url('skill/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#skill_desc").empty().val(obj.skill_desc);
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-skill":
        $("#frm_url_action").val("{{ url('skill/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#frm").submit();
      break;

      case "add-recognition":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("NON-ACADEMIC DISTINCTIONS/RECOGNITION");
        $("#frm_url_action").val("{{ url('recognition/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-recognition").show();
      break;

      case "edit-recognition":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("NON-ACADEMIC DISTINCTIONS/RECOGNITION");
        $("#frm_url_action").val("{{ url('recognition/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-recognition").show();

        $.getJSON( "{{ url('recognition/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#recognition_desc").empty().val(obj.recog_desc);
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-recognition":
        $("#frm_url_action").val("{{ url('recognition/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#frm").submit();
      break;

      case "add-association":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("MEMBERSHIP IN ASSOCIATION/ORGANIZATION");
        $("#frm_url_action").val("{{ url('association/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-association").show();
      break;

      case "edit-association":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("MEMBERSHIP IN ASSOCIATION/ORGANIZATION");
        $("#frm_url_action").val("{{ url('association/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-association").show();

        $.getJSON( "{{ url('association/json') }}/"+id, function( datajson ) {
                
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#association_desc").empty().val(obj.assoc_desc);
                         
                    });
            }).fail(function() {
            });
      break;

      case "delete-association":
        $("#frm_url_action").val("{{ url('association/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#frm").submit();
      break;

      case "add-reference":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("REFERENCES");
        $("#frm_url_action").val("{{ url('reference/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-references").show();
      break;

      case "edit-reference":
        $("#modal-option").modal('toggle');
        $("#modal-title").text("REFERENCES");
        $("#frm_url_action").val("{{ url('reference/update') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#div-references").show();

        $.getJSON( "{{ url('reference/json') }}/"+id, function( datajson ) {      
              }).done(function(datajson) {
                jQuery.each(datajson,function(i,obj){
                         $("#reference_name").empty().val(obj.reference_name);
                         $("#reference_add").empty().val(obj.reference_add);
                         $("#reference_telno").empty().val(obj.reference_telno);
                    });
            }).fail(function() {
            });
      break;

      case "delete-reference":
        $("#frm_url_action").val("{{ url('reference/delete') }}");
        $("#frm_url_reset").val("{{ url('personal-information/other') }}");
        $("#frm").submit();
      break;

      case "add-files-ipcr":
        $("#modal-option").modal('toggle');
        $("#frm_url_action").val("{{ url('performance/ipcr-staff/create') }}");
        $("#frm_url_reset").val("{{ url('personal-information/files') }}");
        $("#modal-title").empty().text("IPCR");
        $("#div-files-ipcr").show();
      break;

    }
  }

  function resetForm()
  {

  }


  function changeMun(type,provid)
  {
    $.getJSON( "{{ url('location/municipal') }}/"+provid, function( datajson ) {
                
              }).done(function(datajson) {
                if(type == 'permanent_add_prov')
                {
                  $("#permanent_add_mun").empty().append("<option value='' disabled selected>---Select Municipality---</option>");;
                  $("#permanent_add_brgy").empty();
                  jQuery.each(datajson,function(i,obj){
                            $("#permanent_add_mun").append("<option value='"+obj.id+"'>"+obj.mun_desc+"</option>");
                      });
                }
                else
                {
                  $("#residential_add_mun").empty().append("<option value='' disabled selected>---Select Municipality---</option>");;
                  $("#residential_add_brgy").empty();
                  jQuery.each(datajson,function(i,obj){
                            $("#residential_add_mun").append("<option value='"+obj.id+"'>"+obj.mun_desc+"</option>");
                      });
                }
            }).fail(function() {
                 Swal.fire({
                    title: 'Ooopppsss!',
                    text: 'Something went wrong. Page will now reload.',
                    type: 'warning'
                  }).then(function() {
                      window.location.reload();
                  })
            });
  }

function changeBrgy(type,munid)
  {
    $.getJSON( "{{ url('location/barangay') }}/"+munid, function( datajson ) {
                
              }).done(function(datajson) {
                if(type == 'permanent_add_mun')
                {
                  $("#permanent_add_brgy").empty().append("<option value='' disabled selected>---Select Barangay---</option>");
                  jQuery.each(datajson,function(i,obj){
                            $("#permanent_add_brgy").append("<option value='"+obj.id+"'>"+obj.brgy_desc+"</option>");
                      });
                }
                else
                {
                  $("#residential_add_brgy").empty().append("<option value='' disabled selected>---Select Barangay---</option>");
                  jQuery.each(datajson,function(i,obj){
                            $("#residential_add_brgy").append("<option value='"+obj.id+"'>"+obj.brgy_desc+"</option>");
                      });
                }
            }).fail(function() {
                 Swal.fire({
                    title: 'Ooopppsss!',
                    text: 'Something went wrong. Page will now reload.',
                    type: 'warning'
                  }).then(function() {
                      window.location.reload();
                  })
            });
  }


</script>
@endsection