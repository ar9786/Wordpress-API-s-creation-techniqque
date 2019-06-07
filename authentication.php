<?php
//$token_id = $_SERVER['HTTP_AUTHORIZATION'];exit;	
$headers = apache_request_headers();
$token_id  = $headers['Authorization'];
$token_details = $wpdb->get_results("select * from wp_users_token where token_id = '$token_id'");
if($wpdb->num_rows == 0){
	header("HTTP/1.0 401 Unauthorized");
	echo json_encode(["message"=>"Unauthorized User"]);
	die;
}else{
	$user_id = $token_details[0]->user_id;
	$user_info = get_userdata($user_id);
}
