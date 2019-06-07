<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$data= array();
if ($_SERVER['REQUEST_METHOD'] == POST ){
	include(dirname(__FILE__)."/authentication.php");
	$data = json_decode(file_get_contents('php://input'),TRUE);
	if(!isset($data["user_name"]) || $data["user_name"] == ''){
		$failed = 1;
		$errors['error'] = "Username is Required.";
	}
	$user_details = $wpdb->get_results("select * from wp_users where (user_login = '$data[user_name]') OR (user_email = '$data[user_name]')");
	if($wpdb->num_rows == 1){
		$name = $user_details[0]->display_name;
		$email = $user_details[0]->user_email;
		
		//php mailer variables
		//$to = $email;
		$to = "mcoderz87@gmail.com";
		//contactus@weekinchina.com
		$from = "Homelife<homelifeapp@spicaworks.com>";
		$subject = "Your username reminder -- sent from Week in China";
		$headers = 'From: '. $from . "\r\n" .
		'Reply-To: ' . $from . "\r\n";
		$headers .= "Content-type: text/html\r\n";


		//Here put your Validation and send mail
		//$sent = wp_mail($to, $subject, strip_tags($message), $headers);
		
	
		// Mail SMTP configuration
		$from1 = "contactus@weekinchina.com";
		$from2 = "HomeLife";
		$addAddress = $email;
		$subject = "Your username reminder -- sent from Homelife";
		$content = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>HomeLife</title>
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" style="background-color: #0862a9; font: 14px arial,sans-serif; padding: 20px; color: #333333; border: 1px solid #DDDDDD; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;font-size-adjust: none; font-stretch: normal;width:100%;max-width: 660px;">
	  <tbody>
	    <tr>
	    	<td>
	    		<table style="border-spacing: 0;" width="100%">
	    			<tbody>
	    				<tr>
	    				  <td align="center" style="margin: 0px; font-family: arial,sans-serif;" valign="top">
	    				    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100%;padding: 30px;background-color: #ffffff;">
	    				      <tbody>
	    				        <tr>
	    				          <td align="left" style="margin: 0px; padding: 5px 0px 10px; font-size: 14px" valign="top">
	    				            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	    				              <tbody>
	    				                <tr>
	    				                  <td align="left" colspan="12" style="text-align: center;" valign="top"><img alt="bidinline Logo" src="http://homelifeaccess.com/wp-content/uploads/2018/08/logo.png"></td>
	    				                </tr>
	    				              </tbody>
	    				            </table>
	    				          </td>
	    				        </tr>
	    				        <tr>
	    				          <td align="left" style="margin: 0px; font-size: 14px" valign="top" width="100%">
	    				            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	    				              <tbody>
	    				                <tr>
	    				                  <td align="left" colspan="12" valign="top" width="100%">
	    				                    <p style="margin: 0;margin-bottom: 20px;">Hi <span><strong> '.$user_details[0]->display_name.'</strong></span>,</p>
	    				                  </td>
	    				                </tr>
	    				                <tr>
	    				                  <td align="left" colspan="12" valign="top" width="100%">
	    				                    <p style="margin: 0;margin-bottom: 20px;">You have asked to retrieve your username for the Week in China website. </p><p>Username: <span><strong> '.$user_details[0]->user_login.'</strong></span></p>
	    				                  </td>
	    				                </tr>
	    				              </tbody>
	    				            </table>
	    				          </td>
	    				        </tr>
	    				        <tr>
	    				          <td>
	    				            <table style="margin-top: 20px;">
	    				              <tbody>
	    				                <tr>
	    				                  <td>
	    				                    <p style="margin: 0;margin-bottom: 5px;font-size: 14px;">Thank You,</p>
	    				                  </td>
	    				                </tr>
	    				                <tr>
	    				                  <td>
	    				                    <p style="margin: 0;font-size: 14px;">Team WeekInChina</p>
	    				                  </td>
	    				                </tr>
	    				              </tbody>
	    				            </table>
	    				          </td>
	    				        </tr>
	    				      </tbody>
	    				    </table>
	    				  </td>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</td>
	    </tr>
	    <tr>
	      <td>
	        <table style="margin-top: 20px;padding: 30px;width: 100%; background-color: #ffffff;">
	          <tbody>
	          	<tr>
	          		<td>
	          			<table style="width: 100%;text-align: center;">
	          				<tbody>
	          					<tr>
	          						<td style="color: #ffffff;">
	          							<ul style="text-align:center;list-style-type: none;padding-left: 0;margin-bottom: 0;">
	          								<li style="display: inline-block;margin-right: 15px;">
	          									<a href="https://itunes.apple.com/app/week-in-china/id441530574?mt=8"><img src="https://www.weekinchina.com/app/themes/wic/images/bu_app-store.png" alt="Facebook" style="border-radius: 8px;"></a>
	          								</li>
	          								
	          							</ul>
	          						</td>
	          					</tr>
	          					<!--<tr>
	          						<td>
	          							<ul style="text-align:center;list-style-type: none;padding-left: 0;margin-bottom: 0;">
	          								<li style="display: inline-block;margin-right: 15px;">
	          									<a href="javascript:void(0);"><img src="http://hireswiftdeveloper.com/alexamedia/wp-content/themes/alexa/images/mailer/google_play.png" alt=""></a>
	          								</li>
	          								<li style="display: inline-block;">
	          									<a href="javascript:void(0);"><img src="http://hireswiftdeveloper.com/alexamedia/wp-content/themes/alexa/images/mailer/app_store.png" alt=""></a>
	          								</li>
	          							</ul>
	          						</td>-->
	          					</tr>
	          				</tbody>
	          			</table>
	          		</td>
	          	</tr>
	          </tbody>
	        </table>
	      </td>
	    </tr>
	  </tbody>
	</table>
</body>
</html>';
		$sent = wp_mail($to, $subject, $content, $headers);
		//include(dirname(__FILE__)."/PHPMailer/sendMail.php");
		//sendMail($mail,$from1,$from2,$addAddress,$subject,$content);
		
		// End SMTP configuration	
		
		$getData['message'] = "Email Sent Successfully";
		$getData['data'] = 	[];
		echo json_encode($getData);
	}else{
		$failed = 1;
		$errors['error'] = "Username is wrong.";
	}
	if($failed) {
		$getData['message'] = $errors['error'];
		$getData['data'] = NULL;
		header("HTTP/1.0 404 Method Not Allowed");
		echo json_encode($getData);
	}
}