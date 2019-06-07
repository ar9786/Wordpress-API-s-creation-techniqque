<?php
include(dirname(__FILE__)."/../wp-load.php");
global $wpdb;
$failed = 0;
$errors = array();
$data= array();
if ($_SERVER['REQUEST_METHOD'] == GET ){
	include(dirname(__FILE__)."/authentication.php");
	$data = json_decode(file_get_contents('php://input'),TRUE);
	$currentYear;
	$currentMonth;
	if(!empty($_GET['mn']) && !empty($_GET['yr'])) {
		$months = !empty($_GET['mn'])?$_GET['mn']:date('m');
		$years = !empty($_GET['yr'])?$_GET['yr']:date('Y');
		$currentYear = $years;
		$currentMonth = $months;
    // echo "test 1"."<br>";   
	}else {
		$currentYear = date('Y');
		$currentMonth = date('m');
    // echo "test 2"."<br>";
	}
	$current_year_current_month = $currentYear.'-'.$currentMonth;
	$previous_month_number = date('m', strtotime(date($current_year_current_month)." -1 month"));
	$previous_month_name = date('F', strtotime(date($current_year_current_month)." -1 month"));
	$next_month_number = date('m', strtotime(date($current_year_current_month)." +1 month"));
	$next_month_name = date('F', strtotime(date($current_year_current_month)." +1 month"));

	$previous_year = date('Y', strtotime(date($current_year_current_month)." -1 month"));
	$next_year = date('Y', strtotime(date($current_year_current_month)." +1 month"));

	$firstDayOfMonth = date($currentYear.'-'.$currentMonth.'-01');
	$lastDayOfMonth = date($currentYear.'-'.$currentMonth.'-t');
	$wp_floor_duty_table = $wpdb->prefix.'floor_duty';
	$slotsDataQuery = 'SELECT * FROM '.$wp_floor_duty_table. ' WHERE MONTH(date) = "'.$currentMonth.'" AND YEAR(date)="'.$currentYear.'" ORDER BY date ASC';
	$slotsDataResults = $wpdb->get_results($slotsDataQuery);
	$slotArray = array();
	foreach ($slotsDataResults as $key => $value) {
		$slotArray[$value->date][$value->slot] = array($value->id, $value->user_id);
	}
	if($slotArray[$value->date]){
	asort($slotArray[$value->date]);
	}else{
		$slotArray[$value->date];
	}
	function x_week_range($date) {
		$ts = strtotime($date);
		$start = (date('w', $ts) == 1) ? $ts : strtotime('last monday', $ts);
		return array(date('Y-m-d', $start),date('Y-m-d', strtotime('next saturday', $start)));
	}
	$week = x_week_range(date($currentYear.'-'.$currentMonth.'-01'));
	$week = $week[0];
	$days_in_month = cal_days_in_month(0, $currentMonth, $currentYear);                        
	$day_of_week = date('l', strtotime($firstDayOfMonth));
	switch ($day_of_week) {
		case "Sunday": $blank = 0;
		break;
		case "Monday": $blank = 1;
		break;
		case "Tuesday": $blank = 2;
		break;
		case "Wednesday": $blank = 3;
		break;
		case "Thursday": $blank = 4;
		break;
		case "Friday": $blank = 5;
		break;
		case "Saturday": $blank = 6;
		break;
	}
	$day_count = 1;
	$current_date = date('Y-m-d', strtotime($firstDayOfMonth . '+'.($day_num-1).' day'));
	$day_of_date = date('l', strtotime($current_date));
	$day=0;
	function web_safe_colors() {
		$ray = array();
		$steps = array(
			'00',
			'33',
			'66',
			'99',
			'cc',
			'ff' );
    foreach ( $steps as $r ) {
        foreach ( $steps as $g ) {
            foreach ( $steps as $b ) {
                $ray[] = $r . $g . $b;
            }
        }
    }
    return $ray;
	}
	$color_list = web_safe_colors();
	$prvos_yr = site_url().'/Mobile-API/floorDuty.php/?mn='.$previous_month_number.'&yr='.$previous_year;
	$currnt_yr = date('F, Y', strtotime($currentYear."-".$currentMonth."-01"));
	$next_yrr = site_url().'/Mobile-API/floorDuty.php/?mn='.$next_month_number.'&yr='.$next_year;
	
	while ($blank > 0) {
		if($day_count == 1) { 
		$arr_flor_duty["first"][] = array("day_name"=>$day_num,"day_1"=>"9-11","day_2"=>"11-1","day_3"=>"1-3","day_4"=>"3-5");
	} else {
		//$arr_flor_duty[] = "blank";
	}
	$blank = $blank - 1;
	$day_count++;
	}
	$day_num = 1;
    while($day_num <= $days_in_month) {

		$current_date = date('Y-m-d', strtotime($firstDayOfMonth . '+'.($day_num-1).' day'));
		$day_of_date = date('l', strtotime($current_date));
		$slot_array = array("9-11","11-1","1-3","3-5");
		if($day_count == 1) {
			
		}
		if(date('l',strtotime($current_date)) == 'Sunday') {
		$arr_flor_duty["first"][] = array("day_name"=>$day_num,"day_1"=>"9-11","day_2"=>"11-1","day_3"=>"1-3","day_4"=>"3-5");
		} else {
			$day_num;
			$hj = 0;
			for ($i=1; $i <= 4; $i++) {
			$user_id = $slotArray[$current_date][$i][1];
				if($user_id) { 
				$arr_flor_duty["month"]["d".$day_num][] = array("slot_time"=>$slot_array[$hj],"name"=>get_userdata($user_id)->first_name.' '.get_userdata($user_id)->last_name,"email"=>get_userdata($user_id)->user_email,"phone_no"=>get_user_meta($user_id,'phone_no',true),"url"=>site_url().'/Mobile-API/floorDutySingle.php/?id='.$slotArray[$current_date][$i][0]);
				$hj++;
				}
			}
		}
		$day_num++;
		$day_count++;
		if ($day_count > 7) {
			$day_count = 1;
		}
    }
	$getData = array("prvos_yr"=>$prvos_yr,"currnt_yr"=>$currnt_yr,"next_yrr"=>$next_yrr,"arr_flor_duty"=>$arr_flor_duty);
	echo json_encode($getData);
}