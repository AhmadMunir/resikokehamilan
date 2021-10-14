<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
		if(!isset($this->session->userdata['name']))		
			redirect("login","refresh");
	}
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	public function index()
	{
		//load view
		if(isset($this->session->userdata['name']))
		{	
			$this->fn->getheader();
			
			$this->fn->getBerandaperawat();
			$this->fn->getfooter();
		}
		else
			redirect("login","refresh");
	}
	
	public function grafik()
	{	
		
		$this->load->database();
		$this->load->model('Mmain');
		$render=$this->Mmain->qRead("tb_viewcount GROUP BY SUBSTR(datetime_viewcount,1,10) ","SUBSTR(datetime_viewcount,1,10) as f1,count(page_viewcount) as tot","");
		$val="";
		foreach($render->result() as $row)
		{
			$val.=$row->f1."||".$row->tot."++";
		}
		echo $val;
		
	}
	//============================================================= General Transaction ===========================================================

			
}
