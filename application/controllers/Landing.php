<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
	}
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	public function index()
	{
		//load view
		$this->load->view("Viewheader");
		$this->load->view("home");	
		$this->load->view("Viewfooter");	
			
	}
	
	
	//============================================================= General Transaction ===========================================================

			
}
