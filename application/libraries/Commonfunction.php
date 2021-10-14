<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commonfunction
{
	/*	
		====================================================== Variable Declaration =========================================================
	*/	
	protected $CI;
	var $frm;
	
    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
    
       $this->CI =& get_instance();
       $this->CI->load->helper('url');
       $this->CI->load->library('session');
       $this->CI->load->database();

    }

	public function checkAccess($codeUser,$idFrm)
	{
		//check user access	
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$isAll = $this->CI->Mmain->qRead(
										"tb_userfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.code_user ='".$codeUser."' AND b.id_frm='".$idFrm."'",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","");
	
		foreach($isAll ->result() as $row)
		{
			$access=$row;
		}
		return $access;
	}



	
	public function getheader()
	{	
	
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			//get website setting
												
			$output['ses']=$this->CI->session->all_userdata();
			$this->CI->load->view('adm_header');
		
		
	}
	

public function getBerandaperawat()
	
	{
		$this->CI->load->view('Berandaperawat');
	}
	
	
	public function getfooter()
	{	
	
		$this->CI->load->view('adm_footer');		
	}
	
	public function getFormGroup($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');		
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' ORDER BY b.nm_frmgroup ",
										"a.code_frm as code,a.id_frm as id,a.desc_frm as descs,b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr,a.is_shortcut as iss",
										"");
										
		return $qemp;
	}

	


	public function getFormGroupHeader($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');												
										
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' GROUP BY b.nm_frmgroup ORDER BY b.nm_frmgroup ",
										"b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr",
										"");
		return $qemp;
	}
	public function createCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$isdis="")
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		$cboemp="<select name=txt[] class='form-control' $isdis>";
		foreach($qemp->result() as $row)
		{
			$isdef="";
			if($row->nm==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	public function createCbo($cboid,$cboval,$cboDef,$isdis="")
	{
		//init modal
		$cboemp="<select name=txt[] class='form-control' $isdis>";
		for($i=0;$i<count($cboid);$i++)
		{
			$isdef="";
			if($cboval[$i]==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$cboid[$i]."' $isdef >".$cboval[$i]."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	


	public function createMulCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$nmdef="txt[]")
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select multiple name=$nmdef class='form-control'>";
			foreach($qemp->result() as $row)
			{
					$isdef="";
				if($row->nm==$cboDef)	
					$isdef="selected";
				$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}
	
	
	public function createCbofromDb2($cboTb,$cboSel,$cboWhere,$cboDef,$cboNm)
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select name=$cboNm class='form-control select2' multiple='multiple' data-placeholder='Select data'>";
			foreach($qemp->result() as $row)
			{
					$isdef="";
				if($row->nm==$cboDef)	
					$isdef="selected";
				$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}
		
	
	public function createRadio($cboid,$cboval,$count,$cboDef)
	{
			//init modal
			$cboemp=" 
                   ";
			for($i=0;$i<count($cboid);$i++)
			{
				$chk="";
				if($cboDef==$cboid[$i])
				$chk="checked"	;
				$cboemp.=" <label><input type='radio' name=txt[$count] class='flat-red' value='".$cboid[$i]."' $chk>&nbsp;$cboval[$i]</label>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function addViewCount($formName)
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$visitorIp=$_SERVER['REMOTE_ADDR'];
			$saveVal=Array(
							"",
							date("Y-m-d h:i:s"),
							$visitorIp,
							$formName
							);
			$this->CI->Mmain->qIns("tb_viewcount",$saveVal);
	}
}

?>