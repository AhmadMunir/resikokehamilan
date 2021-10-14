<?php
@session_start();
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
.login-block{
    background: #4834b2;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #7e66f7, #4834b2);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #7e66f7, #4834b2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
float:left;
width:100%;
padding : 50px 0;
}
.banner-sec{background:url(https)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 50px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
.login-sec .copy-text i{color:#FEB58A;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #4483e8;}
.login-sec h2:after{content:" "; width:100px; height:5px; background:#4483e8; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
.btn-login{background: #2369d7; color:#fff; font-weight:600;}
.btn-register{background: #2369d7; color:#fff; font-weight:600;}
.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
.banner-text h2{color:#000000; font-weight:600;}
.banner-text h2:after{content:" "; width:350px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px;}
.banner-text p{color:#000000;}
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">LOGIN</h2>
		    <form class="login-form" action="" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-uppercase">Username</label>
    <input type="text" class="form-control" name="user" placeholder="Username">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
    <input type="password" class="form-control" name="pass" placeholder="Passowrd">
  </div>
  
  <div class="row">
    <div class="col-lg-6">
      <input type="checkbox" class="form-checkbox">Tampilkan password
  </div>
  <div class="col-lg-3">
    <a class="btn btn-register float-right" href="register.php">Register</a>
  </div>
   <div class="col-lg-0">
    <input type="submit" name="login" value="login" class="btn btn-login float-right" />
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="col-md-7">
    <a href="index.php"><image src="img/home.png"></a>
  </div>
  </div>
</form>

<?php
      $user = @$_POST['user'];
      $pass = @$_POST['pass'];
      $login = @$_POST['login'];

      if($login){
      if($user == "" || $pass == "")
        {
        ?> <script type="text/javascript">alert("Username / password tidak boleh kosong");</script> <?php
        } else {
          $con = mysqli_connect("localhost" , "root" , "" , "nutrition");
          $sql = mysqli_query($con,"select * from tabel_login where username  = '$user' and password = md5('$pass')") or die (mysqli_error());
          $data = mysqli_fetch_array($sql);
          $cek = mysqli_num_rows($sql);
          if($cek >= 1){
           if($data['level'] == "admin"){
              @$_SESSION['admin'] = $data['kode_user'];
              header("location:indexadmin.php");
            } else if($data['level'] == "karyawan"){
              @$_SESSION['karyawan'] = $data['kode_user'];
              header("location:indexuser.php");
            }
          } else{
            echo "Login Gagal";
          }
        }
      }
    
      ?>


		</div>
		<div class="col-md-8 banner-sec">
			<div></div>
			<div></div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                 <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
            <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img class="d-block img-fluid" src="<?= site_url();?>login/logon/img/about1.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
  </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="<?= site_url();?>login/logonimg/bread.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="<?= site_url();?>login/logonimg/medical1.png" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
  </div>
            </div>	   
		    
		</div>
	</div>
</div>
</section>

</body>
<script type="text/javascript">
    $(document).ready(function(){
      $('.form-checkbox').click(function(){
        if($(this).is(':checked')){
          $('.form-control').attr('type','text');
        }else{
          $('.form-control').attr('type','password');
        }
      });
    });
  </script>
</html>
