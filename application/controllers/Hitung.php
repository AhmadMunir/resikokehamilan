<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hitung extends CI_Controller 
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
	

	var $mainTable="tb_bumil";
	var $mainPk="id_bumil";
	var $viewLink="Hitung";
	var $breadcrumbTitle="Data Ibu Hamil";
	var $viewPage="Viewhitung";
	var $addPage="Admaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_bumil "; //pengurutan berdasarkan kolomnya//
	var $tableQuery="
						tb_bumil
						";
	var $fieldQuery="id_bumil,id_user,nama_bumil,usiabml,hamilke,hakhir,persal,pnddkn_bumil,pnddkn_suami,pkrj_bumil,pkrj_suami"; //leave blank to show all field atau kolom
						
	var $primaryKey="id";
	var $updateKey="id_bumil";
	
	//auto generate id
	var $defaultId="I001";
	var $prefix="I";
	var $suffix="001";	
	
	//view
	var $viewFormTitle="Data Ibu Hamil";
	var $viewFormTableHeader=array(
									"Id Ibu Hamil",
									"Id User",
									"Nama Ibu Hamil",
									"Usia Ibu Hamil",
									"Hamil ke",
									"Haid akhir",
									"Persalinan",
									"Pendidikan Ibu Hamil",
									"Pendidikan Suami",
									"Pekerjaan Ibu Hamil",
									"Pekerjaan Suami");
	
	//save
	var $saveFormTitle="Tambah Ibu Hamil";
	var $saveFormTableHeader=array(
									"Id Ibu Hamil",
									"Id User",
									"Nama Ibu Hamil",
									"Usia Ibu Hamil",
									"Hamil ke",
									"Haid akhir",
									"Persalinan",
									"Pendidikan Ibu Hamil",
									"Pendidikan Suami",
									"Pekerjaan Ibu Hamil",
									"Pekerjaan Suami");
	
	//update
	var $editFormTitle="Edit Data Ibu Hamil";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
			
		
		//init view
		$this->viewFormTableHeader=Array("Atribut","Value","Jumlah","Rendah","Tinggi","Sangat Tinggi","Entrophy","Gain");

		$chosenAttr = null;
		$chosenSub = null;
		$attachedSub = null;
		$maxSub = null;
		$endAttr = null;
		$endSub = null;
		$endQuery = null;
		$rute = null;

		$lastAttr = "";
		$lastSub = "";
		$lastGain = "";
		$hasilPerhitungan = "";
		$isRepeat = "true";
		$chosenQuery = null;

		$id=0;

		while($isRepeat == "true")
		//while($id < 45)
		{
		$atr = null;
		$sub = null;
		$atrjum = null;

		$tambahan = "";
		$tambahan2 = "";

		if($lastAttr <> "")
		{

			$subList = $this->Mmain->qRead(" tb_sub 
						WHERE id_atr = '".$lastAttr."'" .
						( is_array($chosenSub) ? "AND NOT id_sub in ('".implode("','",$chosenSub)."')   " : "" ) .

						" ORDER BY id_sub " ,"","");
			/*
			$hasilPerhitungan .= ($id+1) . " : Last atr : ".$lastAttr." 
				<br>Sub : ".( is_array($chosenSub) ? implode("','",$chosenSub) : "" )."
				<br>Query : ".( is_array($chosenQuery) ? implode("','",$chosenQuery) : "" )."
				<br>";
				*/
			if($subList->num_rows() > 0 )
			{

				$row = $subList->row();
				$chosenSub[] = $row->id_sub;
				$lastSub = $row->id_sub;
				$rute[] = Array("id_sub"=>$row->id_sub,"nm_sub"=>$row->nm_sub,"from"=>"","hasil"=>"");
				if($lastGain == 0)
				{
					array_pop($chosenQuery);
					//array_pop($rute);
					$chosenQuery[] = " AND ".$row->kol_sub." ".$row->op_sub." ";
				}
				else
				{
					$chosenQuery[] = " AND ".$row->kol_sub." ".$row->op_sub." ";
				}

				$tambahan2 =  implode(" ",$chosenQuery);
				
				$hasilPerhitungan .= ($id+1) . " : Last atr : ".$lastAttr." 
				<br>Sub : ".( is_array($chosenSub) ? implode("','",$chosenSub) : "" )."
				<br>Query : ".( is_array($chosenQuery) ? implode("','",$chosenQuery) : "" )."
				<br>";
				//$tambahan2 = "";
			//	$hasilPerhitungan .= "Last : atr (".$lastAttr."), sub (".$lastSub."), Current : atr = ".implode(",",$chosenAttr).", Query : ".$tambahan2."<br>";

			}
			else
			{
				$isRepeat= "false";
				$hasilPerhitungan .= " <br>Perhitungan Selesai";
			}

		}

		$this->tableQuery="
								tb_sub sb 
								INNER JOIN tb_atr at ON at.id_atr = sb.id_atr
								".$tambahan."
							";
		$this->fieldQuery="
								at.nama,
								sb.nm_sub,
								0 as jum_all,
								0 as jum_rendah,
								0 as jum_tinggi,
								0 as jum_sangat,
								0 as ent,
								0 as gain,
								sb.kol_sub,
								sb.op_sub,

								sb.id_sub as id,
								at.id_atr as idatr

							";
		$this->ordQuery="";
		$paramArr = Array("jum_rendah","jum_tinggi","jum_sangat");
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		$retVal = null;
		$jumAll = 0;
		$jumRendah = 0;
		$jumTinggi = 0;
		$jumSangat = 0;
		foreach($renderTemp->result() as $i=>$row)
		{
			//all
			$row->jum_all = $this->Mmain->qRead("
												tb_skrining
												WHERE ".$row->kol_sub." ".$row->op_sub."
												".$tambahan2."
											","id_skrining","")->num_rows();

			//rendah
			$row->jum_rendah = $this->Mmain->qRead("
												tb_skrining
												WHERE ".$row->kol_sub." ".$row->op_sub."
												AND statusres = 'rendah'
												".$tambahan2."
											","id_skrining","")->num_rows();
			//tinggi
			$row->jum_tinggi = $this->Mmain->qRead("
												tb_skrining
												WHERE ".$row->kol_sub." ".$row->op_sub."
												AND statusres = 'tinggi'
												".$tambahan2."
											","id_skrining","")->num_rows();
			//sangattinggi
			$row->jum_sangat = $this->Mmain->qRead("
												tb_skrining
												WHERE ".$row->kol_sub." ".$row->op_sub."
												AND statusres = 'sangat tinggi'
												".$tambahan2."
											","id_skrining","")->num_rows();

			//Entrophy
			foreach($paramArr as $p)
				$row->ent += $row->jum_all == 0 || $row->$p == 0 ? 0 : ( -1 * ( $row->$p / $row->jum_all ) ) * (log( $row->$p / $row->jum_all ,2) );

			//$row->ent = round($row->ent,3);
			$atr[$row->idatr] = 0;
			$sub[$row->idatr] = $row->id; 
			

		}

		$jumRendah = $this->Mmain->qRead("
												tb_skrining

												WHERE statusres = 'rendah'

												".$tambahan2."
											","id_skrining","")->num_rows();

		$jumTinggi= $this->Mmain->qRead("
												tb_skrining

												WHERE statusres = 'tinggi'

												".$tambahan2."
											","id_skrining","")->num_rows();

		$jumSangat = $this->Mmain->qRead("
												tb_skrining

												WHERE statusres = 'sangat tinggi'
												
												".$tambahan2."
											","id_skrining","")->num_rows();

		$jumAll = $jumRendah + $jumTinggi + $jumSangat;
		$entTotal = 0;
		$entTotal += $jumAll == 0 || $jumRendah == 0 ? 0 : ( -1 * ( $jumRendah / $jumAll ) ) * (log( $jumRendah / $jumAll ,2) );

		$entTotal += $jumAll == 0 || $jumTinggi == 0 ? 0 : ( -1 * ( $jumTinggi / $jumAll ) ) * (log( $jumTinggi / $jumAll ,2) );

		$entTotal += $jumAll == 0 || $jumSangat == 0 ? 0 : ( -1 * ( $jumSangat / $jumAll ) ) * (log( $jumSangat / $jumAll ,2) );

		$entTotal = $entTotal;

		$retVal[0][] = "Total";
		$retVal[0][] = "";
		$retVal[0][] = $jumAll;
		$retVal[0][] = $jumRendah;
		$retVal[0][] = $jumTinggi;
		$retVal[0][] = $jumSangat;
		$retVal[0][] = $entTotal;
		$retVal[0][] = 0;

		$retVal[0]["idatr"] = 0;
		$retVal[0]["nama"] = 0;

		$nmTempArr = Array("nama","nm_sub","jum_all","jum_rendah","jum_tinggi","jum_sangat","ent","gain");
		foreach($renderTemp->result() as $i => $row)
		{
			foreach($nmTempArr as $nmi)
				$retVal[$i+1][] = $row->$nmi;
			$retVal[$i+1]["idatr"] = $row->idatr;


			if( $jumAll > 0)
			$atrjum[$row->idatr]["val"] = isset($atrjum[$row->idatr]["val"]) ? $atrjum[$row->idatr]["val"] + ( $row->jum_all / $jumAll * $row->ent) : ( $row->jum_all / $jumAll * $row->ent);
			else
			$atrjum[$row->idatr]["val"] = isset($atrjum[$row->idatr]["val"]) ? $atrjum[$row->idatr]["val"] + 0 : 0;


			$atrjum[$row->idatr]["name"] = $row->nama;
			$atrjum[$row->idatr]["sub"] = $row->id;
			//$atrjum[$row->idatr] = isset($atrjum[$row->idatr]) ? $atrjum[$row->idatr] . " (" . $row->jum_all." / ".$jumAll. " * " .$row->ent.") + " : " (" . $row->jum_all." / ".$jumAll. " * " .$row->ent.") + ";
		}

		$gainTemp = null;
		foreach($atr as $i => $row)
		{
			$gain[$i] = $entTotal - $atrjum[$i]["val"];
			$gainTemp[] = Array(
									"id"=>$i,
									"val"=> $entTotal - $atrjum[$i]["val"], 
									"name"=>$atrjum[$i]["name"], 
									"sub"=>$atrjum[$i]["sub"]
								);
			//echo $i."<br>";
		}

		for($a=0;$a<count($gainTemp);$a++)
			for($b=$a+1;$b<count($gainTemp);$b++)
				if($gainTemp[$a]["val"] < $gainTemp[$b]["val"])
				{
					$temp = $gainTemp[$a];
					$gainTemp[$a] = $gainTemp[$b];
					$gainTemp[$b] = $temp;
				}

		//$gain = $entTotal - ( e  / $jumAll * h);
		

		//check if 0
		if( $gainTemp[0]['val'] == 0 )
		{


			$subList = $this->Mmain->qRead(" tb_sub 
						WHERE id_atr = '".$lastAttr."'" .
						( is_array($chosenSub) ? "AND NOT id_sub in ('".implode("','",$chosenSub)."')   " : "" ) .

						" ORDER BY id_sub " ,"","");
			if($subList->num_rows() > 0)
			{
				$row = $subList->row();
			}

			$attachedTemp = "NOT";
			if($jumRendah>0)
			{
				$attachedTemp = "Rendah";
			}
			else
			if($jumTinggi>0)
			{
				$attachedTemp = "Tinggi";
			}
			else
			if($jumSangat>0)
			{
				$attachedTemp = "Sangat Tinggi";
			}

				$attachedSub[] = Array("atr"=>$lastAttr,"sub"=>$lastSub,"name"=>$attachedTemp);
			


			//$hasilPerhitungan.= "<br>";
			$queSub = null;
			$maxQueSub = null;
			foreach($attachedSub as $arow)
			{
				$hasilPerhitungan.= $arow['sub']." => ".$arow["name"].", ";
				$queSub[]= $arow['sub'];
			}

			if(is_array($maxSub))
			foreach($maxSub as $arow)
			{
				//$hasilPerhitungan.= $arow['sub']." => ".$arow["name"].", ";
				$maxQueSub[]= $arow['sub'];
			}

			$cekSub = $this->Mmain->qRead("	tb_sub 
											WHERE id_atr = '".$lastAttr."' 
											AND NOT id_sub in ('".implode("','",$chosenSub)."') 
											AND NOT id_sub in ('".implode("','",$queSub)."') 
											","","");
			$hasilPerhitungan.= " cek sub = ".$cekSub->num_rows();
			$hasilPerhitungan.= " <br>last attr = ".$lastAttr;
				
				if($attachedTemp <> "NOT")
				{
					$ruteCounter = count($rute);
					$rute[$ruteCounter-1]["hasil"]=$attachedTemp;
				}

				if($attachedTemp == "NOT")
					array_pop($rute);

			

			if($cekSub->num_rows() == 0 )
			{
				$cekSub = $this->Mmain->qRead("tb_sub 
					WHERE id_atr in ('".implode("','",$chosenAttr)."') 
					AND NOT id_sub in ('".implode("','",$chosenSub)."')  
					","","");
				
				//	AND NOT id_sub in ('".implode("','",$queSub)."') 
				// ".(is_array($maxSub) ?  " AND NOT id_sub in ('".implode("','",$maxQueSub)."') ": "")."
				
				if($cekSub->num_rows() > 0)
				{
						//$hasilPerhitungan.= " cek reset = ".$cekSub->row()->id_sub;
						$ambilSubSisa =  $this->Mmain->qRead("tb_sub 
							WHERE id_atr = '".$cekSub->row()->id_atr."' 
							AND NOT id_sub in ('".implode("','",$chosenSub)."')  
							AND NOT id_sub in ('".implode("','",$queSub)."') 

									

							","","");

						/*
						$currentAttr = $cekSub->row()->id_atr;
						$currentSub = $chosenSub[0];
						$currentQuery = $chosenQuery[0];
						for($ci=0;$ci<count($chosenSub);$ci++)
						{
							if(substr($chosenSub[$ci],0,3)== $currentAttr)
							{
								$currentSub = $chosenSub[$ci];
								$currentQueryTemp = $this->Mmain->qRead("tb_sub WHERE id_sub = '".$currentSub."' ","","")->row();
								$currentQuery = " AND ".$currentQueryTemp->kol_sub." ".$currentQueryTemp->op_sub." ";
								$ci = count($chosenSub);


								//$hasilPerhitungan .= "<br><br><br> niske elek".$currentSub;
							}

						}

						$cekifChosen = 0;
						if($currentAttr <> $chosenAttr[0])
						{
							$maxSub[] = Array("atr"=>$chosenAttr[0],"sub"=>$chosenSub[1],"name"=>"MAX");
							$endAttr[] = $chosenAttr[0];
							$endSub[] = $chosenSub[1];

							$currentQueryTemp = $this->Mmain->qRead("tb_sub WHERE id_sub = '".$chosenSub[1]."' ","","")->row();
							$endQueryTemp = " AND ".$currentQueryTemp->kol_sub." ".$currentQueryTemp->op_sub." ";
							$endQuery[] = $endQueryTemp;

							$hasilPerhitungan .= "<br> END ATTR : ". $chosenAttr[0] .", END SUB : ".$chosenSub[1].", END QUERY : ".$endQueryTemp;

							$cekifChosen = 1;
						}

						$maxSub[] = Array("atr"=>$currentAttr,"sub"=>$currentSub,"name"=>"MAX");
						//$chosenSub[0] = $ambilSubSisa->row()->id_sub;
						foreach($maxSub as $arow)
						{
							$hasilPerhitungan.= "ATR : " . $arow['atr'].", SUB : ".$arow['sub']." ".$arow["name"].", ";
							//$maxQueSub[]= $arow['sub'];
						}
						*/
						
						/*
						$hasilPerhitungan .= "	<br> RESET : 
												<br>CHOSEN ATTRIBUTE : " . implode(",",$chosenAttr)." 
												<br>CHOSEN SUBS : " . implode(",",$chosenSub)." 
												<br>CHOSEN QUERY : " . implode(",",$chosenQuery)." 
												<br>";
												*/
						$hasilPerhitungan.= "<br>cek ";
						$node = null;
						$jumAtr = count($chosenAttr);
						$conAtr = null;
						$conSub = null;
						$conQuery = null;
						for($i=$jumAtr-1 ; $i >= 0 ; $i--)
						{
							$cekSubsLeft = $this->Mmain->qRead("tb_sub WHERE id_atr = '".$chosenAttr[$i]."' 
																AND NOT id_sub in ('".implode("','",$chosenSub)."')  
																","","");
							if($cekSubsLeft->num_rows() == 0)
							{
								$hasilPerhitungan.=$chosenAttr[$i];
								
								$jumSub = count($chosenSub);
								for($j=$jumSub-1 ; $j >= 0 ; $j--)
								{
									if(substr($chosenSub[$j],0,3) == $chosenAttr[$i])
									{
										array_pop($chosenSub);
										//$j--;
									}
									else
									{
										$conSub[] = $chosenSub[$j];
									}
								}
								array_pop($chosenAttr);
								array_pop($chosenQuery);
							//	$i--;
								
							}
							else
							{
								$conAtr[] = $chosenAttr[$i];
								$conQuery[] = $chosenQuery[$i];
								$i = -1;
							}
							
						}
						
						$currentSub = $chosenSub[count($chosenSub)-1];
						$currentAttr = $chosenAttr[count($chosenAttr)-1];
					
						//$attachedSub=null;
						$lastSub=$currentSub;
						$lastAttr=$currentAttr;
						//$id=0;
						
				}
			}
			else{

			}


		}
		else
		{

			$lastAttr = $gainTemp[0]['id'];
		
			if($id == 0)
			{
				$chosenAttr[] = $gainTemp[0]['id'];
			}
			else
			if($id > 0)
			{
				if(!in_array($gainTemp[0]['id'], $chosenAttr)) 
					$chosenAttr[] = $gainTemp[0]['id'];
			}
		}
		
		//check if calculation is finished
		$subList = $this->Mmain->qRead(" tb_sub 
					WHERE id_atr = '".$lastAttr."'" .
					( is_array($chosenSub) ? "AND NOT id_sub in ('".implode("','",$chosenSub)."')   " : "" ) .

					" ORDER BY id_sub " ,"","");
			
		if($subList->num_rows() == 0 )
		{

			$isRepeat= "false";
			$hasilPerhitungan .= " <br><hr><h1>Perhitungan Selesai !!!</h1><hr>";
			
			$queSub = null;
			$maxQueSub = null;
			foreach($attachedSub as $ai=>$arow)
			{
				if($arow["name"] <> "NOT")
				{
				$nm_sub = $this->Mmain->qRead("tb_sub WHERE id_sub = '".$arow['sub']."'","nm_sub","")->row()->nm_sub;
				//$hasilPerhitungan.= ($ai+1)." : ".$nm_sub." = ".$arow["name"]."<br>";
				}
				//$queSub[]= $arow['sub'];
			}

			//$hasilPerhitungan .= " <br><hr><h1>Cek Rute !!!</h1><hr>";
			$lastRules="";
			$this->Mmain->qDel("tb_rule","1","1");
			$bahanSimpan = null;
			foreach($rute as $ri => $rurow)
			{

				$rulesID = $this->Mmain->autoid("tb_rule","id_rule","R","R001","001");

				if($ri<>0)
					$this->Mmain->qUpdpart("tb_rule","id_rule",$lastRules,Array("next_rule"),Array($rulesID));

				//$hasilPerhitungan.= ($ri+1)." : ".implode(", ",$rurow)."<br>";
				$bahanSimpan = Array($rulesID,$rurow["id_sub"],$lastRules,"",$rurow["hasil"]);
				$lastRules = $rulesID;
				$this->Mmain->qIns("tb_rule",$bahanSimpan);
			}


			$hasilPerhitungan .= " <br><hr><h1>Pohon Keputusan</h1><hr>";
			$qRule = $this->Mmain->Qread("	tb_rule a
											INNER JOIN tb_sub b ON a.id_sub = b.id_sub
											INNER JOIN tb_atr c ON b.id_atr = c.id_atr
											WHERE from_rule = '' ","a.id_rule,a.id_sub,b.nm_sub,c.nama,a.hasil,a.next_rule","");
			


			// if($qRule->num_rows() > 0)
			// {
			// 	$rul = null;
			// 	$rowRule = $qRule->row();
			// 	$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil);
			// 	$root = $rowRule->nama;
			// 	$isFinished = false;
			// 	$tree = "";
			// 	$hasil = "";
			// 	$atr = "";
				
			// 	$inn = 1;
			// 	$colm = 0;
			// 	$ann = [];
			// 	$level = 1;
			// 	// $tree .="<style>
			// 	// 			  .klm {
			// 	// 			    -webkit-column-count:2 ;
			// 	// 			    -moz-column-count:2;
			// 	// 			    column-count: 2; 
			// 	// 			  }
			// 	// 			</style>";
			// 				// $tree .="<style>
			// 				//   .klm {
			// 				//     -webkit-column-count: ".$colm;
			// 				//     "-moz-column-count:".$colm;
			// 				//     "column-count: ".$colm; 
			// 				//   "}
			// 				// </style>";
			// 	while($isFinished == false)
			// 	{

			// 		if ($rul['atr'] == $root) {
			// 			if($inn == 1){
			// 				$tree .= "<table><tr><td> ";				
			// 				// $tree .= "<div class='klm'> ";				
			// 			}else {
			// 				// $tree .= "</div><div class='klm'> ";
			// 				$tree .= "</td><td> ";				
							
			// 			};
			// 		}

			// 		if ($rul['atr'] == $root) {
			// 			$colm++;
			// 		}

			// 		array_push($ann, $rul['atr']);
			// 		$inn++;


			// 			$string = implode(",", $ann);
			// 			// $tree .= "<br>".$string;
					
			// 			$tree .= "<br><span data-id='".$rul['id']."' id='ATR".$rul['id']."' class='btn-alt btn btn-info btn-sm'  style='margin-top:5px'>".$rul['atr']."</span>";

			// 			$tree .= "<br><span data-id='".$rul['id']."' id='SUB".$rul['id']."' class='btn-sub ' style='margin-top:5px'>".$rul['sub']."</span>";
					
					

			// 		if($hasil <> "")
			// 		{
			// 			$tree .= "<br><span data-id='".$rul['id']."' id='HAS".$rul['id']."' class='btn-hasil btn btn-warning btn-sm' style='margin-top:5px'>".$hasil."</span>";
			// 			$hasil="";
			// 		}

			// 		if($hasil != ""){
			// 			array_pop($ann);
			// 		}

			// 		// $tree.="</kml>";
			// 		$qRule = $this->Mmain->Qread("	tb_rule a
			// 								INNER JOIN tb_sub b ON a.id_sub = b.id_sub
			// 								INNER JOIN tb_atr c ON b.id_atr = c.id_atr
			// 								WHERE from_rule = '".$rul['id']."' ","a.id_rule,a.id_sub,b.nm_sub,c.nama,a.hasil,a.next_rule,b.id_atr","");
			// 		// echo '<pre>';
			// 		// print_r($qRule->row());
			// 		if($qRule->num_rows() > 0)
			// 		{	
			// 			$rul = null;
			// 			$rowRule = $qRule->row();
			// 			$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil);
			// 			$hasil = $rowRule->hasil <> "" ? $rowRule->hasil : "";
			// 			$atr = $rowRule->id_atr;

			// 		}
			// 		else
			// 			$isFinished= true;


			// 	}	

			// 	$tree .= "</tr><table>";
			// 	// $tree .= "</div>";
				
			// 	$hasilPerhitungan .= $tree;

			// 	echo '<pre>';
			// 	print_r($rul);
			// }

				if($qRule->num_rows() > 0)
			{
				$rul = null;
				$rowRule = $qRule->row();
				$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil);
				$root = $rowRule->nama;
				$isFinished = false;
				$tree = "";
				$hasil = "";
				$atr = "";
				
				$inn = 0;
				$colm = 0;
				$level = [];
				$pk = [];
				// $tree .="<style>
				// 			  .klm {
				// 			    -webkit-column-count:2 ;
				// 			    -moz-column-count:2;
				// 			    column-count: 2; 
				// 			  }
				// 			</style>";
							// $tree .="<style>
							//   .klm {
							//     -webkit-column-count: ".$colm;
							//     "-moz-column-count:".$colm;
							//     "column-count: ".$colm; 
							//   "}
							// </style>";
				while($isFinished == false)
				{
					// if ($inn == 8){break;}
					// if ($rul['atr'] == $root) {
					// 	if($inn == 1){
					// 		$tree .= "<table><tr><td> ";				
					// 		// $tree .= "<div class='klm'> ";				
					// 	}else {
					// 		$tree .= "</div><div class='klm'> ";
					// 		$tree .= "</td><td> ";
					// 		// break;				
							
					// 	};
					// }

					if ($rul['atr'] == $root) {
						$colm++;
					}

					// array_push($ann, $rul['atr']);
					
					$inn++;

					if (array_search($rul['atr'], $level) > 0) {
						// echo '<pre>';
						// print_r($level);
						// print_r($rul['atr']);
						// print_r(array_search($rul['atr'], $level));
						$x=array_search($rul['atr'], $level);
						$temPlevel = array_slice($level, 0,$x +1);
						$level = null;
						$level = $temPlevel;
						$temPlevel = null;
						// print_r($level);
						// print_r(count($level));
					}
						
						// $tree .= "<br>".$string;
					
						// $tree .= "<span data-id='".$rul['id']."' id='ATR".$rul['id']."' class='btn-alt btn btn-info btn-sm'  style='margin-top:5px'>".$rul['atr']."</span>";

						// $tree .= "<br><span data-id='".$rul['id']."' id='SUB".$rul['id']."' class='btn-sub ' style='margin-top:5px'>".$rul['sub']."</span>";
						if ($inn != 1) {
							// $tree .= "<br>";
							// $tree .= $rul["atr"]." != ".$level[count($level)-1];
							if($rul['atr'] == $level[0]){
									$tree .= "<br>";

									

							}else if ($rul["atr"] == $level[count($level)-1]) {
								
									$tree .= "<br>";
									for ($i =0; $i <  count($level)-1; $i++) {
										$tree .= "&nbsp &nbsp &nbsp | &nbsp  ";
									}
									array_pop($level);

									
								}else{
									$tree .= "<br>";

								for ($i =0; $i <  count($level); $i++) {
									$tree .= "&nbsp &nbsp &nbsp | &nbsp  ";
								}

								// $finish = false;
								// // if(count($level)>0){
								// 	while ($finish == false) {
								// 	    if($rul["atr"] != $level[count($level)-1]){
								// 	    	array_pop($level);
								// 	    }else{
								// 	    	$finish = true;
								// 	    }
								// 	    if(count($level) == 0){
								// 	    	$finish = true;
								// 	    }
								// 	}
								// // }

								
								}
						}else {
							// $tree .= "&nbsp &nbsp  |> &nbsp  ";
						}
						

						$tree .= "<span>".strtoupper($rul['atr'])."= </span>";
						$tree .= "<span>".$rul['sub']." </pan>";
						if ($hasil == "") {
							$tree .= " ";
						}else {
							$tree .= ":  ";
						}


					
						array_push($level, $rul['atr']);
					

					if($hasil <> "")
					{
						// $tree .= "<br><span data-id='".$rul['id']."' id='HAS".$rul['id']."' class='btn-hasil btn btn-warning btn-sm' style='margin-top:5px'>".$hasil."</span>";
						switch ($hasil) {
							case "Sangat Tinggi":
								$tree .= "<span style='color:red';> ".$hasil."</span>";
								$hasil="";
								break;
							case "Tinggi":
								$tree .= "<span style='color:orange';> ".$hasil."</span>";
								$hasil="";
								break;
							case "Rendah":
								$tree .= "<span style='color:green';> ".$hasil."</span>";
								$hasil="";
								break;
							
							default:
								// code...
								break;
						}
						
						
					}

					if($hasil != ""){
						array_pop($ann);
					}

					// $tree.="</kml>";
					$qRule = $this->Mmain->Qread("	tb_rule a
											INNER JOIN tb_sub b ON a.id_sub = b.id_sub
											INNER JOIN tb_atr c ON b.id_atr = c.id_atr
											WHERE from_rule = '".$rul['id']."' ","a.id_rule,a.id_sub,b.nm_sub,c.nama,a.hasil,a.next_rule,b.id_atr","");
					// echo '<pre>';
					// print_r($qRule->row());
					if($qRule->num_rows() > 0)
					{	
						$rul = null;
						$rowRule = $qRule->row();
						$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil);
						$hasil = $rowRule->hasil <> "" ? $rowRule->hasil : "";
						$atr = $rowRule->id_atr;

					}
					else
						$isFinished= true;


				}	
				// $tree .=  "<br>";
				// foreach ($level as $value) {
				// 	$tree .=  $value.",    ";
				// }

				// $tree .= "</tr><table>";
				// $tree .= "</div>";
				
				$hasilPerhitungan .= $tree;

				// echo '<pre>';
				// echo  ($level);

			
			}


		}
		else
		{
			$lastGain = $gainTemp[0]['val'];
			$hasilPerhitungan .= $this::tampilHitung($retVal, $gain, $gainTemp, $this->viewFormTableHeader,$id);
			
		}
		
		$id++ ;
		}
		$output['hasilPerhitungan'] = $hasilPerhitungan;

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
	
	public function tampilHitung($render, $gain, $gainTemp, $tableHeader, $id)
	{

		$retVal = "";
		$retVal .= '


          <div class="row">
            <div class="col-xs-12">
              <div class="box">
              	
                <div class="box-body">

				<button class="btn btn-primary mb-2" id="tombol'.$id.'"  data-toggle="collapse" data-target="#cal'.$id.'">Tampilkan Perhitungan</button>
				<div id="cal'.$id.'"  class="collapse">
				<table class="table table-striped table-bordered table-condensed compact" >
				';
	
					if(!empty($render))
					{
	
		$retVal .= '
						<thead>
							<tr>
								<th class="text-center">No.</th>
					';
						
							foreach($tableHeader as $row)
							{
							
			$retVal .= '<th class="text-center">'.$row.'</th>';
						
							}
			
		$retVal .= '		

							</tr>
						</thead>
						<tbody>
					';
						
						
						foreach($render as $i=>$row)
						{ 			
				
			
		$retVal .= '	
							<tr>
								<td class="text-center">'.($i+1).'</td>
						


									<td>'. $row[0].'</td>
									<td>'. $row[1].'</td>
									<td>'. $row[2].'</td>
									<td>'. $row[3].'</td>
									<td>'. $row[4].'</td>
									<td>'. $row[5].'</td>
									<td>'. $row[6].'</td>
									<td>' . ($i <> 0 ? $gain[$row['idatr']] : "" ).'</td>
								


							</tr>
						';


						}
						
		$retVal .= '	
						</tbody>
					
			
				</table>
				</div>
				<p>Gain terbesar adalah = <b>'. $gainTemp[0]["name"] ." - ".$gainTemp[0]["id"] .'</b> sebesar <b>'. $gainTemp[0]["val"].'</b></p>


                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->

					';


					}

		return $retVal;

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
			$render=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery,$this->mainPk."  = '".$pid."'");
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
		}
		else //untuk add
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
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[2]."' required>",
								"<input type='text' class='form-control' id='txtid3' name=txt[] value='".$txtVal[3]."' required>",
								"<input type='text' class='form-control' id='txtid4' name=txt[] value='".$txtVal[4]."' required>",
								"<input type='text' class='form-control' id='txtid5' name=txt[] value='".$txtVal[5]."' required>",
								"<input type='text' class='form-control' id='txtid6' name=txt[] value='".$txtVal[6]."' required>",
								"<input type='text' class='form-control' id='txtid7' name=txt[] value='".$txtVal[7]."' required>",
								"<input type='text' class='form-control' id='txtid8' name=txt[] value='".$txtVal[8]."' required>",
								"<input type='text' class='form-control' id='txtid9' name=txt[] value='".$txtVal[9]."' required>"
								//$imgTemp."<input type='file' class='form-control fileupload' id='txtid23' name=txtfl >"
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
		/*
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
		$savValTemp[]=$avauser;
		*/
		//$savValTemp[3]=md5($savValTemp[3]);
		//echo implode("<br>",$savEmp);
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
	/*	$avauser="";
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
		
		$savValTemp[]=$avauser;
*/
		//$savValTemp[3]=md5($savValTemp[3]);
		$this->Mmain->qUpd($this->mainTable,$this->mainPk,$savValTemp[0],$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}

	
}

?>