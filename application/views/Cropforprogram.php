<?php

//echo implode("<br>",$saveData);
$img=$saveData[8];
?>

<?php


// If not a POST request, display page below:

?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Live Cropping Demo</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="<?= base_url();?>assets/jcrop/js/jquery.min.js"></script>
  <script src="<?= base_url();?>assets/jcrop/js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="<?= base_url();?>assets/jcrop/demos/demo_files/main.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url();?>assets/jcrop/demos/demo_files/demos.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url();?>assets/jcrop/css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>

</head>
<body>

<div class="container">

<div class="page-header">
<h1>Crop Image</h1>
</div>

		<!-- This is the image we're attaching Jcrop to -->
		<img src="<?= base_url();?>assets/images/program/<?= $img;?>" id="cropbox" />
		<!-- This is the form that our event handler fills -->
		<form action="<?= site_url();?>Programs/Cropper" method="post" onsubmit="return checkCoords();">
		
		<input type="hidden"  name="img" value="<?= $img;?>" />
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>

	</div>
	</body>

</html>
