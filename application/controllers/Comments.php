<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller 
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
	
	var $mainTable="tb_Comment";
	var $mainPk="id_Comment";
	var $viewLink="Comments";
	var $breadcrumbTitle="Comments";
	var $viewPage="Admviewpage";
	var $addPage="Admaddpage";
	
	//query
	var $ordQuery=" ORDER BY id ";
	var $tableQuery="
						tb_comment AS a INNER JOIN 
						tb_events AS b ON a.id_events = b.id_events";
	var $fieldQuery=" 
						a.id_comment as id,
						b.title_events as tit,
						a.date_comment as date,
						a.time_comment as time,
						a.nm_comment as nm,
						a.content_comment as content,
						a.email_comment as email,
						a.stat_comment as st
						";
	var $primaryKey="id";
	var $updateKey="a.id_comment";
	
	//auto generate id
	var $defaultId="C0001";
	var $prefix="C";
	var $suffix="0001";	
	
	//view
	var $viewFormTitle="Comments List";
	var $viewFormTableHeader=array("Comments Id","Event Title","Date","Time","Author","Content","E-Mail","Status");
	
	//save
	var $saveFormTitle="Add Comment";
	var $saveFormTableHeader=array("Comments Id","Event Id","Event Title","Date","Time","Author","Content","E-Mail","Status");
	
	//update
	var $editFormTitle="Edit Comment";
	
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
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		foreach($renderTemp->result() as $row)
		{
			if($row->st==0)
			{				
				if($access->acc1<>1)
				{
					$row->st="<span class='label label-primary'>Waiting for Approval</span>";	
				}
				else
				{
					$row->st="<a href='".site_url()."/Comments/Publish/".$row->id."' title='Publish Comment'><button class='btn btn-circle btn-primary '><i class='fa fa-check'></i></button></a>";	
					$row->st.="&nbsp;<a href='".site_url()."/Comments/Reject/".$row->id."' title='Reject Comment'><button class='btn btn-danger '><i class='fa fa-times'></i></button></a>";						
				}
			
			}				
			elseif($row->st==1)
			{
				$row->st="<span class='label label-success'>Published</span>";	
			}			
			elseif($row->st==2)
			{
				$row->st="<span class='label label-danger'>Rejected</span>";	
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
		if(!empty($isEdit))
		{
			
			$output['pageTitle']=$this->editFormTitle;
			$output['saveLink']=$this->viewLink."/update";
			$pid=$isEdit;
			$this->fieldQuery=" 
								a.id_comment as id,
								a.id_events as events,
								b.title_events as tit,
								a.date_comment as date,
								a.time_comment as time,
								a.nm_comment as nm,
								a.content_comment as content,
								a.email_comment as email,
								CASE 
									WHEN a.stat_comment=0 THEN 'Waiting Approval' 
									WHEN a.stat_comment=1 THEN 'Approved' 
									WHEN a.stat_comment=2 THEN 'Rejected'
								END
									as st";
			$render=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery," ".$this->updateKey." = '".$pid."'");
			foreach($render->result() as $row)
			{
				foreach($row as $col)
				{
					$txtVal[]= $col;
				}
			}
			
				$cbostat=$this->fn->createCbo(array(0,1,2),array("Waiting Approval","Approved","Rejected"),$txtVal[7],"Readonly");
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
				
				$cbostat=$this->fn->createCbo(array(0),array("Waiting Approval"),"");
		}
		$output['formTxt']=array(
								"<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[1]."'  readonly>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[2]."' required>",
								"<input type='text' class='form-control' id='txtid3' name=txt[] value='".$txtVal[3]."'  readonly>",
								"<input type='text' class='form-control' id='txtid3' name=txt[] value='".$txtVal[4]."'  readonly>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[5]."' required>",
								"<textarea name='txt[]' class='form-control summernote'>".$txtVal[6]."</textarea>",
								"<input type='email' class='form-control' id='txtid2' name=txt[] value='".$txtVal[7]."' required>",
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
		$savValTemp=$this->input->post('txt');
		$savVal=Array(
						$savValTemp[0],
						$savValTemp[1],
						$savValTemp[3],
						$savValTemp[4],
						$savValTemp[5],
						$savValTemp[6],
						$savValTemp[7],
						$savValTemp[8]
						);
		//echo implode("<br>",$savValTemp);
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qIns($this->mainTable,$savVal);
		
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
		$savVal=Array(
						$savValTemp[0],
						$savValTemp[1],
						$savValTemp[3],
						$savValTemp[4],
						$savValTemp[5],
						$savValTemp[6],
						$savValTemp[7],
						$savValTemp[8]
						);
		//echo implode("<br>",$savValTemp);
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qUpd($this->mainTable,$this->mainPk,$savVal[0],$savVal);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}

	
	//update record
	public function Publish($id)
	{
		//retrieve values
		
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qUpdpart($this->mainTable,$this->mainPk,$id,Array("stat_comment"),Array(1));
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}	
	
	
	//update record
	public function Reject($id)
	{
		//retrieve values
		
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qUpdpart($this->mainTable,$this->mainPk,$id,Array("stat_comment"),Array(2));
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}	
}

?>