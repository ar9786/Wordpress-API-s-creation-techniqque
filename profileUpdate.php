<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$data= array();
if ($_SERVER['REQUEST_METHOD'] == POST ){
	include(dirname(__FILE__)."/authentication.php");
	$data = json_decode(file_get_contents('php://input'),TRUE);
	if(isset($data['first_name']) && $data['first_name']==''){
		$failed = 1;
		$errors['error'] = "First Name is Required.";
	}
	if(isset($data['last_name']) && $data['last_name']==''){
		$failed = 1;
		$errors['error'] = "Last Name is Required.";
	}
	if(isset($data['email_id']) && $data['email_id']==''){
		$failed = 1;
		$errors['error'] = "Email ID is Required.";
	}
	if(!$failed){
		$first_name = $data['first_name'];
		$last_name = $data['last_name'];
		$email_id = $data['user_email'];
		//wp_update_user(array('ID' => $user_id, 'first_name' => $first_name));
		update_user_meta( $user_id, 'first_name', $first_name );
		update_user_meta( $user_id, 'last_name', $last_name );
		wp_update_user(array( 'ID' => $user_id, 'user_email' => $email_id ));
		$getData['message'] = "Updated Successfully";
		$getData['data'] = array();
		$getData['status'] = true;
		echo json_encode($getData);
		die();
	}
	if($failed) {
	$getData['message'] = $errors['error'];
	$getData['data'] = NULL;
	$getData['status'] = false;
	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($getData);
	}
}