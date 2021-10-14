<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
	}
	
	public function index()
	{
		
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		$output['setting']=$this->Mmain->qRead(
											"tb_setting",
											"","");
		//check user access	
		$output['catProd']=$this->Mmain->qRead(
										"tb_catprod",
										"","");
		$output['prod']=$this->Mmain->qRead(
										" tb_prod AS a INNER JOIN tb_catprod AS b ON a.id_catprod= b.id_catprod ",
										" a.id_prod AS id,a.nm_prod AS nm,b.code_catprod AS cat,a.rem_prod AS rem,a.pic_prod AS pic ","");
										
		$output['events']=$this->Mmain->qRead(
										"tb_events AS a INNER JOIN tb_emp AS b ON a.code_user = b.code_user ",
										"a.id_events AS id,a.title_events AS title,a.date_events AS date,a.summary_events AS content,a.pic_events AS pic,b.nm_emp AS emp,a.stat_events AS stat","");
		$this->load->view('blog',$output);
	}
		
	public function Det($blogid)
	{
		
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		
		$output['setting']=$this->Mmain->qRead(
											"tb_setting",
											"","");
		//check user access	
		$output['catProd']=$this->Mmain->qRead(
										"tb_catprod",
										"","");
		$output['prod']=$this->Mmain->qRead(
										" tb_prod AS a INNER JOIN tb_catprod AS b ON a.id_catprod= b.id_catprod ",
										" a.id_prod AS id,a.nm_prod AS nm,b.code_catprod AS cat,a.rem_prod AS rem,a.pic_prod AS pic ","");
										
						
		$output['comment']=$this->Mmain->qRead(
										" tb_comment AS a INNER JOIN tb_events AS B ON a.id_events = b.id_events WHERE a.id_events = '".$blogid."' AND a.stat_comment =1 ",
										" a.id_comment as id,a.date_comment as date,a.time_comment as time,a.nm_comment as nm,a.email_comment as email,a.content_comment as content","");
										
		$output['events']=$this->Mmain->qRead(
										"tb_events AS a 
										INNER JOIN tb_emp AS b ON a.code_user = b.code_user 
										INNER JOIN tb_user AS c ON a.code_user = c.code_user 
										WHERE a.id_events = '".$blogid."'",
										"a.code_user as code,a.id_events AS id,a.title_events AS title,a.date_events AS date,a.content_events AS content,
										a.pic_events AS pic,b.nm_emp AS emp,a.stat_events AS stat,
										b.id_emp as idemp,  b.title_emp as titleemp, b.about_emp as about, c.ava_user as ava,b.facebook_emp as facebook,b.twitter_emp as twitter,b.linkedin_emp as linkedin, b.gplus_emp as gplus","");
		
		$output['relevents']=$this->Mmain->qRead(
										"tb_events AS a INNER JOIN tb_emp AS b ON a.code_user = b.code_user WHERE NOT a.id_events = '".$blogid."' AND a.stat_events =1 LIMIT 0,6 ",
										"a.id_events AS id,a.title_events AS title","");
	
	
		$this->fn->addViewCount($blogid);
				
		$this->load->view('Blogdetail',$output);
		
		
	}
	
	public function Addcomment($blogid)
	{
		
		$this->load->database();
		$this->load->model('Mmain');
		
		//retrieve values
		$inpTemp[0]=$this->input->post('txtname');
		$inpTemp[1]=$this->input->post('txtemail');
		$inpTemp[2]=$this->input->post('txtmessage');
		$newId=$this->Mmain->autoId("tb_comment","id_comment","C","C0001","0001");	
		$savValTemp=Array(
							$newId,
							$blogid,
							date("Y-m-d"),
							date("h:i:s"),
							$inpTemp[0],
							$inpTemp[2],
							$inpTemp[1],
							0
							);
		//echo implode("<br>",$savValTemp);
		//save to database
		$this->Mmain->qIns("tb_comment",$savValTemp);
		
		//redirect to form
		redirect("Blog/Det/".$blogid,'refresh');
		
	}
	
	/* recaptcha
	<?php
  function errorResponse ($messsage) {
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(array('message' => $messsage)));
  }

  
  function constructMessageBody () {
    $fields_req =  array("name" => true, "email" => true, "message" => true);
    $message_body = "";
    foreach ($fields_req as $name => $required) {
      $postedValue = $_POST[$name];
      if ($required && empty($postedValue)) {
        errorResponse("$name is empty.");
      } else {
        $message_body .= ucfirst($name) . ":  " . $postedValue . "\n";
      }
    }
    return $message_body;
  }

  header('Content-type: application/json');

  //do Captcha check, make sure the submitter is not a robot:)...
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => http_build_query(array('secret' => getenv('RECAPTCHA_SECRET_KEY'), 'response' => $_POST["g-recaptcha-response"]))
    )
  );
  $context  = stream_context_create($opts);
  $result = json_decode(file_get_contents($url, false, $context, -1, 40000));

  if (!$result->success) {
    errorResponse('reCAPTCHA checked failed! Error codes: ' . join(', ', $result->{"error-codes"}));
  }
  //attempt to send email
  $messageBody = constructMessageBody();
  require './vender/php_mailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;
  $mail->CharSet = 'UTF-8';
  $mail->isSMTP();
  $mail->Host = getEnv('FEEDBACK_HOSTNAME');
  if (!getenv('FEEDBACK_SKIP_AUTH')) {
    $mail->SMTPAuth = true;
    $mail->Username = getenv('FEEDBACK_EMAIL');
    $mail->Password = getenv('FEEDBACK_PASSWORD');
  }
  if (getenv('FEEDBACK_ENCRYPTION') == 'TLS') {
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
  } elseif (getenv('FEEDBACK_ENCRYPTION') == 'SSL') {
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
  }

  $mail->Sender = getenv('FEEDBACK_EMAIL');
  $mail->setFrom($_POST['email'], $_POST['name']);
  $mail->addAddress(getenv('FEEDBACK_EMAIL'));

  $mail->Subject = $_POST['reason'];
  $mail->Body  = $messageBody;


  //try to send the message
  if($mail->send()) {
    echo json_encode(array('message' => 'Your message was successfully submitted.'));
  } else {
    errorResponse('An expected error occured while attempting to send the email: ' . $mail->ErrorInfo);
  }
?>
	*/
}
