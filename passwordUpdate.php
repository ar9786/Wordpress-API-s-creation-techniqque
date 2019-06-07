<?php
include(dirname(__FILE__)."/../wp-load.php");

include_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "wp-includes" . DIRECTORY_SEPARATOR . "class-phpass.php");

global $wpdb;
$failed = 0;
$errors = array();
$data= array();
if ($_SERVER['REQUEST_METHOD'] == POST ){
	include(dirname(__FILE__)."/authentication.php");
	$data = json_decode(file_get_contents('php://input'),TRUE);
	
	//wp_update_user(array( 'ID' => $user_id, 'user_pass' => $data['password'] ));
	//exit;
	if(isset($data['current_password']) && $data['current_password']==''){
		$failed = 1;
		$errors['error'] = "Current Password is Required.";
	}
	if(isset($data['password']) && $data['password']==''){
		$failed = 1;
		$errors['error'] = "Password is Required.";
	}
	if(isset($data['confirm_password']) && $data['confirm_password']==''){
		$failed = 1;
		$errors['error'] = "Confirm Password is Required.";
	}
	if($data['password'] != $data['confirm_password']){
		$failed = 1;
		$errors['error'] = "Password not matched.";
	}
	
	if(!$failed){
		$current_password = $data['current_password'];
		$password = $data['password'];
		$confirm_password = $data['confirm_password'];
		
		$password_hashed = $user_info->user_pass;
		$wp_hasher = new PasswordHash(8, TRUE);
		if($wp_hasher->CheckPassword($current_password, $password_hashed)) {
			wp_update_user(array( 'ID' => $user_id, 'user_pass' => $password ));
			$getData['message'] = "Password Updated Successfully";
			$getData['data'] = array();
			$getData['status'] = true;
			echo json_encode($getData);
			die();
		} else {
			$failed = 1;
			$errors['error'] = "Current Password is Incorrect.";						
		}
	}
	if($failed) {
	$getData['message'] = $errors['error'];
	$getData['data'] = NULL;
	$getData['status'] = false;
	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($getData);
	}
}