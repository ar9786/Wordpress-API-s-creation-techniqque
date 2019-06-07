<?php
require dirname(__FILE__)."/header_section.html";
global $wpdb;
//echo "SELECT * FROM wp_mobile_notifications where status = CURDATE()";exit;
$aws = $wpdb->get_results ("SELECT max(counts) cnt,post_id,DATE_FORMAT(created_at,'%Y-%m-%d') dte FROM wp_post_views where created_at >= DATE_ADD(NOW(), INTERVAL -3 DAY) and created_at <=  DATE_ADD(CURDATE(), INTERVAL 1 DAY) group by DATE_FORMAT(created_at, '%Y-%m-%d') order by DATE_FORMAT(created_at, '%Y-%m-%d') ASC");
$labels = array();
$data = array();
foreach($aws as $val){
	$labels[] = $val->dte;
	$data[] = $val->cnt;
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <canvas id="post-chart" width="800" height="450"></canvas>
    </div>
    <div class="col-sm-6">
      
    </div>
  </div>
</div>
<script>
new Chart(document.getElementById("post-chart"), {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [
        {
          label: "Total Views",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: <?php echo json_encode($data); ?>
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted top viewd post'
      }
    }
});
</script>