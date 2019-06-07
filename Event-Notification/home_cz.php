<?php
require dirname(__FILE__)."/header_section.html";
global $wpdb;
if(isset($_POST['special-edition-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	if($content == '' || $text == ''){
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully uploaded';
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	$wpdb->query("insert into wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type'");
	}
}
if(isset($_POST['special-edition-update-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	if($_POST['update_img'] == ''){
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	}else{
			$image_name = $_POST['update_img'];
	}	
	if($content == '' || $text == ''){
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully updated';
	$id = $_POST['update_case'];
	$wpdb->query("update wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type' where id='$id'");
	}
}
if(isset($_POST['wic-news-update-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	if($_POST['update_img'] == ''){
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	}else{
			$image_name = $_POST['update_img'];
	}	
	if($content == '' || $text == ''){
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully updated';
	$id = $_POST['update_case'];
	$wpdb->query("update wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type' where id='$id'");
	}
}
if(isset($_POST['wic-news-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	if($content == '' || $text == '' ) {
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully uploaded';
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	$wpdb->query("insert into wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type'");
	}
}
if(isset($_POST['editor-pic-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	if($content == '' || $text == '') {
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully uploaded';
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	$wpdb->query("insert into wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type'");
	}
}
if(isset($_POST['editor-pic-update-cdz'])){
	$valid_file = 1;
	$text = trim($_POST['text']);
	$content = trim($_POST['content']);
	$event_type = trim($_POST['event_type']);
	$new_file_name = strtolower($_FILES['image']['tmp_name']); //rename file
	if($_POST['update_img'] == ''){
	if($_FILES['image']['size'] > (3024000)) {
		$valid_file = false;
		$message = 'Oops! Your file\'s size is to large.';
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	if(!in_array($extension,$allowedExts)){
		$valid_file = false;
		$message = 'Only supports gif,jpeg,jpg,png';
	}
	$image_name = rand().time().'mcdz.'.$extension;
	$image_path = plugin_dir_path( __FILE__ ) . "assets/images/";
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path.$image_name);
	}else{
			$image_name = $_POST['update_img'];
	}	
	if($content == '' || $text == ''){
		$valid_file = false;
		$message = 'All fields required';
	}
	if($valid_file == 1 ){
	$message = 'Successfully updated';
	$id = $_POST['update_case'];
	$wpdb->query("update wp_event_notifmcz set text='$text',image='$image_name',content='$content',event_type='$event_type' where id='$id'");
	}
}
if(isset($message)){
echo '<div class="error"> '.$message.'</div>';
}	 ?>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<h2>Event</H2>
			<select name="" id="cdz_event" class="form-control">
				<option value="0">Select Event</option>
				<option value="1">Special editions</option>
				<option value="2">WiC news</option>
				<option value="3">Editor's picks</option>
			</select>
		</div>
	</div>
	<!-- Special Edition -->


	<div class="col-sm-8">
	<div class="special-edition-cdz" id="special-edition-cdz" style="display:none" >
		<h3>Special editions</h3>
		<form class="form-group" action="" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input type="text" name="text"  class="form-control" placeholder="Title">
		</div>
		<div class="form-group">
			<p>Image <input type="file" name="image" class="form-control"/></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" name="content" class="form-control" rows="10" ></textarea>
		</div>
		<input type="hidden" name="event_type" value="1">
		<input type="submit" name="special-edition-cdz">
		</form>
	</div>
	<div class="special-edition-update-cdz" id="special-edition-update-cdz" style="display:none" >
		<h3>Special editions</h3>
		<form class="form-group" action="" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input type="text" name="text" id="text_cdz" class="form-control" placeholder="Title">
		</div>
		<div class="form-group">
			<p>Image <input type="file" name="image" class="form-control"/></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" name="content" class="form-control" rows="10" id="content_cdz"></textarea>
		</div>
		<input type="hidden" name="update_img" id="img_cdz">
		<input type="hidden" name="update_case" id="update_case">
		<input type="hidden" name="event_type" value="1">
		<input type="submit" name="special-edition-update-cdz">
		</form>
	</div>
	
	<!-- Wic News -->
	<div class="wic-news-cdz" id="wic-news-update-cdz" style="display:none">
	<h3>WiC news</h3>
		<form class="form-group" action="" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Title" name="text" id="text_cdz2" >
		</div>
		<div class="form-group">
			<p>Image <input type="file" class="form-control" name="image"  /></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" class="form-control" id="content_cdz2" name="content" rows="10"></textarea>
		</div>
		<input type="hidden" name="update_img" id="img_cdz2"/>
		<input type="hidden" name="update_case" id="update_case2"/>
		<input type="hidden" name="event_type" value="2"/>
		<input type="submit" name="wic-news-update-cdz"/>
		</form>
	</div>
	<div class="wic-news-update-cdz" id="wic-news-cdz" style="display:none">
	<h3>WiC news</h3>
		<form class="form-group" action=""   method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input type="text" id="text_cdz" class="form-control" placeholder="Title" name="text">
		</div>
		<div class="form-group">
			<p>Image <input type="file" class="form-control" name="image"/></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" id="content_cdz" class="form-control" name="content" rows="10"></textarea>
		</div>
		<input type="hidden" name="event_type" value="2">
		<input type="submit" name="wic-news-cdz">
		</form>
	</div>
	<!-- Editor Pic -->
	<div class="editor-pic-cdz" id="editor-pic-cdz" style="display:none">
	<h3>Editor's picks</h3>
		<form class="form-group" action=""  method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input class="form-control" type="text" value="" placeholder="Title" name="text">
		</div>
		<div class="form-group">
			<p>Image <input type="file" class="form-control" name="image"/></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" class="form-control" name="content" rows="10"></textarea>
		</div>
		<input type="hidden" name="event_type" value="3">
		<input type="submit" name="editor-pic-cdz">
		</form>
	</div>
	<div class="editor-pic-cdz" id="editor-pic-update-cdz" style="display:none">
	<h3>Editor's picks</h3>
		<form class="form-group" action=""  method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<input class="form-control" type="text" value="" placeholder="Title" name="text" id="text_cdz3">
		</div>
		<div class="form-group">
			<p>Image <input type="file" class="form-control" name="image"/></p>
		</div>
		<div class="form-group">
			<textarea placeholder="Content" class="form-control" name="content" rows="10" id="content_cdz3" ></textarea>
		</div>
		<input type="hidden" name="update_img" id="img_cdz3"/>
		<input type="hidden" name="update_case" id="update_case3"/>
		<input type="hidden" name="event_type" value="3">
		<input type="submit" name="editor-pic-update-cdz">
		</form>
	</div>
	</div>
</div>
<?php
$heder_add = $wpdb->get_results("select * from  wp_event_notifmcz where status = 1 ");
$img_url = get_template_directory_uri().'/Event-Notification/assets/images/';
?>

<div class="container" style="padding: 32px 0px 0px 0px;">
	<div class="table-responsive">          
		<table id="adds_content" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="width:100%">
				<thead>
					<tr>
						<th>Title</th>
						<th>Content</th>
						<th>Image</th>
						<th>Created</th>
						<th>Edit</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($heder_add as $header_add){
						  $status = $header_add->status == 1 ? 'Active':'Inactive';
					?>	
						<tr data-id="<?php echo $header_add->id; ?>" data-text = "<?php echo $header_add->text; ?>" data-content ="<?php echo $header_add->content; ?>" data-image = "<?php echo $header_add->image; ?>" data-event = "<?php echo $header_add->event_type; ?>">
						<td><?php echo $header_add->text; ?></td>
						<td><?php echo substr(strip_tags($header_add->content),0,100); ?>..</td>
						<td><img src="<?php echo $img_url.$header_add->image; ?>" height="100" width="100"></td>
						<td><?php echo date('d-M,Y',strtotime($header_add->created_at)); ?></td>
						<td class="row_id_update"><a href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a></td>
						<td><?php echo $status; ?></td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th>Title</th>
						<th>Content</th>
						<th>Image</th>
						<th>Created</th>
						<th>Edit</th>
						<th>Status</th>
					</tr>
				</tfoot>
		</table>
	</div>
</div>
<?php
/*
add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {

		var dataTable = jQuery('#adds_content').DataTable( {
			"processing" : true,
			"serverSide" : true,
			"ajax" : {
			'action': 'my_action',
			type: 'POST'
			},
		});
		var data = {
			'action': 'my_action',
			'whatever': 1234
		};
		
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
	});
	</script>
<?php } ?>
<script>
jQuery(document).ready(function() {
    var dataTable = jQuery('#adds_content').DataTable( {
		"processing" : true,
        "serverSide" : true,
        "ajax" : {
			url : "<?php echo get_template_directory_uri(); ?>/Event-Noification/listing_event_cz.php",
			type: 'POST'
		},
    });
});*/ ?>
<script>

jQuery(document).ready(function () {
	jQuery('.row_id_update').click(function(){
		var this_id = $(this).closest('tr').attr('data-id');
		var text = $(this).closest('tr').attr('data-text');
		var content = $(this).closest('tr').attr('data-content');
		var image = $(this).closest('tr').attr('data-image');
		var event = $(this).closest('tr').attr('data-event');
		if(event == 1){
			jQuery('#special-edition-update-cdz').show();
			jQuery('#wic-news-update-cdz').hide();
			jQuery('#editor-pic-update-cdz').hide();
			
			jQuery('#text_cdz').val(text);
			jQuery('#content_cdz').val(content);
			jQuery('#img_cdz').val(image);
			jQuery('#update_case').val(this_id);
			
		}
		if(event == 2){
			jQuery('#special-edition-update-cdz').hide();
			jQuery('#wic-news-update-cdz').show();
			jQuery('#editor-pic-update-cdz').hide();
			
			jQuery('#text_cdz2').val(text);
			jQuery('#content_cdz2').val(content);
			jQuery('#img_cdz2').val(image);
			jQuery('#update_case2').val(this_id);
		}
		if(event == 3){
			jQuery('#special-edition-update-cdz').hide();
			jQuery('#wic-news-update-cdz').hide();
			jQuery('#editor-pic-update-cdz').show();
			
			jQuery('#text_cdz3').val(text);
			jQuery('#content_cdz3').val(content);
			jQuery('#img_cdz3').val(image);
			jQuery('#update_case3').val(this_id);
		}
	});
	jQuery('#adds_content').DataTable({
		"pagingType": "full" // "simple" option for 'Previous' and 'Next' buttons only
	});
	jQuery('.dataTables_length').addClass('bs-select');

	jQuery('#cdz_event').change(function(){
		cdz_event = jQuery(this).val();
		if(cdz_event == '0'){
			jQuery('#special-edition-cdz').hide();
			jQuery('#wic-news-cdz').hide();
			jQuery('#editor-pic-cdz').hide();
		}
		if(cdz_event == '1'){
			jQuery('#special-edition-cdz').show();
			jQuery('#wic-news-cdz').hide();
			jQuery('#editor-pic-cdz').hide();
		}
		if(cdz_event == '2'){
			jQuery('#wic-news-cdz').show();
			jQuery('#special-edition-cdz').hide();
			jQuery('#editor-pic-cdz').hide();
		}
		if(cdz_event == '3'){
			jQuery('#editor-pic-cdz').show();
			jQuery('#special-edition-cdz').hide();
			jQuery('#wic-news-cdz').hide();
		}
	});
});
</script>