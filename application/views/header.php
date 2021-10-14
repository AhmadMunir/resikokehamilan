<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Suara Akbar">
    <meta name="author" content="Eight House">
    <title><?= $dbset[2];?></title>
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">	
	<link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet">

	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/slicknav.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
	
	
  
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/camera.min.js"></script>
    <!--[if lt IE 9]>
	    <script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
	    <script src="<?php echo base_url();?>assets/js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/<?= $dbset[3];?>">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header" role="banner">		
		<div class="main-nav">
			<div class="container">
				<div class="header-top">
					<div class="pull-right social-icons">
						<a href="http://www.twitter.com/<?= $dbset[8];?>"  target="_blank" title="<?= $dbset[8];?>"><i class="fa fa-twitter"></i></a>
						<a href="http://www.facebook.com/<?= $dbset[9];?>" target="_blank" title="<?= $dbset[9];?>"><i class="fa fa-facebook"></i></a>
						<a href="http://www.instagram.com/<?= $dbset[12];?>" target="_blank" title="<?= $dbset[12];?>"><i class="fa fa-instagram"></i></a>
					</div>
				</div>     
		        <div class="row">	        		
		            <div class="navbar-header">
		                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		                    <span class="sr-only">Toggle navigation</span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                </button>
		                <a class="navbar-brand" href="<?php echo site_url();?>">
		                	<img class="img-responsive" src="<?php echo base_url();?>assets/images/<?= $dbset[4];?>" alt="logo" >
		                </a>                    
		            </div>
		            <div class="collapse navbar-collapse">
		                <ul class="nav navbar-nav navbar-right">                 
		                    <li class="scroll active"><a href="#home">Beranda</a></li>                       
		                    <li class="scroll"><a href="#blog">Program Kami</a></li>         
		                    <li class="no-scroll"><a href="#twitter">Mitra Akbar</a></li>
		                    <li class="scroll"><a href="#about">Artikel</a></li>  
		                    <li class="scroll"><a href="#charts">Charts</a></li>              
		                    <li class="scroll"><a href="#contact">Hubungi Kami</a></li>       
		                </ul>
		            </div>
		        </div>
	        </div>
        </div>                    
    </header>
    <!--#header--> 

    <section id="home">	
	
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
		<div id="main-slider" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
								
			<?php
			$isactive="class='active'";
			if(isset($idevents))
			for($i=0;$i<count($idevents);$i++)
			{
			?>	
				<li data-target="#main-slider" data-slide-to="<?=$i?>" <?=$isactive?>></li>
				
			<?php
			$isactive="";
			}
			?>	
			</ol>
			<div class="carousel-inner">
			
										
			<?php
			$isactive="active";
			if(isset($idevents))
			for($i=0;$i<count($idevents);$i++)
			{
			?>	
				<div class="item act-item <?= $isactive;?>" style="background-image: url('<?php echo base_url();?>assets/images/picNews/<?= $picevents[$i];?>');background-size: cover">
								
					<div class="carousel-caption">
						<h2><?=$titleevents[$i]?> </h2>
						<h4><?=$dateevents[$i]?></h4>
						<a href="<?=site_url();?>Blog/det/<?= $idevents[$i];?>" target="_blank" >Lihat Selengkapnya <i class="fa fa-angle-right"></i></a>
					</div>
				</div>	

			<?php
			$isactive="";
			}
			?>				
			</div>
		</div>    	
    </section>
	<!--/#home-->

	<section id="explore">
	
	<?php
	foreach($jupdate ->result() as $row)
	{
		$idjupdate=$row->id;
		$titlejupdate=$row->tit;
		$datejupdate=$row->date;
		$contjupdate=$row->cont;
		$nmjupdate=$row->nm;
		$stjupdate=$row->st;
		$kejupdate=$row->ke;
	}
	?>
		<div class="container">
			<div class="row">
				<div class="watch">
					<img class="img-responsive" src="<?= base_url();?>assets/images/watch.png" alt="">
				</div>				
				<div class="col-md-8 col-md-offset-2  col-sm-5">
					<hr>
					<h2>Jember UPDATE <?= $kejupdate;?> !!!</h2>
					<p>
					
			<h4 class="text-center"><i class="fa fa-user"></i>&nbsp;<?= $nmjupdate;?>&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar"></i>&nbsp;<?= $datejupdate;?></h4>
					</p>
					<hr>
					
					<b><h3 class="text-center"><?= $titlejupdate;?></h3></b>
					<?= $contjupdate;?>
				</div>			
			</div>
		</div>
	</section><!--/#explore-->
	

	<section id="blog">
		<!-- 
		retrieve data 
	-->
	<?php

	// from Product Category 
	foreach($announcer ->result() as $row)
	{
		$idannouncer[]=$row->id_announcer;
		$nmannouncer[]=$row->nm_announcer;
		$showannouncer[]=$row->show_announcer;
		$picannouncer[]=$row->pic_announcer;
	}
	?>	

		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					&nbsp;
					<!--
					<div id="event-carousel" class="carousel slide" data-interval="4000">
					
						<h2 class="heading">OUR PROGRAMS</h2>
						<a class="even-control-left" href="<?php echo base_url();?>assets/#event-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="even-control-right" href="<?php echo base_url();?>assets/#event-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner "  >
						<?php
						if(isset($idannouncer))
							for($i=0;$i<count($idannouncer);$i++)
							{
							?>	
							
							<?php
							if($i==0)
							{
							?>
							<div class="item active">
							<?php
							}
							else
							{
							?>							
							<div class="item ">							
							<?php
							}
							?>
								<div class="row">
									<div class="col-sm-4">
										<div class="single-event">
											<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i];?>" alt="event-image" width="100px">
											<h4><?=$nmannouncer[$i];?></h4>
											<h5><?=$showannouncer[$i];?></h5>
										</div>
									</div>
									<?php
									if(isset($idannouncer[$i+1]))
									{
									?>
										<div class="col-sm-4">
											<div class="single-event">
												<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i+1];?>" alt="event-image" width="100px">
												<h4><?=$nmannouncer[$i+1];?></h4>
												<h5><?=$showannouncer[$i+1];?></h5>
											</div>
										</div>
									<?php
									}
									
									if(isset($idannouncer[$i+2]))
									{
									?>
										<div class="col-sm-4">
											<div class="single-event">
												<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i+2];?>" alt="event-image" width="100px">
												<h4><?=$nmannouncer[$i+2];?></h4>
												<h5><?=$showannouncer[$i+2];?></h5>
											</div>
										</div>
									<?php
									}
									
									if(isset($idannouncer[$i+3]))
									{
									?>
										<div class="col-sm-4">
											<div class="single-event">
												<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i+3];?>" alt="event-image" width="100px">
												<h4><?=$nmannouncer[$i+3];?></h4>
												<h5><?=$showannouncer[$i+3];?></h5>
											</div>
										</div>
									<?php
									}
									
									if(isset($idannouncer[$i+4]))
									{
									?>
										<div class="col-sm-4">
											<div class="single-event">
												<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i+4];?>" alt="event-image" width="100px">
												<h4><?=$nmannouncer[$i+4];?></h4>
												<h5><?=$showannouncer[$i+4];?></h5>
											</div>
										</div>
									<?php
									}
									
									if(isset($idannouncer[$i+5]))
									{
									?>
										<div class="col-sm-4">
											<div class="single-event">
												<img class="img-responsive" src="<?php echo base_url();?>assets/images/event/<?=$picannouncer[$i+5];?>" alt="event-image" width="100px">
												<h4><?=$nmannouncer[$i+5];?></h4>
												<h5><?=$showannouncer[$i+5];?></h5>
											</div>
										</div>
									<?php
									}
									
									$i=$i+5;
									?>
								</div>
							</div>
							<?php
							}
							?>
						
						
						</div>
					</div>
				</div>
					-->
					
					
                    <div class="block">
					
						<!-- 
						retrieve data 
					-->
					<?php

					// from Product Category 
					foreach($programs ->result() as $row)
					{
						$idprograms[]=$row->id;
						$nmprograms[]=$row->days;
						$fromprograms[]=$row->froms;
						$toprograms[]=$row->tos;
						$titleprograms[]=$row->title;
						$summaryprograms[]=$row->summary;
						$nmprograms[]=$row->nm;
						$picprograms[]=$row->pic;
						$picnmprograms[]=$row->ava;
					}
					?>	
                        <h1 class="heading">Our Program</h1>
                        <ul>
						
						<?php
						$isleft=0;
						if(isset($idprograms))
							for($i=0;$i<count($idprograms);$i++)
							{
								if($isleft>4)
									$isleft=0;
								
								if($isleft<2)
								{
								?>				
								
									<li class="wow fadeInLeft " data-wow-duration="300ms" data-wow-delay="300ms">
										<div class="blog-img">
											<a href="<?php echo base_url();?>assets/images/program/<?= $picprograms[$i];?>" rel="prettyPhoto[gallery]"  title="<?= $summaryprograms[$i];?>">
											<img src="<?= base_url();?>assets/images/program/<?= $picprograms[$i];?>" alt="<?= $titleprograms[$i];?>" > 
											</a>	
										 </div>
											
										<div class="content-right">
											<h3><?= $titleprograms[$i];?></h3>
											<p><?= $summaryprograms[$i];?></p>
										</div>
									</li>
								<?php
								$isleft++;
								}
								else								
								if($isleft<5)
								{
								?>
									<li class="wow fadeInLeft" data-wow-duration="300ms" data-wow-delay="500ms">
										<div class="content-left">
											<h3><?= $titleprograms[$i];?></h3>
											<p><?= $summaryprograms[$i];?></p>
										</div>
										<div class="blog-img-2">
											<a href="<?php echo base_url();?>assets/images/program/<?= $picprograms[$i];?>" rel="prettyPhoto[gallery]"  title="<?= $summaryprograms[$i];?>">
											<img src="<?= base_url();?>assets/images/program/<?= $picprograms[$i];?>" alt="<?= $titleprograms[$i];?>" > 
											</a>	
										 </div>
									</li>
								<?php
								
								$isleft++;
								}
							}
							?>
						
							
                        </ul>
                    </div>
               
				
				</div>			
			</div>		
		</div>
	</section><!--/#event-->
	<!-- events -->

	<section id="twitter">
		<div id="twitter-feed" class="carousel slide" data-interval="3000">
			<div class="twit">
				<img class="img-responsive" src="<?php echo base_url();?>assets/images/twit.png" alt="twit">
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="text-center carousel-inner center-block">
					
						<!-- 
						retrieve data 
					-->
					<?php

					// from Product Category 
					foreach($mitra ->result() as $row)
					{
						$idmitra[]=$row->id_mitra;
						$datemitra[]=$row->date_mitra;
						$tweetmitra[]=$row->tweet_mitra;
						$nmmitra[]=$row->nm_mitra;
						$linkmitra[]=$row->link_mitra;
						$picmitra[]=$row->pic_mitra;
					}
					?>	
					
					
						<?php
						
						$isactive="active";
						if(isset($idmitra))
						for($i=0;$i<count($idmitra);$i++)
						{
						?>		
						<div class="item <?= $isactive;?>">
							<img src="<?php echo base_url();?>assets/images/mitra/<?= $picmitra[$i];?>" alt="">
							<p><?= $tweetmitra[$i];?> </p>
							<a href="<?= $linkmitra[$i];?>"><?= $linkmitra[$i];?> <?= $datemitra[$i];?></a>
						</div>
						<?php
						$isactive="";
						}
						?>
					</div>
					<a class="twitter-control-left" href="<?php echo base_url();?>assets/#twitter-feed" data-slide="prev"><i class="fa fa-angle-left"></i></a>
					<a class="twitter-control-right" href="<?php echo base_url();?>assets/#twitter-feed" data-slide="next"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		</div>		
	</section><!--/#twitter-feed-->			

			
	<section id="charts">
	
	<?php
	foreach($charts ->result() as $row)
	{
		$idcharts[]=$row->id;
		$datecharts[]=$row->date;
		$rankcharts[]=$row->rank;
		$singercharts[]=$row->singer;
		$titlecharts[]=$row->title;
		$albumcharts[]=$row->album;
		$lastcharts[]=$row->last;
		$weekcharts[]=$row->week;
	}
	?>
		<div class="container">
			<div class="row">
				<div class="watch">
					<img class="img-responsive" src="<?= base_url();?>assets/images/watch.png" alt="">
				</div>				
				<div class="col-md-12 ">
					<hr>
					<h2>Chart</h2>
					
					<hr>
					<table class="table table-condensed table-bordered" id="tbchart">
				
							<tr>
								<th>Tingkat</th>
								<th>Penyanyi</th>
								<th>Judul</th>
								<th>Album</th>
								<th>Minggu lalu</th>
								<th>Week on chart</th>
							</tr>
						<?php
						
						if(isset($idcharts))
						for($i=0;$i<count($idcharts);$i++)
						{
						?>		
						
							<tr>
								<td><?= $rankcharts[$i];?></td>
								<td><?= $singercharts[$i];?></td>
								<td><?= $titlecharts[$i];?></td>
								<td><?= $albumcharts[$i];?></td>
								<td><?= $lastcharts[$i];?></td>
								<td><?= $weekcharts[$i];?></td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>	
			</div>
		</div>
	</section><!--/#explore-->
			
	<?php
	if(isset($idevents))
	for($i=0;$i<count($idevents);$i++)
	{
	?>	
	
	<section id="about">
	<?php
	if($i%2==0)
	{
	?>
	
		<div class="guitar2" 
			style="background-image: url('<?php echo base_url();?>assets/images/picNews/<?= $picevents[$i];?>');background-size: cover">				
			&nbsp;
		</div>
		
		<div class="about-content">					
					<h2><?= $titleevents[$i];?></h2>
					<p><?= $contevents[$i];?></p>
					<a href="<?php echo site_url();?>Blog/det/<?= $idevents[$i];?>"  target="_blank" class="btn btn-primary">Baca selengkapnya... <i class="fa fa-angle-right"></i></a>				
		</div>	
	<?php	
	}
	else
	{
	?>
	
		<div class="about-content">					
					<h2><?= $titleevents[$i];?></h2>
					<p><?= $contevents[$i];?></p>
					<a href="<?php echo site_url();?>Blog/det/<?= $idevents[$i];?>"  target="_blank" class="btn btn-primary">Baca selengkapnya... <i class="fa fa-angle-right"></i></a>				
		</div>	
		
		<div class="guitar2" 
			style="background-image: url('<?php echo base_url();?>assets/images/picNews/<?= $picevents[$i];?>');background-size: cover">				
			&nbsp;
		</div>
	<?php
	}
	?>	
	</section><!--/#about-->		
	<?php
	}
	?>
	
	
	<section id="about">
	
		<div class="all-events text-center">			
			<a href="<?php echo site_url();?>Blog"  target="_blank" class="btn btn-primary btn-lg">Lihat semua artikel kami <i class="fa fa-angle-right"></i></a>
		</div>		
	</section><!--/#about-->
	<!-- end events -->
	
	
	<section id="sponsor">
	
		<!-- 
		retrieve data 
	-->
	<?php

	// from Product Category 
	foreach($sponsor ->result() as $row)
	{
		$idsponsor[]=$row->id_sponsor;
		$stsponsor[]=$row->st_sponsor;
		$etsponsor[]=$row->et_sponsor;
		$nmsponsor[]=$row->nm_sponsor;
		$linksponsor[]=$row->link_sponsor;
		$picsponsor[]=$row->pic_sponsor;
	}
	?>	
		<div id="sponsor-carousel" class="carousel slide" data-interval="3000">
			<div class="container">
				<div class="row">
					<div class="col-sm-10">
						<h2>Sponsors</h2>			
						<a class="sponsor-control-left" href="<?php echo base_url();?>assets/#sponsor-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="sponsor-control-right" href="<?php echo base_url();?>assets/#sponsor-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner">
						
						<?php
						
						$isactive="active";
						if(isset($idsponsor))
						for($i=0;$i<count($idsponsor);$i++)
						{
						?>							
							<div class="item <?= $isactive;?>">
								<ul>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i];?>" alt=""></a></li>
								<?php
								if(isset($idsponsor[$i+1]))
								{
								?>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i+1];?>" alt=""></a></li>
								<?php
								}	
								else
									echo "<li>&nbsp;</li>";
								if(isset($idsponsor[$i+2]))
								{
								?>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i+2];?>" alt=""></a></li>
								<?php
								}	
								else
									echo "<li>&nbsp;</li>";
								
								if(isset($idsponsor[$i+3]))
								{
								?>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i+3];?>" alt=""></a></li>
								<?php
								}	
								else
									echo "<li>&nbsp;</li>";
								
								if(isset($idsponsor[$i+4]))
								{
								?>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i+4];?>" alt=""></a></li>
								<?php
								}	
								else
									echo "<li>&nbsp;</li>";
								
								if(isset($idsponsor[$i+5]))
								{
								?>
									<li class="vertical-align"><a href="<?php echo base_url();?>assets/#"><img class="img-responsive center-block" src="<?php echo base_url();?>assets/images/sponsor/<?= $picsponsor[$i+5];?>" alt=""></a></li>
									
								<?php
								}	
								else
									echo "<li>&nbsp;</li>";
								
								?>
								</ul>
							</div>
						<?php
						$i+=5;
						$isactive="";
						}
						?>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</section><!--/#sponsor-->

	<section id="contact">
		<div id="map">
			<div id="gmap-wrap">
	 			<div id="gmap"> 				
	 			</div>	 			
	    	</div>
		</div><!--/#map-->
		<div class="contact-section">
			<div class="ear-piece">
				<img class="img-responsive" src="<?php echo base_url();?>assets/images/ear-piece.png" alt="">
			</div>
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-3">
						<div class="contact-text">
							<h3>Contact</h3>
							<address>
								E-mail		: 	<?= $dbset[7];?><br>
								Phone		: 	<?= $dbset[6];?><br>
								Twitter		: 	<a href="http:\\twitter.com\<?= $dbset[8];?>"><?= $dbset[8];?></a><br>
								Facebook	: 	<a href="http:\\facebook.com\<?= $dbset[9];?>"><br>
								Intsagram	: 	<a href="http:\\twitter.com\<?= $dbset[9];?>"><br>
							</address>
						</div>
						<div class="contact-address">
							<h3>Address</h3>
							<address>
								<?= $dbset[5];?>
							</address>
						</div>
					</div>
					<div class="col-sm-5">
						<div id="contact-section">
							<h3>Send a message</h3>
					    	<div class="status alert alert-success" style="display: none"></div>
					    	<form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="<?= site_url()?>Sendemail">
					            <div class="form-group">
					                <input type="text" name="name" class="form-control" required="required" placeholder="Name">
					            </div>
					            <div class="form-group">
					                <input type="email" name="email" class="form-control" required="required" placeholder="Email ID">
					            </div>
					            <div class="form-group">
					                <textarea name="message" id="message" required="required" class="form-control" rows="4" placeholder="Enter your message"></textarea>
					            </div>                        
					            <div class="form-group">
					                <button type="submit" class="btn btn-primary pull-right">Send</button>
					            </div>
					        </form>	       
					    </div>
					</div>
				</div>
			</div>
		</div>		
	</section>
    <!--/#contact-->

    <footer id="footer">
        <div class="container">
            <div class="text-center">
                <p>  &copy;2016<a target="_blank" href="#"> Suara Akbar </a> <br> Designed by <a target="_blank" href="#">Eight House</a></p>                
            </div>
        </div>
    </footer>
    <!--/#footer-->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  	<script type="text/javascript" src="<?php echo base_url();?>assets/js/gmaps.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/smoothscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.parallax.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/coundown-timer.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.nav.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/main.js"></script>  
	
	<script src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	
	<script src="<?php echo base_url();?>assets/js/jquery.slicknav.js"></script>
    <script src="<?= base_url();?>assets/js/wow.min.js"></script>
	
	<script type="text/javascript" charset="utf-8">

		jQuery(document).ready(function(){
			jQuery("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'dark_square',slideshow:5000, autoplay_slideshow: true, social_tools: ''});
			
		});
	</script>
</body>
</html>