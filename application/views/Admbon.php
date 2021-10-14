	<section class="content-header">
          <h1>
            <?= $pageTitle?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= site_url();?>/admin"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li><a href="<?= site_url();?>/<?= $breadcrumbLink?>"><?= $breadcrumbTitle?></a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
					<span><?= $pageTitle?></span>
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
			<form class="form-horizontal" enctype="multipart/form-data" data-toggle="validator" role="form" method="POST" action="<?= site_url();?>/<?= $saveLink;?>" >
			
			
			<?php
										if(!empty($formLabel))
										{
										?>
										
												<?php
												$i=0;
												foreach($formLabel as $row)
												{
												?> 
													  <div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label"><?= $row ?></label>
														
														<div class="col-sm-10">
														  <?= $formTxt[$i] ?>
														</div>
													  </div>
												<?php
												$i++;
												}
												?>
										<?php
										}
										?>
								  
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-default">Submit</button>
				</div>
			  </div>
			</form>
			
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


