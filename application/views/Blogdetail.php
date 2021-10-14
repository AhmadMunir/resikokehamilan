	<!-- 
		retrieve data 
	-->
	<?php

	// from Product Category 
	foreach($setting ->result() as $row)
	{
		foreach($row as $rs)
		{
			$dbset[]=$rs;
		}
	}
	?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 

<html class="no-js"> <!--<![endif]-->
    <head>

        <!-- meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="description" content="<?= $dbset[2];?>">
		<meta name="author" content="Eight House">
		<title><?= $dbset[2];?></title>
        
        <!-- stylesheets -->
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/animate.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/style.css">

		
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/<?= $dbset[3];?>">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>


        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url();?>">
                        <img src="<?= base_url();?>assets/images/logo.png" alt="Site Logo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="<?= site_url();?>">back to home</span></a></li>
                    </ul>
                </div><!-- end of /.navbar-collapse -->
            </div><!-- end of /.container -->
        </nav>

        <main>
            <div class="container">
                <div class="row">

                    <!-- blog-contents -->
                    <section class="col-md-12">

						<?php
						//events
						foreach($events ->result() as $row)
						{
							$idevents=$row->id;
							$titleevents=$row->title;
							$dateevents=$row->date;
							$contevents=$row->content;
							$picevents=$row->pic;
							$empevents=$row->emp;
							$stevents=$row->stat;
							
							$idemp=$row->idemp;
							$titleemp=$row->title;
							$aboutemp=$row->about;
							$picemp=$row->ava;
							$facebookemp=$row->facebook;
							$twitteremp=$row->twitter;
							$linkedinemp=$row->linkedin;
							$gplusemp=$row->gplus;
						}
						
						//comments
						foreach($comment ->result() as $row)
						{
							$idcomment[]=$row->id;
							$datecomment[]=$row->date;
							$timecomment[]=$row->time;
							$contcomment[]=$row->content;
							$nmcomment[]=$row->nm;
							$emailcomment[]=$row->email;
						}
						
						
						//comments
						foreach($relevents ->result() as $row)
						{
							$idrelevents[]=$row->id;
							$titlerelevents[]=$row->title;
						}
						?>
                        <article class="single-blog-item">

                            <div class="alert alert-info">
                                    <p>
                                         <i class="fa fa-user"></i>
                                        <?=$empevents?>
                                        &nbsp;
                                        <i class="fa fa-calendar"></i>
                                        <time><?=$dateevents?><time>
                                    </p>
                            </div>

                            <h1 class="text-center"><?=$titleevents?></h1>
							<img src="<?= base_url()."assets/images/picNews/".$picevents?>" width="100%" height="auto" class="center-block">
							<br>
							<?=$contevents?>



                        </article>

					<?php
						if(isset($idrelevents))
						{
						?>
                        <h4>Related Articles</h4>
                        <div class="related-articles">
						<?php
							for($i=0;$i<count($idrelevents);$i++)
							{
							?>	
                            <div class="alert alert-info">
                                <a href="<?= site_url();?>Blog/Det/<?=$idrelevents[$i];?>"><?=$titlerelevents[$i];?></a>
                            </div>
							
							<?php
							}
						?>	
                        </div>
						
							<?php
							}
						?>	


                        <div class="author">
                            <p>Written by <strong class="text-capitalize"><?=$empevents?></strong></p>
                            <p>
                                <?=$aboutemp;?>
                            </p>
                        </div>

                        <div class="feedback">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>feedback</h1>
									
									
											
									<!-- 
										retrieve comment
									-->
									<?php
										if(isset($idcomment))
										for($i=0;$i<count($idcomment);$i++)
										{
										?>	
												
											<div class="well">
												<div class="row">
													<div class="col-md-2">
														<img src="<?= base_url();?>assets/admin/img/avatar/thumb/def.jpg" class="img-responsive img-circle center-block">
													</div>
													<div class="col-md-10">
														<p class="comment-info">
															<strong><?=$nmcomment[$i]?></strong> <span><?=$datecomment[$i]?></span>,<span><?=$timecomment[$i]?></span>
														</p>
														<p>
															<?=$contcomment[$i]?>
														</p>
													</div>
												</div>
											</div>
									
										<?php
										}
									?>	
									

                                </div>
                            </div>
							
							
							
                        </div>

                        <div class="comment-post">
                            <h1>post a comment</h1>
                            <form method="post" action="<?= site_url();?>/Blog/Addcomment/<?= $idevents;?>" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input  name="txtname" type="text" class="form-control" id="name" required="required" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="txtemail" type="email" class="form-control" id="email" required="required" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="txtmessage" type="text" class="form-control" id="message" rows="5" required="required" placeholder="Type here message"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" required="required"> Please Check to Confirm
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="submit" name="submit" class="btn btn-cmnt">post comment</button>
                                    </div>
                                </div>
                                   <!-- <div class="g-recaptcha" data-sitekey="6Leejh4TAAAAABIaJ-1bmsb9f-8zGPGqm7tLvsJd"></div>      -->
                            </form>
                        </div>
                    </section>
                    <!-- end of blog-contents -->


                </div>
            </div> <!-- end of /.container -->
        </main>


        <footer>
            <div class="container">
                <div class="row">
                    <!-- copyright -->
                    <div class="col-md-4 col-sm-4">
                        copyright &copy; 2016 <a href="#" style="margin-left: 4px;"><?= $dbset[2];?></a>
                        <br>
                    </div>

                    <!-- footer share button -->
                    <div class="col-md-4 col-sm-4">
                        <ul class="social-share text-center">
                            <li><a href="http://www.twitter.com/<?= $dbset[8];?>"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="http://plus.google.com/<?= $dbset[11];?>"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="http://www.facebook.com/<?= $dbset[9];?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="http://www.linkedin.com/<?= $dbset[10];?>"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="http://www.twitter.com/<?= $dbset[12];?>"><i class="fa fa-instagram"></i></a></li>
                        </ul> <!-- /.social-share -->
                    </div>

                </div>
            </div>
        </footer>


        <!--  Necessary scripts  -->

        <script type="text/javascript" src="<?= base_url();?>assets/blog/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="<?= base_url();?>assets/blog/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= base_url();?>assets/blog/js/jQuery.scrollSpeed.js"></script>

        <!-- smooth-scroll -->

        <script>
        $(function() {  
            jQuery.scrollSpeed(100, 1000);
        });
        </script>

    </body>
</html>




