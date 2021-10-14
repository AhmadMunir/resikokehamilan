<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
	}
	public function index()
	{
		
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		//$this->load->view('header',$output);
		
		redirect("Landing",'refresh');	
	}
		
}
