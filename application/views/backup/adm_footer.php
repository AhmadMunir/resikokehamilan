     
        </div>
        <!-- /#page-wrapper -->
	 </div>
  
  <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/morrisjs/morris.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/js/sb-admin-2.js"></script>

	  <script>
    // tooltip demo
    $('#page-wrapper').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
        .popover()
		
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
		$("#wrapper").toggleClass("toggled");
    });
    </script>
</body>

</html>