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
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/<?= $dbset[3];?>">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/animate.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/blog/css/style.css">

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
						foreach($events ->result() as $row)
						{
							$idevents[]=$row->id;
							$titleevents[]=$row->title;
							$dateevents[]=$row->date;
							$contevents[]=$row->content;
							$picevents[]=$row->pic;
							$empevents[]=$row->emp;
							$stevents[]=$row->stat;
						}
						?>
						
										
						<?php
						if(isset($idevents))
						for($i=0;$i<count($idevents);$i++)
						{
						?>	
						
                        <article class="blog-item">
                            <div class="row">
                                <div class="col-md-3">
                                        <a href="<?= site_url();?>Blog/Det/<?=$idevents[$i]?>">
                                        <img src="<?php echo base_url();?>assets/images/picNews/<?=$picevents[$i]?>" class="img-thumbnail center-block" alt="Blog Post Thumbnail">
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <p>
                                        <i class="fa fa-user"></i>
                                        <?=$empevents[$i]?>
                                        &nbsp;
                                        <i class="fa fa-calendar"></i>
                                        <time><?=$dateevents[$i]?><time>
                                    </p>
                                    <h1>
                                        <a href="<?= site_url();?>Blog/Det/<?=$idevents[$i]?>">
										<?=$titleevents[$i]?>
										<p><?=$contevents[$i]?></p>
										</a>
                                    </h1>
                                </div>
                            </div>
                        </article> <!-- /.blog-item -->
						
						<?php
						}
						?>
						


                        <div class="page-turn">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 text-center">
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            <li class="disabled">
                                                <a href="#" aria-label="Previous">
                                                    <span aria-hidden="true">Prev</span>
                                                </a>
                                            </li>
                                            <li class="active"><a href="index.html">1</a></li>
                                            <li><a href="page2.html">2</a></li>
                                            <li><a href="page3.html">3</a></li>
                                            <li><a href="page4.html">4</a></li>
                                            <li><a href="page5.html">5</a></li>
                                            <li>
                                                <a href="page6.html" aria-label="Next">
                                                    <span aria-hidden="true">Next</span>
                                                </a>
                                            </li>
                                        </ul> <!-- /.pagination -->
                                    </nav>
                                </div>
                            </div>
                        </div> <!-- /.page-turn -->

                    </section>
                    <!-- end of blog-contents -->

                    <!-- sidebar -->
                    <!-- end of sidebar -->

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
                            <li><a href="http://www.instagram.com/<?= $dbset[12];?>"><i class="fa fa-instagram"></i></a></li>
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