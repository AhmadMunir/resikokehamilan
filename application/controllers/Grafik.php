<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller 
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
	
	var $viewLink="Sms";
	var $breadcrumbTitle="Sms";
	var $viewPage="Admviewpage";
	var $addPage="Admaddpage";
	
	
	
	//save
	var $saveFormTitle="Kirim SMS";
	var $saveFormTableHeader=array("Tujuan","Pesan");
	
	/*	
		========================================================== General Function =========================================================
	*/
	

	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		
		//init view
		$output['pageTitle']=$this->saveFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/save";
		$output['tableHeader']=$this->saveFormTableHeader;
		$output['formLabel']=$this->saveFormTableHeader;
		
		for($i=0;$i<count($this->saveFormTableHeader);$i++)
		{
			$txtVal[]="";
		}	
		
		//generate id
		
		$cbostat=$this->fn->createCbo(array(0),array("Waiting Approval"),"");
		
		$output['formTxt']=array(
								"<input type='text' class='form-control' id='txtid2' name=txt[] required>",
								"<textarea class='form-control' id='txtid2' name=txt[] required></textarea>"
								);
		
		
		//render view
		$this->fn->getheader();
		$this->load->view($this->addPage,$output);
		$this->fn->getfooter();
	}	
	
	public function save()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		//echo implode("<br>",$savValTemp);
		//save to database
		//$this->load->database('dbsms',true);
		$this->load->model('Msms');
		$this->Msms->sendSms("sms",$savValTemp);
		//exec('c:\gammu\bin\gammu-smsd-inject.exe -c c:\gammu\bin\smsdrc TEXT '.$savValTemp[0].' -text "'.$savValTemp[1].'"');
		//redirect to form
		redirect("Sms",'refresh');		
	}
	
}

?>