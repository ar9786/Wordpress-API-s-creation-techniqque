<?php
$device_id = $data["device_id"];
$user_id = $user_details[0]->ID;
$type = $data['type'];
$token_details = $wpdb->get_results("select * from wp_users_token where user_id = '$user_id' and type='$type' ");
if($wpdb->num_rows == 1){
	$user_data["token_key"] = $token_details[0]->token_id;
}else{
	$user_data["token_key"]= jsonwebtoken($user_id);
	$wpdb->query("insert into wp_users_token set user_id = '$user_id',device_id = '$device_id',token_id = '".$user_data["token_key"]."',type='$type'");
}
function jsonwebtoken($user_id){
// Create token header as a JSON string
$header = json_encode(['typ' => 'JWT', 'alg' => rand(0, 999999999)]);

// Create token payload as a JSON string
$payload = json_encode(['user_id' => $user_id]);

// Encode Header to Base64Url String
$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

// Encode Payload to Base64Url String
$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

// Create Signature Hash
$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

// Encode Signature to Base64Url String
$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

// Create JWT
$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

return $jwt;
}