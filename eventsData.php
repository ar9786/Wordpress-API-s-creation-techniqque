<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$data= array();
if ($_SERVER['REQUEST_METHOD'] == GET ){
	include(dirname(__FILE__)."/authentication.php");
	$event_tax_query =  new EE_Event_List_Query( $atts );
	print_r($categories);
}