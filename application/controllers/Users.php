<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller 
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
	
	var $mainTable="tb_user";
	var $mainPk="code_user";
	var $viewLink="Users";
	var $viewLink2="Users";
	var $breadcrumbTitle="Users";
	var $breadcrumbTitle2="User Access";
	var $viewPage="Admviewpage3";
	var $addPage="Admaddpage";
	var $detPage="Formdetpage";
	
	//query
	var $ordQuery=" ORDER BY code_user ";
	var $tableQuery="
						tb_user
						";
	var $fieldQuery="ava_user,code_user,nm_user,id_acc"; //leave blank to show all field
						
	var $primaryKey="code_user";
	var $updateKey="code_user";
	
	//auto generate id
	var $defaultId="USR00001";
	var $prefix="U";
	var $suffix="00001";	
	
	//view
	var $viewFormTitle="Form List";
	var $viewFormTableHeader=array(
									"Avatar",
									"User Code",
									"Name",
									"Access");
	
	//save
	var $saveFormTitle="Add New User";
	var $saveFormTableHeader=array(
									"User Code",
									"User Name",
									"Password",
									"Access",
									"Avatar"
									);
	
	//update
	var $editFormTitle="Edit User Data";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
			
		
		//init view
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		foreach($renderTemp->result() as $row)
		{
			$row->ava_user="<img src='".base_url()."/assets/admin/img/avatar/thumb/".$row->ava_user."' height='100px' width='auto' class='center-block'>";
			/*
			if($row->sex==1)
			{
				$row->sex="<span class='label label-primary'><i class='fa fa-mars'></i>&nbsp; Male</span>";	
			}	
			
			if($row->pinned==0)
			{
				
					$row->pinned="<span class='label label-success'>Pinned</span>";		
				
			}	
			else
			{
					$row->pinned="<span class='label label-default'>Not Pinned</span>";		
				
			}		
*/			
			
		}
		$output['render']=$renderTemp;
		//init view
		$output['pageTitle']=$this->viewFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['detLink']=$this->viewLink."/det";
		$output['saveLink']=$this->viewLink."/add";
		$output['deleteLink']=$this->viewLink."/delete";
		$output['primaryKey']=$this->primaryKey;
		$output['tableHeader']=$this->viewFormTableHeader;
		
		//render view
		$this->fn->getheader();
		$this->load->view($this->viewPage,$output);
		$this->fn->getfooter();
	}
	

	
	public function add($isEdit="")
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
		
		$imgTemp="";
		$codeTemp="";
		if(!empty($isEdit))
		{
			
			$output['pageTitle']=$this->editFormTitle;
			$output['saveLink']=$this->viewLink."/update";
			$pid=$isEdit;
			$this->fieldQuery="code_user,nm_user,pwd_user,ava_user,id_acc";
			$render=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery," code_user = '".$pid."'");
			foreach($render->result() as $row)
			{
				foreach($row as $col)
				{
					$txtVal[]= $col;
				}
			}
			
				
				//$cboloc=$this->fn->createCbofromDb("tb_loc","id_loc as id,nm_loc as nm","",$txtVal[6]);
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),$txtVal[8]);
					
				$imgTemp="<h5><i>Click browse to change image</i></h5>
							<img src='".base_url()."/assets/admin/img/avatar/thumb/".$txtVal[3]."' height='200px' width='auto' >
							<input type='hidden' name='txtimg' value='".$txtVal[3]."'>";
							$codeTemp="<input type='hidden' name='txtuser' value='".$txtVal[0]."'>";
		}
		else
		{	
				for($i=0;$i<count($this->saveFormTableHeader);$i++)
				{
					$txtVal[]="";
				}	
				
				//generate id
				$newId=$this->Mmain->autoId($this->mainTable,$this->mainPk,$this->prefix,$this->defaultId,$this->suffix);	
				$txtVal[0]=$newId;
				
			
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),"");
				//$cbostat=$this->fn->createCbo(array(1,0),array("Active","Inactive"),"");
		}
		$output['formTxt']=array(
								$codeTemp."<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[1]."' required>",
								"<input type='password' class='form-control' id='txtpass' name=txt[] value='".$txtVal[2]."' required>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[4]."' required>",
								$imgTemp."<input type='file' class='form-control fileupload' id='txtid23' name=txtfl >"
								);
		
		
		//load view
		$this->fn->getheader();
		$this->load->view($this->addPage,$output);
		$this->fn->getfooter();
	}	
	
	public function save()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$avauser="";
		if(!empty($_FILES['txtfl']['name']))
		{
			$flName=$_FILES['txtfl']['name'];
			$flTmp=$_FILES['txtfl']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/avatar/thumb/".$flName);
			$avauser=$flName;
		}
		else
		{
			$avauser="def.jpg";
		}
		
		
		//$savValTemp[0]=$this->Mmain->autoId($this->mainTable,$this->mainPk,$this->prefix,$this->defaultId,$this->suffix);	
		$savEmp=Array(
							$savValTemp[0],
							$savValTemp[1],
							$savValTemp[2],
							$avauser,
							$savValTemp[3]
							
							);
		
		//echo implode("<br>",$savEmp);
		$this->Mmain->qIns($this->mainTable,$savEmp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//delete record
	public function delete($valId)
	{		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qDel($this->mainTable,$this->mainPk,$valId);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//update record
	public function update()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$avauser="";
		if(!empty($_FILES['txtfl']['name']))
		{
			$flName=$_FILES['txtfl']['name'];
			$flTmp=$_FILES['txtfl']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/avatar/thumb/".$flName);
			$avauser=$flName;
		}
		else
		{
			$avauser=$this->input->post('txtimg');
		}
		
		$savheader=Array("code_user","nm_user","pwd_user","ava_user","id_acc");
		$savEmp=Array(
							$savValTemp[0],
							$savValTemp[1],
							$savValTemp[2],
							$avauser,
							$savValTemp[3]				
							);
							
		//echo implode("<br>",$savEmp);
		$this->Mmain->qUpdpart("tb_user","code_user",$savValTemp[0],$savheader,$savEmp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
}

?>