<?php
class mMain  extends CI_Model  {

	// ++++++++++++++++++++++++++++++++++++++++ variable declaration

	function __construct()
    {
        parent::__construct();
    }

	
	function autoid($tbl0,$pk0,$defid,$defval,$defno) //tbl0=table name, pk0=flag pk, defid=
	{
		if(isset($defno) && strlen($defno)>0)
			$no=substr($defval,0,strlen($defval)-strlen($defno));
		else
			$no="";

		$id1=0;
		$query=$this->db->query("SELECT $pk0 FROM $tbl0 where $pk0 like '".$defid."%' order by $pk0 desc LIMIT 1 ");
		if($query->num_rows() > 0)
		{	
			foreach($query->result() as $row)
			{ 
				$tempurut=$row->$pk0;
			}
			$pj=strlen($defval)-strlen($no);
			$no1=substr($tempurut,strlen($no),strlen($defno))+1;
			$id1=$no.sprintf("%0".$pj."s",$no1);
		} 
		else 
		{
			$id1=$defval;
		}	

		return $id1;
	}
	
	function getid($fval,$ftb,$fid) //fval = flag value, 
	{
		return self::qRead($ftb,"","$fid='".$fval."'");	
		
	}

	// ++++++++++++++++++++++++++++++++++++++++++ retrieve column name
	function qCol($tbq)
	{
	$fieldArr=null;
	$fields = $this->db->list_fields($tbq);

	foreach ($fields as $field)
	{
	   $fieldArr[]=$field;
	}
		return $fieldArr;
	}
	

	// ++++++++++++++++++++++++++++++++++++++++++ Create insert query
	function qIns($tbq,$valq) 
	{
	
		$tes=self::qCol($tbq);		
		$i=0;
		foreach($tes as $row)
		{
			$savVal[$row]=$valq[$i];
			$i++;
		}			
		
		//echo implode(" ",$savVal);
		$this->db->insert($tbq, $savVal);
	}
	
	
	// ++++++++++++++++++++++++++++++++++++++++++ Create delete query

	function qDel($tbq,$idq,$valq) //Delete query declaration
	{
		$this->db->where($idq,$valq);
		$this->db->delete($tbq);
	}

	// ++++++++++++++++++++++++++++++++++++++++++ Create Update query
	function qUpd($tbq,$idq,$idflag,$valq) 
	{		
		$tes=self::qCol($tbq);		
		$i=0;
		foreach($tes as $row)
		{
			$savVal[$row]=$valq[$i];
			$i++;
		}	

		$this->db->where($idq, $idflag);
		$this->db->update($tbq, $savVal);
	}
	
	// ++++++++++++++++++++++++++++++++++++++++++ Create Update query
	function qUpdpart($tbq,$idq,$idflag,$valid,$valq) 
	{		
		//echo implode(" ",$valid);
		$i=0;
		foreach($valid as $row)
		{
			$savVal[$row]=$valq[$i];
			$i++;
			//echo $savVal[$row];
		}	
		
		$this->db->where($idq, $idflag);
		$this->db->update($tbq, $savVal);
	}

	// ++++++++++++++++++++++++++++++++++++++++++ Create read query
	function qRead($tbq,$sel,$valflag)
	{

		if($sel=="")
			$sel="*";


		if(strlen($valflag)>0)		
			$valflag="where ".$valflag;		
	
			$sqlq=sprintf("select %s from %s %s",$sel,$tbq,$valflag);

						
			$query=$this->db->query($sqlq);
				return $query;
		
	}
}
?>