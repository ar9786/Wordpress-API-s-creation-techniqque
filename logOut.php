<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$getData = array();
if ($_SERVER['REQUEST_METHOD'] == POST){
	include(dirname(__FILE__)."/authentication.php");
	$data = json_decode(file_get_contents('php://input'),TRUE);
	if (!isset($data['user_id']) || $data['user_id'] == "") {
			$failed = 1;
			$errors["error"] = "User ID is missing";
	}
	if (!isset($data['type']) || $data['type'] == "") {
			$failed = 1;
			$errors["error"] = "Device type is missing";
	}
	if(!$failed){
		
		$wpdb->query("delete from wp_users_token where user_id = $user_id AND type = '$data[type]'");
		$getData['message'] = "Logout Successfully";
		$getData['data'] = [];
		$getData['status'] = true;
		echo json_encode($getData);
	}
}
if($failed) {
	$getData['message'] = $errors['error'];
	$getData['data'] = '';
	$getData['status'] = false;
	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($getData);
}
