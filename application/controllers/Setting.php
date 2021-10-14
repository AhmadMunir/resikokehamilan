<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller 
{
	public function __construct()
	 {
		parent::__construct();			
		$this->load->library('Commonfunction','','fn');
		
	 }
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	var $mainTable="tb_setting";
	var $mainPk="profile_id";
	var $viewLink="Setting";
	var $breadcrumbTitle="Website Profile";
	var $viewPage="Admviewpage";
	var $addPage="Admaddpage";
	
	//query
	var $tableQuery="tb_setting";
	var $fieldQuery="profile_id,website_name,website_title,website_address,website_phone,website_email,profile_status as st"; //leave blank to show all field
	var $primaryKey="profile_id";
	var $updateKey="profile_id";
	
	//auto generate id
	var $defaultId="WP01";
	var $prefix="WP";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Website Profiles";
	var $viewFormTableHeader=array("Profile","Profile Name","Title","Address","Phone","E-mail","Status");
	
	//save
	var $saveFormTitle="Add New Profile";
	var $saveFormTableHeader=array("Profile","Profile Name","Title","Icon","Logo","Address","Phone","E-mail","Twitter","Facebook","Linkedin","Google Plus","Instagram","Status");
	
	//update
	var $editFormTitle="Update Profile";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
			//check user access	
		$isAll = $this->Mmain->qRead(
										"tb_accfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.id_acc ='".$this->session->userdata['accUser']."' AND b.id_frm='".$this->viewLink."'",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","");
	
		foreach($isAll ->result() as $row)
		{
			$access=$row;
		}
		
		//$output['isall']=$access->isadd;
		$accessQuery="";
		if($access->acc1<>1)
			$accessQuery="WHERE b.code_user ='".$this->session->userdata['codeUser']."'";
			
			
		
		//init view
		$output['formAccess']=$access;
		
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery,"");
		foreach($renderTemp->result() as $row)
		{
			//$row->pic="<img src='".base_url()."/assets/images/picNews/".$row->pic."' height='100px' width='auto' class='center-block'>";
			if($row->st==0)
			{
				if($access->acc1==1)
				{
					$row->st="<a href='".site_url()."/Setting/Activate/".$row->profile_id."'><span class='label label-primary'>Activate</span></a>";	
				}
				else
				{
					$row->st="<span class='label label-default'>Inactive</span>";		
				}
					
				
			
			}	
			else
			{
				$row->st="<span class='label label-success'>Active</span>";			
							
			}
		}
		$output['render']=$renderTemp;
		
		//init view
		$output['pageTitle']=$this->viewFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
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
		
		$pid="";
		if(!empty($isEdit))
		{
			$pid=$isEdit;
			$output['pageTitle']=$this->editFormTitle;
			$output['saveLink']=$this->viewLink."/update";			
		}
		else
		{			
			$pid="WP01";	
		}
			
		$render=$this->Mmain->qRead($this->tableQuery,""," ".$this->updateKey." = '".$pid."'");
		foreach($render->result() as $row)
		{
			foreach($row as $col)
			{
				$txtVal[]= $col;
			}
		}
		
			
		if(empty($isEdit))
		{
			//generate id
			$newId=$this->Mmain->autoId($this->mainTable,$this->mainPk,$this->prefix,$this->defaultId,$this->suffix);	
			$txtVal[0]=$newId;		
		}	
				$cbostat=$this->fn->createCbo(array(0),array("Inactive"),"");
		
		
		$output['formTxt']=array(
								"<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[1]."' required>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[2]."' >",
								"<input type='file' class='form-control fileupload' id='txtid' name=txtIcon value='".$txtVal[3]."' >",
								"<input type='file' class='form-control fileupload' id='txtid4' name=txtLogo value='".$txtVal[4]."' >",
								"<textarea class='form-control' id='txtid5' name=txt[]>".$txtVal[5]."</textarea >",
								"<input type='text' class='form-control' id='txtid6' name=txt[] value='".$txtVal[6]."' >",
								"<input type='text' class='form-control' id='txtid7' name=txt[] value='".$txtVal[7]."' >",
								"<input type='text' class='form-control' id='txtid8' name=txt[] value='".$txtVal[8]."' >",
								"<input type='text' class='form-control' id='txtid9' name=txt[] value='".$txtVal[9]."' >",
								"<input type='text' class='form-control' id='txtid10' name=txt[] value='".$txtVal[10]."' >",
								"<input type='text' class='form-control' id='txtid11' name=txt[] value='".$txtVal[11]."' >",
								"<input type='text' class='form-control' id='txtid12' name=txt[] value='".$txtVal[12]."' >",
								$cbostat
								);
		
		
		
		//render view
		$this->fn->getheader();
		$this->load->view($this->addPage,$output);
		$this->fn->getfooter();
	}	
	
	public function save()
	{
		//retrieve values
		$inpTemp=$this->input->post('txt');
		
		//icon & logo
		
		$icoImg="mio_ver2.ico";
		$logoImg="logo";	
		
		//icon
		if(!empty($_FILES['txtIcon']))
		{
			$flName=$_FILES['txtIcon']['name'];
			$flTmp=$_FILES['txtIcon']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/".$flName);
			$icoImg=$flName;
		}
		
		//logo
		if(!empty($_FILES['txtLogo']))
		{
			$flName=$_FILES['txtLogo']['name'];
			$flTmp=$_FILES['txtLogo']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/".$flName);
			$icoImg=$flName;
		}
		
		
		//echo implode("<br>",$inpTemp);
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$savValTemp=Array(
							$inpTemp[0],
							$inpTemp[1],
							$inpTemp[2],
							"mio_ver2.ico",
							"logo.png",
							$inpTemp[3],
							$inpTemp[4],
							$inpTemp[5],
							$inpTemp[6],
							$inpTemp[7],
							$inpTemp[8],
							$inpTemp[9],
							$inpTemp[10],
							$inpTemp[11],
							$inpTemp[44]
		);
		
		//echo implode("<br>",$savValTemp);
		
		//echo count($savValTemp);
		$this->Mmain->qIns($this->mainTable,$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//delete record
	public function delete($valId)
	{		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qDel($this->mainTable,$this->primaryKey,$valId);
		
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
		$this->Mmain->qUpd($this->mainTable,$this->primaryKey,$savValTemp[0],$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}

	//update record
	public function activate($id)
	{
		//retrieve values
		
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qUpdpart($this->mainTable,"substr(profile_id,1,2)","WP",Array("profile_status"),Array(0));
		$this->Mmain->qUpdpart($this->mainTable,$this->primaryKey,$id,Array("profile_status"),Array(1));
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}	
	
}

?>