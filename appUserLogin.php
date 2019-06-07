<?php
include(dirname(__FILE__)."/../wp-load.php");
include_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "wp-includes" . DIRECTORY_SEPARATOR . "class-phpass.php");
global $wpdb;
$failed = 0;
$errors = array();
$getData = array();
if ($_SERVER['REQUEST_METHOD'] == POST){
	$data = json_decode(file_get_contents('php://input'),TRUE);
	if(!isset($data["user_name"]) || $data["user_name"] == ''){
		$failed = 1;
		$errors['error'] = "Username is Required.";
	}
	if(!isset($data["password"]) || $data["password"] == ''){
		$failed = 1;
		$errors['error'] = "Password is Required.";
	}
	if (!isset($data['type']) || $data['type'] == "") {
			$failed = 1;
			$errors["error"] = "Device type is missing";
	}
	$wp_hasher = new PasswordHash(8, TRUE);
	$password = $data["password"];
	$user_details = $wpdb->get_results("select * from wp_users where (user_login = '$data[user_name]') OR (user_email = '$data[user_name]')");
	if($wpdb->num_rows == 1){
		if($wp_hasher->CheckPassword($password, $user_details[0]->user_pass)) {
			$user_data = array();
			foreach($user_details as $key){
				$user_data["user_ID"] = (int)$key->ID;
				$user_data["user_login"] = 	$key->user_login;
				$user_data["display_name"] = $key->display_name;
				$user_data["user_email"] = $key->user_email;
			}
			include(dirname(__FILE__)."/jwttoken.php");
			//include(dirname(__FILE__)."/notifiStatus.php");
			$getData['message'] = "Logged In Successfully";
			$getData['data'] = 	$user_data;
			//$getData['notify_status'] = $notify_status;
			echo json_encode($getData);
		}else{		
			$failed = 1;
			$errors['error'] = "Password is wrong.";
		}
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