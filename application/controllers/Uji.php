<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uji extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
			$this->load->library('Commonprint');
				
		if(!isset($this->session->userdata['name']))		
			redirect("login","refresh");
	}
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	var $mainTable="tb_uji";
	var $mainPk="id_uji";
	var $viewLink="Uji";
	var $breadcrumbTitle="Data Ibu Hamil";
	var $viewPage="Admviewpage2";
	var $addPage="Admaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_uji"; //pengurutan berdasarkan kolomnya//
	var $tableQuery="
						tb_uji a
						inner join tb_bumil2 b on a.id_bumil=b.id_bumil
						inner join tb_pgw c on a.id_pgw=c.id_pgw
						";
	var $fieldQuery="	
						a.id_uji,
						b.id_bumil,
						c.id_pgw,
						a.usia16,
						a.usia,
						a.jp1,
						a.jhkehamil,
						a.jumlahanak,
						a.tb_bumil,
						a.pkguguran,
						a.pmdengan,
						a.pocesar,
						a.pykt_bumil,
						a.jnshamil,
						a.bayimatikndgn,
						a.lebihbln,
						a.letjanin,
						a.pendarahan,
						a.preeklamsia,
						a.statusres"; //leave blank to show all field atau kolom
						
	var $primaryKey="id";
	var $updateKey="a.id_uji";
	
	//auto generate id
	var $defaultId="U001";
	var $prefix="U";
	var $suffix="001";	
	
	//view
	var $viewFormTitle="Data Ibu Hamil";
	var $viewFormTableHeader=array(
									"Id Uji",									
									"Id Ibu Hamil",
									"Id Pegawai",
									"Usia Hamil 1",
									"Usia Ibu Hamil",
									"Jarak pernikahan ke hamil 1",
									"Jarak Hamil ke Hamil",
									"Jumlah Anak",
									"Tinggi ibu hamil",
									"Pernah Keguguran",
									"Riwayat Melahirkan",
									"Pernah Operasi Cesar",
									"Penyakit Ibu Hamil",
									"Jenis Kehamilan Kembar",
									"Bayi Mati Dalam Kandungan",
									"Kehamilan Lebih Bulan",
									"Letak Janin",
									"Pendarahan",
									"Preeklamsia",
									"Status Risiko"
								);
	
	//save
	var $saveFormTitle="Klasifikasi Risiko Ibu Hamil";
	var $saveFormTableHeader=array(
									"Id Uji",									
									"Id Ibu Hamil",
									"Id Pegawai",
									"Usia Hamil 1",
									"Usia Ibu Hamil",
									"Jarak pernikahan ke hamil 1",
									"Jarak Hamil ke Hamil",
									"Jumlah Anak",
									"Tinggi ibu hamil",
									"Pernah Keguguran",
									"Riwayat Melahirkan",
									"Pernah Operasi Cesar",
									"Penyakit Ibu Hamil",
									"Jenis Kehamilan Kembar",
									"Bayi Mati Dalam Kandungan",
									"Kehamilan Lebih Bulan",
									"Letak Janin",
									"Pendarahan",
									"Preeklamsia",
									// "Status Risiko"
								);
	
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
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		
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

		$cbopkguguran=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[9]);
		$cbopmdengan=$this->fn->createCbo(array("Tarikan tang atau vakum","Uri dirogoh","Tranfusi","Tidak"),array("Tarikan tang atau vakum","Uri dirogoh","Tranfusi","Tidak"),$txtVal[10]);
		$cbopocesar=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[11]);
		$cbopykt=$this->fn->createCbo(array("Kurang Darah","Malaria","TBC Paru","Payah Jantung","Kencing Manis","Menular Seksual","Bengkak Pada Muka Dan Tekanan Darah Tinggi","Tidak"),array("Kurang Darah","Malaria","TBC Paru","Payah Jantung","Kencing Manis","Menular Seksual","Bengkak Pada Muka Dan Tekanan Darah Tinggi","Tidak"),$txtVal[12]);
		$cbojenishamil=$this->fn->createCbo(array("Kembar","Air","Tidak"),array("Kembar","Air","Tidak"),$txtVal[13]);
		$cbobayimati=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[14]);
		$cbolebihbln=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[15]);
		$cboletjanin=$this->fn->createCbo(array("Sungsang","Lintang","Normal"),array("Sungsang","Lintang","Normal"),$txtVal[16]);
		$cbopendarahan=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[17]);
		$cbopreek=$this->fn->createCbo(array("Ya","Tidak"),array("Ya","Tidak"),$txtVal[18]);
		// $cbostatusres=$this->fn->createCbo(array("Rendah","Tinggi","Sangat Tinggi"),array("Rendah","Tinggi","Sangat Tinggi"),$txtVal[19]);
		$cbobumil=$this->fn->createCbofromDb("tb_bumil2","id_bumil as id,nama_bumil as nm","",$txtVal[1]);
		$cbopgw=$this->fn->createCbofromDb("tb_pgw","id_pgw as id,nama_pgw as nm","",$txtVal[2]);
			$output['formTxt']=array(
				
				$codeTemp."<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
				$cbobumil,
				$cbopgw,
								"<input type='text' class='form-control' id='txtid4' name=txt[] value='".$txtVal[3]."' required>",
								"<input type='text' class='form-control' id='txtid4' name=txt[] value='".$txtVal[4]."' required>",
								"<input type='text' class='form-control' id='txtid5' name=txt[] value='".$txtVal[5]."' required>",
								"<input type='text' class='form-control' id='txtid6' name=txt[] value='".$txtVal[6]."' required>",
								"<input type='text' class='form-control' id='txtid6' name=txt[] value='".$txtVal[7]."' required>",
								"<input type='text' class='form-control' id='txtid6' name=txt[] value='".$txtVal[8]."' required>",
				$cbopkguguran,
				$cbopmdengan,
				$cbopocesar,
				$cbopykt,
				$cbojenishamil,
				$cbobayimati,
				$cbolebihbln,
				$cboletjanin,
				$cbopendarahan,
				$cbopreek,
				// $cbostatusres
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
		

		$a = [];
		$b = [];
		$i = 0;
		$status = "";

		$form=array(
									"Id Uji",									
									"Id Ibu Hamil",
									"Id Pegawai",
									"Usia Hamil 1",
									"Usia Ibu Hamil",
									"Jarak pernikahan ke hamil 1",
									"Jarak Hamil ke Hamil",
									"Jumlah Anak",
									"Tinggi Badan",
									"Pernah Keguguran",
									"Riwayat Melahirkan",
									"Pernah Operasi Cesar",
									"Penyakit Ibu hamil",
									"Jenis Kehamilan",
									"Bayi Mati Dalam Kandungan",
									"Kehamilan Lebih Bulan",
									"Letak Janin",
									"Pendarahan",
									"Preeklamsia",
									// "Status Risiko"
								);
		$savValTemp[2] = $this->session->userdata['id_pgw'];

		foreach ($form as $value) {
			$a[$value] = $savValTemp[$i];
			$i++;
		}

		// echo '<pre>';
		// print_r($a);

		foreach (array_keys($a) as $val) {
			// print_r($val);
			if ($val != "Id Skrining" && $val != "Id Ibu Hamil" && $val != "Id Pegawai") {
				switch ($val) {
					case "Usia Hamil 1":
						// code...
					if ($a["Usia Hamil 1"] <= 16) {
						$a["Usia Hamil 1"] = "A01-01"; 
					}elseif ($a["Usia Hamil 1"] >16) {
						$a["Usia Hamil 1"] = "A01-02"; 
					}
						break;
					case "Usia Ibu Hamil":
						if ($a["Usia Ibu Hamil"] <= 16) {
							$a["Usia Ibu Hamil"] = "A02-01";
						}elseif ($a["Usia Ibu Hamil"]  <= 34) {
							$a["Usia Ibu Hamil"] = "A02-02";
						}elseif ($a["Usia Ibu Hamil"]  >= 35) {
							$a["Usia Ibu Hamil"] = "A02-03";
						}
						break;
					case "Jarak pernikahan ke hamil 1":
						if ($a["Jarak pernikahan ke hamil 1"] >= 4) {
							$a["Jarak pernikahan ke hamil 1"] = "A03-01"; 
						}elseif ($a["Jarak pernikahan ke hamil 1"] <4) {
							$a["Jarak pernikahan ke hamil 1"] = "A03-02"; 
						}
						break;
					case "Jarak Hamil ke Hamil":
						if ($a["Jarak Hamil ke Hamil"] == 0) {
							$a["Jarak Hamil ke Hamil"] = "A04-04"; 
						}elseif ($a["Jarak Hamil ke Hamil"] <2) {
							$a["Jarak Hamil ke Hamil"] = "A04-01"; 
						}elseif ($a["Jarak Hamil ke Hamil"] >= 2) {
							$a["Jarak Hamil ke Hamil"] = "A04-02"; 
						}elseif ($a["Jarak Hamil ke Hamil"] >= 10) {
							$a["Jarak Hamil ke Hamil"] = "A04-03"; 
						}
						break;
					case "Jumlah Anak":
						if ($a["Jumlah Anak"] == 0) {
							$a["Jumlah Anak"] = "A05-03"; 
						}elseif ($a["Jumlah Anak"] <4) {
							$a["Jumlah Anak"] = "A05-01"; 
						}elseif ($a["Jumlah Anak"] >4) {
							$a["Jumlah Anak"] = "A05-02"; 
						}
						break;
					case "Tinggi Badan":
						if ($a["Tinggi Badan"] <= 145) {
							$a["Tinggi Badan"] = "A06-01"; 
						}elseif ($a["Tinggi Badan"] > 145) {
							$a["Tinggi Badan"] = "A06-02"; 
						}
						break;
					case "Pernah Keguguran":
						if ($a["Pernah Keguguran"] == "Ya") {
							$a["Pernah Keguguran"] = "A07-01"; 
						}elseif ($a["Pernah Keguguran"] == "Tidak") {
							$a["Pernah Keguguran"] = "A07-02"; 
						}
						break;	
					case "Riwayat Melahirkan":
						if ($a["Riwayat Melahirkan"] == "Tarikan Tang atau Vakum") {
							$a["Riwayat Melahirkan"] = "A08-01"; 
						}elseif ($a["Riwayat Melahirkan"] == "Uri dirogoh") {
							$a["Riwayat Melahirkan"] = "A08-02"; 
						}elseif ($a["Riwayat Melahirkan"] == "Tranfusi") {
							$a["Riwayat Melahirkan"] = "A08-03"; 
						}elseif ($a["Riwayat Melahirkan"] == "Tidak") {
							$a["Riwayat Melahirkan"] = "A08-04"; 
						}
						break;
					case "Pernah Operasi Cesar":
						if ($a["Pernah Operasi Cesar"] == "Ya") {
							$a["Pernah Operasi Cesar"] = "A09-01"; 
						}elseif ($a["Pernah Operasi Cesar"] == "Tidak") {
							$a["Pernah Operasi Cesar"] = "A09-02"; 
						}
						break;	
					case "Penyakit Ibu hamil":
						if ($a["Penyakit Ibu hamil"] == "Kurang Darah") {
							$a["Penyakit Ibu hamil"] = "A10-01"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Malaria") {
							$a["Penyakit Ibu hamil"] = "A10-02"; 
						}elseif ($a["Penyakit Ibu hamil"] == "TBC Paru") {
							$a["Penyakit Ibu hamil"] = "A10-03"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Payah Jantung") {
							$a["Penyakit Ibu hamil"] = "A10-04"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Kencing Manis") {
							$a["Penyakit Ibu hamil"] = "A10-05"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Menular Seksual") {
							$a["Penyakit Ibu hamil"] = "A10-06"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Bengkak Pada Muka Dan Tekanan Darah Tinggi") {
							$a["Penyakit Ibu hamil"] = "A10-07"; 
						}elseif ($a["Penyakit Ibu hamil"] == "Tidak") {
							$a["Penyakit Ibu hamil"] = "A10-09"; 
						}
						break;
					case "Jenis Kehamilan":
						if ($a["Jenis Kehamilan"] == "Kembar") {
							$a["Jenis Kehamilan"] = "A11-01"; 
						}elseif ($a["Jenis Kehamilan"] == "Air") {
							$a["Jenis Kehamilan"] = "A11-02"; 
						}elseif ($a["Jenis Kehamilan"] == "Tidak") {
							$a["Jenis Kehamilan"] = "A11-03"; 
						}
						break;
					case "Bayi Mati Dalam Kandungan":
						if ($a["Bayi Mati Dalam Kandungan"] == "Ya") {
							$a["Bayi Mati Dalam Kandungan"] = "A12-01"; 
						}elseif ($a["Bayi Mati Dalam Kandungan"] == "Tidak") {
							$a["Bayi Mati Dalam Kandungan"] = "A12-02"; 
						}
						break;	
					case "Kehamilan Lebih Bulan":
						if ($a["Kehamilan Lebih Bulan"] == "Ya") {
							$a["Kehamilan Lebih Bulan"] = "A13-01"; 
						}elseif ($a["Kehamilan Lebih Bulan"] == "Tidak") {
							$a["Kehamilan Lebih Bulan"] = "A13-02"; 
						}
					case "Letak Janin":
						if ($a["Letak Janin"] == "Sungsang") {
							$a["Letak Janin"] = "A14-01"; 
						}elseif ($a["Letak Janin"] == "Lintang") {
							$a["Letak Janin"] = "A14-02"; 
						}elseif ($a["Letak Janin"] == "Normal") {
							$a["Letak Janin"] = "A14-03"; 
						}
						break;
						break;
					case "Pendarahan":
						if ($a["Pendarahan"] == "Ya") {
							$a["Pendarahan"] = "A15-01"; 
						}elseif ($a["Pendarahan"] == "Tidak") {
							$a["Pendarahan"] = "A15-02"; 
						}
						break;
					case "Preeklamsia":
						if ($a["Preeklamsia"] == "Ya") {
							$a["Preeklamsia"] = "A16-01"; 
						}elseif ($a["Preeklamsia"] == "Tidak") {
							$a["Preeklamsia"] = "A16-02"; 
						}
						break;
					default:
						// code...
						break;
				}
			}
		
		}
		// print_r($a);

		$status =$this->getStatus($a);

		// echo("<pre>");
		// print_r($status);

		array_push($savValTemp, $status);

		// print_r($savValTemp);

		
// 		if ($a["Usia Ibu Hamil"] <=34) {
// 			if ($a["Pernah Operasi Cesar"] == "Ya") {
// 				if ($a["Jarak Hamil ke Hamil"] <24) {
// 					$status = "Sangat Tinggi";
// 				}elseif ($a["Jarak Hamil ke Hamil" ]  >= 24) {
// 					if ($a["Pernah Keguguran"] == "Ya") {
// 						$status = "Sangat Tinggi";
// 					}else{
// 						$status = "Tinggi";
// 					}
// 				}
// 			}else{
// 				// print_r("1");
// 				if ($a["Penyakit Ibu hamil"] == "Kurang Darah") {
// 							if ($a["Pernah Keguguran"] == "Ya") {
// 								$status = "Sangat Tinggi";
// 							}else{
// 								$status = "Tinggi";
// 							}
// 					}elseif ($a["Penyakit Ibu hamil"] == "Malaria") {
// 							$status = "Tinggi";
// 					}
// 					elseif ($a["Penyakit Ibu hamil"]== "TBC Paru") {
// 							$status = "Tinggi";
// 					}elseif ($a["Penyakit Ibu hamil"] == "Bengkak Pada Muka Dan Tekanan Darah Tinggi") {
// 							$status = "Tinggi";
// 					}elseif ($a["Penyakit Ibu hamil"]== "Tidak") {
// 						// print_r("2");
// 							if ($a["Pernah Keguguran"] == "Ya") {
// 								if ($a["Jarak Hamil ke Hamil"] == 0) {
// 									$status = "Sangat Tinggi";
// 								}elseif ($a["Jarak Hamil ke Hamil"]<24 ) {
// 									$status = "Tinggi";
// 								}
// 							}else{
// 								if ($a["Jarak Hamil ke Hamil"]  == 0 ){
// 									if ($a["Tinggi Badan"] <= 145) {
// 										$status = "Tinggi";
// 									}elseif ($a["Tinggi Badan"] >145) {
// 										$status = "Rendah";
// 									}
// 								}elseif ($a["Jarak Hamil ke Hamil"] <24) {
// 									$status = "Rendah";
// 								}elseif ($a["Jarak Hamil ke Hamil"] >= 120 ) {	
// 									$status = "Tinggi";
// 								}elseif ($a["Jarak Hamil ke Hamil"] >= 24 ) {
// 									if ($a["Letak Janin"] == "Sungsang") {
// 										$status = "Tinggi";
// 									}elseif ($a["Letak Janin"] == "Normal") {
// 										$status = "Rendah";
// 									}
// 								}
// 							}
// 					}
// 			}
// 		}elseif ($a["Usia Ibu Hamil"] >34) {
// 			if ($a["Pernah Operasi Cesar" ] == "Ya") {
// 				$status = "Sangat Tinggi";
// 			}elseif ($a["Pernah Operasi Cesar"] == "Tidak") {
// 				if ($a["Letak Janin"] == "Sungsang") {
// 					$status = "Sangat Tinggi";
// 				}elseif ($a["Letak Janin"] == "Normal") {
// 					$status = "Tinggi";
// 				}
// 			}
// 		}

// 		array_push($savValTemp, $status);
// 		// print_r($savValTemp);

// 		$print = "";

// 		$print .= "<h1> Resiko Kehamilan </h1>";
// 		foreach ($savValTemp as $value) {
// 			$print .= "<br>";
// 			$print .= $value;
// 		}
// 		$data = array();
// 		$it = 0;
// 		array_push($form, "Status");
// 		foreach ($savValTemp as $value) {
// 			array_push($data, array("atr"=> $form[$it], "val" =>$value));
// 			$it++;
// 		}
 	

// 		// //load to database
// 		$this->load->database();
// 		$this->load->model('Mmain');

// //get name
// 		$qName = $this->Mmain->Qread("	tb_bumil2 a WHERE a.id_bumil = '".$savValTemp[1]."'","a.nama_bumil","");
// 		$qPgw = $this->Mmain->Qread("	tb_pgw a WHERE a.id_pgw = '".$savValTemp[2]."'","a.nama_pgw","");
			
// 		$nm = "";
// 		$pgw = "";
// 		if($qName->num_rows() > 0){
// 			$nm = $qName->row()->nama_bumil;
// 		}
// 		if($qPgw->num_rows() > 0){
// 			$pgw = $qPgw->row()->nama_pgw;
// 		}



		$this->Mmain->qIns("tb_uji",$savValTemp);
		
		// //redirect to form

		redirect($this->viewLink."/add",'refresh');	

// 		// print_r($this->session->userdata['id_pgw']);



 		
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

		// $this->Mmain->qIns("tb_uji",$savValTemp);
		
		// // // //redirect to form

		// redirect($this->viewLink."/add",'refresh');		
	}


	public function ctk($id){
		// print_r($id);

		// //load to database
		$this->load->database();
		$this->load->model('Mmain');
		$qUji = $this->Mmain->Qread("view_uji WHERE id_uji = '".$id."'","*","");

		$uji = $qUji->row();

		$i = 0;

		$form=array(
									"Id Uji",									
									"Id Ibu Hamil",
									"Id Pegawai",
									"Usia Hamil 1",
									"Usia Ibu Hamil",
									"Jarak pernikahan ke hamil 1",
									"Jarak Hamil ke Hamil",
									"Jumlah Anak",
									"Tinggi Badan",
									"Pernah Keguguran",
									"Riwayat Melahirkan",
									"Pernah Operasi Cesar",
									"Penyakit Ibu hamil",
									"Jenis Kehamilan Kembar",
									"Bayi Mati Dalam Kandungan",
									"Kehamilan Lebih Bulan",
									"Letak Janin",
									"Pendarahan",
									"Preeklamsia",
									"Status Risiko"
								);
		$data = array();

		if($qUji->num_rows() > 0){
			
			array_push($data, array("atr" =>$form[0], "val"=> $uji->id_uji));
			array_push($data, array("atr" =>$form[1], "val"=> $uji->id_bumil));
			array_push($data, array("atr" =>$form[2], "val"=> $uji->id_pgw));
			array_push($data, array("atr" =>$form[3], "val"=> $uji->usia16));
			array_push($data, array("atr" =>$form[4], "val"=> $uji->usia));
			array_push($data, array("atr" =>$form[5], "val"=> $uji->jp1));
			array_push($data, array("atr" =>$form[6], "val"=> $uji->jhkehamil));
			array_push($data, array("atr" =>$form[7], "val"=> $uji->jumlahanak));
			array_push($data, array("atr" =>$form[8], "val"=> $uji->tb_bumil));
			array_push($data, array("atr" =>$form[9], "val"=> $uji->pkguguran));
			array_push($data, array("atr" =>$form[10], "val"=> $uji->pmdengan));
			array_push($data, array("atr" =>$form[11], "val"=> $uji->pocesar));
			array_push($data, array("atr" =>$form[12], "val"=> $uji->pykt_bumil));
			array_push($data, array("atr" =>$form[13], "val"=> $uji->jnshamil));
			array_push($data, array("atr" =>$form[14], "val"=> $uji->bayimatikndgn));
			array_push($data, array("atr" =>$form[15], "val"=> $uji->lebihbln));
			array_push($data, array("atr" =>$form[16], "val"=> $uji->letjanin));
			array_push($data, array("atr" =>$form[17], "val"=> $uji->pendarahan));
			array_push($data, array("atr" =>$form[18], "val"=> $uji->preeklamsia));
			array_push($data, array("atr" =>$form[19], "val"=> $uji->statusres));
		
		
		}
		// echo '<pre>';
		// print_r($data);

		$hh=$this->load->view('page_prints',array('title_page'=>"Resko",'data_bumil'=>$data, 'nama' => $uji->nama_bumil, "id" =>$uji->id_uji, "tgl" => date("d/m/Y"), "pegawai" => $uji->nama_pgw), true);
	   
	        
	    require './assets/html2pdf/autoload.php';
	    
	    $pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
	    $pdf->WriteHTML($hh);
	    $pdf->Output('Resko-'.$uji->nama_bumil.'-'.date("d/m/Y").'.pdf', 'D');
		
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
		redirect($this->viewLink."/add",'refresh');		
	}



	public function getStatus($arr)
	{	

		$stts = "";
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
			

			if($qRule->num_rows() > 0)
			{
				$rul = null;
				$rowRule = $qRule->row();
				$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil, "id_sub" => $rowRule->id_sub);
				$root = $rowRule->nama;
				$isFinished = false;
				$tree = "";
				$hasil = "";
				$atr = "";
				
				$it = 0;
				$colm = 0;

				
				$currentNode = "";

				$gantiCabang = false;

				$tempId = str_split($rul['id_sub'], 3);
				$nextNode = $tempId[0];
				$node = [];
				// array_push($node, "asd");

				// print_r("node : ");
				// print_r($node);

				

				while($isFinished == false)
				{
					// echo '<pre>';
					
				$tempId = str_split($rul['id_sub'], 3);

				$currentNode = $tempId[0];

		 	 	$currentIdRule = $rul["id_sub"]; 	
		 	 	$currentIdRuleData = $arr[$rul["atr"]]; 	
					
					// print_r("{.$it.} \n");
					// print_r($currentNode."||");
					// print_r($nextNode."\n");

					// print_r($currentIdRule." || ");
					// print_r($currentIdRuleData." \n");
					
					if ($gantiCabang == true) {
						// print_r("gantiCabang");
						if ($nextNode == $currentNode) {
							if ($rul["id_sub"] == $arr[$rul["atr"]]) {
								$gantiCabang = false;
								

								if ($rul["hasil"] == "" || $rul["hasil"] == null) {
									$nextNode = $currentNode;
									
									// print_r($rul["id_sub"]. "sama");
									
								}else{
									
									// print_r("hasil".$rul["hasil"]);
									
									$stts = $rul["hasil"];
									$isFinished = true;
								}
							}else{
									// print_r("tidak sama");
									$nextNode = $currentNode;
							}
						}
					} else {

						if ($rul["id_sub"] == $arr[$rul["atr"]]) {
								if ($rul["hasil"] == "" || $rul["hasil"] == null) {
									$nextNode = $currentNode;
									// print_r($rul["id_sub"]. "sama");
									
								}else{
									// print_r("hasil".$rul["hasil"]);
									$stts = $rul["hasil"];
									$isFinished = true;
								}
							}else{
									
									$nextNode = $currentNode;
									$gantiCabang = true;
							}
					}
			
						
						
										$it++;

					// $tree.="</kml>";
					$qRule = $this->Mmain->Qread("	tb_rule a
											INNER JOIN tb_sub b ON a.id_sub = b.id_sub
											INNER JOIN tb_atr c ON b.id_atr = c.id_atr
											WHERE from_rule = '".$rul['id']."' ","a.id_rule,a.id_sub,b.nm_sub,c.nama,a.hasil,a.next_rule,b.id_atr","");
					// print_r($arr);



					// print_r($rul);


					if($qRule->num_rows() > 0)
					{	
						$rul = null;
						$rowRule = $qRule->row();
						$rul= Array("id"=>$rowRule->id_rule,"atr"=>$rowRule->nama,"sub"=>$rowRule->nm_sub,"next"=>$rowRule->next_rule,"hasil"=>$rowRule->hasil, "id_sub" => $rowRule->id_sub);
						$hasil = $rowRule->hasil <> "" ? $rowRule->hasil : "";
						$atr = $rowRule->id_atr;

						$tempId = str_split($rul['id_sub'], 3);

						$currentNode = $tempId[0];
						// if ($currentIdRule == $currentIdRuleData) {
						// 			$nextNode = $currentNode;
						// 		}
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
				print_r($tree);

			
			}


		}
		else
		{
			$lastGain = $gainTemp[0]['val'];
			// $hasilPerhitungan .= $this::tampilHitung($retVal, $gain, $gainTemp, $this->viewFormTableHeader,$id);
			
		}
		
		$id++ ;
		}
		// $output['hasilPerhitungan'] = $hasilPerhitungan;

		// //init view
		// $output['pageTitle']=$this->viewFormTitle;
		// $output['breadcrumbTitle']=$this->breadcrumbTitle;
		// $output['breadcrumbLink']=$this->viewLink;
		// $output['saveLink']=$this->viewLink."/add";
		// $output['deleteLink']=$this->viewLink."/delete";
		// $output['primaryKey']=$this->primaryKey;
		// $output['tableHeader']=$this->viewFormTableHeader;
		
		//render view
		// $this->fn->getheader();
		// $this->load->view($this->viewPage,$output);
		// $this->fn->getfooter();

		return $stts;
	}

	
}

?>