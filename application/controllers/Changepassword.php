<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends CI_Controller 
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
	
	
	//update record
	public function Change($newpwd)
	{
		$oldPwd=$this->session->userdata['txt_pwdold'];
		$newPwd=$this->session->userdata['txt_pwdnew'];
		//retrieve values
		
		//set new password
		$options = [
			'cost' => 11,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		
		$savValTemp[2]=password_hash("$savValTemp[2]", PASSWORD_BCRYPT, $options);
		
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qUpdpart("tb_user","code_user",$id,Array("pwd_user"),Array($newpwd));
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}	
	

}

?>