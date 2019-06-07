<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$getData = array();
if ($_SERVER['REQUEST_METHOD'] == GET){
	include(dirname(__FILE__)."/authentication.php");
	//$data = json_decode(file_get_contents('php://input'),TRUE);
	$categories = get_categories( array(
	'orderby' => 'name',
	'order'   => 'ASC',
	'taxonomy'     => 'category',
	'show_count'   => 0, // 1 for yes, 0 for no
	'pad_counts'   => 0,
	'hierarchical' => 0,
	'title_li'     => '',
	'hide_empty'   => 1,
	'post_type'     => 'post'
	) );
	$jk=1;
	foreach($categories as $category) {
		if($jk<10){
	  $cat["cat_details"][] =  array("cat_id" => $category->cat_ID ,"cat_name" => htmlspecialchars_decode ($category->name),"cat_link" => get_category_link($category->term_id) );
		}$jk++;
	}
	$data['message'] = "All Categories";
	$data['data']['cat_details'] = $cat["cat_details"];
	if($failed) {
			header("HTTP/1.0 404 Method Not Allowed");
			$data['message'] = $errors['error'];
			$data['data'] = "";
			$data['status'] = false;
	}
}
echo json_encode($data);