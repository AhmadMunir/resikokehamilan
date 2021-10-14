<?php
class Msms extends CI_Model  {

	// ++++++++++++++++++++++++++++++++++++++++ variable declaration


	// ++++++++++++++++++++++++++++++++++++++++++ Create insert query
	function sendSms($dbq,$valq) 
	{
		
		$i=0;
		$col=Array("DestinationNumber", "TextDecoded", "CreatorID");
		$valq[]="Gammu";
		foreach($col as $row)
		{
			$savVal[$row]=$valq[$i];
			$i++;
		}			
		
		$otherdb = $this->load->database($dbq, TRUE);
		//echo implode("<br>",$savVal);
		$otherdb->insert("outbox", $savVal);
	}
	
	
}
?>