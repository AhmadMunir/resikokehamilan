
	<!-- 
		retrieve data 
	-->
	<?php

	// from Product Category 
	foreach($users ->result() as $row)
	{
		$usercode=$row->code_user;
		$usernm=$row->nm_user;
		$usersex="";
		$useraddress="";
		$useremail="";
		$usertitle="";
		$userabout="";
	}
	?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            User Profile
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?= base_url();?>assets/admin/img/avatar/thumb/<?= $this->session->userdata('picUser');?>"  alt="User profile picture">
                  <h3 class="profile-username text-center">
				  
                      <?= $usernm;?>
				  </h3>
                  <p class="text-muted text-center">
				  
                      <?= $usertitle;?>
				  </p>

                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About Me</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
                  
                  <p>				  
                    <strong data-toggle="tooltip" title="Address"><i class="fa fa-home fa-fw"></i>   <?= $useraddress;?></strong>
                  </p>
				  
				  
                  <p>
                     
				   <strong data-toggle="tooltip" title="E-Mail"><i class="fa fa-envelope fa-fw"></i>  <?= $useremail;?></strong>
                  </p>

                  <hr>
				  
                  <strong><i class="fa fa-map-marker fa-fw"></i> About</strong>
                  <p class="text-muted">
				   <?= $userabout;?>
				  </p>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
			
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#lobhistory" data-toggle="tab">Website Profile</a></li>
                  <li><a href="#events" data-toggle="tab">Events</a></li>
                  <li><a href="#changepassword" data-toggle="tab">Change Password</a></li>
                </ul>
				
                <div class="tab-content">
					<div class=" active tab-pane" id="lobhistory">
                    <!-- Post -->
					
					
                    <form class="form-horizontal">
					<h4>Basic Info</h4>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 ">Description</label>
                        : 
                      </div>
					  
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 ">Address</label>
                        : 
                      </div>
					  
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 ">E-Mail Address</label>
                        : 
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 ">Phone</label>
                        : 
							  </div>
						<div id="graph"></div>
					  
                
                    </form>
					
					</div><!-- /.tab-pane -->
                  <div class="tab-pane" id="events">
                    <!-- Post -->
					Under Construction
					</div><!-- /.tab-pane -->
					
					

                  <div class="tab-pane" id="changepassword">
                    <form class="form-horizontal" action="<?= site_url();?>Changepassword/change" method="POST">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Password Lama</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="pwdOld" placeholder="Max. 32 Characters" name='txt_pwdold'>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Password Baru</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="pwdNew" placeholder="Max. 32 Characters" name='txt_pwdnew' required   >
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Konfirmasi Password</label>
                        <div class="col-sm-10">
							<input type="password" class="form-control" id="pwdNew1" placeholder="Max. 32 Characters" name='txt_pwnew1' required  data-match='#pwdNew' data-match-error='Password Baru tidak sama' >
							<div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Ubah Password</button>
                        </div>
                      </div>
                    </form>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->
