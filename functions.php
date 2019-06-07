<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

//automatic_feed_links();

/*
add_action('init','possibly_redirect');

function possibly_redirect(){
	global $pagenow;
	if ( 'wp-login.php' == $pagenow ) {
		if ($_GET['action'] == 'register') {
			wp_redirect('http://www.weekinchina.com/welcome/');
			exit();
		} 
 	}
}
*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' =>__( 'Article page sidebar', 'wic'),
		'id' => 'sidebar-2',
		'description' => __( 'Appears on the article page template', 'wic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

/** @ignore */
function kubrick_head() {
	$head = "<style type='text/css'>\n<!--";
	$output = '';
	if ( kubrick_header_image() ) {
		$url =  kubrick_header_image_url() ;
		$output .= "#header { background: url('$url') no-repeat bottom center; }\n";
	}
	if ( false !== ( $color = kubrick_header_color() ) ) {
		$output .= "#headerimg h1 a, #headerimg h1 a:visited, #headerimg .description { color: $color; }\n";
	}
	if ( false !== ( $display = kubrick_header_display() ) ) {
		$output .= "#headerimg { display: $display }\n";
	}
	$foot = "--></style>\n";
	if ( '' != $output )
		echo $head . $output . $foot;
}

add_action('wp_head', 'kubrick_head');

function kubrick_header_image() {
	return apply_filters('kubrick_header_image', get_option('kubrick_header_image'));
}

function kubrick_upper_color() {
	if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
		parse_str(substr($url, strpos($url, '?') + 1), $q);
		return $q['upper'];
	} else
		return '69aee7';
}

function kubrick_lower_color() {
	if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
		parse_str(substr($url, strpos($url, '?') + 1), $q);
		return $q['lower'];
	} else
		return '4180b6';
}

function kubrick_header_image_url() {
	if ( $image = kubrick_header_image() )
		$url = get_template_directory_uri() . '/images/' . $image;
	else
		$url = get_template_directory_uri() . '/images/kubrickheader.jpg';

	return $url;
}

function kubrick_header_color() {
	return apply_filters('kubrick_header_color', get_option('kubrick_header_color'));
}

function kubrick_header_color_string() {
	$color = kubrick_header_color();
	if ( false === $color )
		return 'white';

	return $color;
}

function kubrick_header_display() {
	return apply_filters('kubrick_header_display', get_option('kubrick_header_display'));
}

function kubrick_header_display_string() {
	$display = kubrick_header_display();
	return $display ? $display : 'inline';
}

add_action('admin_menu', 'kubrick_add_theme_page');

function kubrick_add_theme_page() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
			check_admin_referer('kubrick-header');
			if ( isset($_REQUEST['njform']) ) {
				if ( isset($_REQUEST['defaults']) ) {
					delete_option('kubrick_header_image');
					delete_option('kubrick_header_color');
					delete_option('kubrick_header_display');
				} else {
					if ( '' == $_REQUEST['njfontcolor'] )
						delete_option('kubrick_header_color');
					else {
						$fontcolor = preg_replace('/^.*(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['njfontcolor']);
						update_option('kubrick_header_color', $fontcolor);
					}
					if ( preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njuppercolor'], $uc) && preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njlowercolor'], $lc) ) {
						$uc = ( strlen($uc[0]) == 3 ) ? $uc[0]{0}.$uc[0]{0}.$uc[0]{1}.$uc[0]{1}.$uc[0]{2}.$uc[0]{2} : $uc[0];
						$lc = ( strlen($lc[0]) == 3 ) ? $lc[0]{0}.$lc[0]{0}.$lc[0]{1}.$lc[0]{1}.$lc[0]{2}.$lc[0]{2} : $lc[0];
						update_option('kubrick_header_image', "header-img.php?upper=$uc&lower=$lc");
					}

					if ( isset($_REQUEST['toggledisplay']) ) {
						if ( false === get_option('kubrick_header_display') )
							update_option('kubrick_header_display', 'none');
						else
							delete_option('kubrick_header_display');
					}
				}
			} else {

				if ( isset($_REQUEST['headerimage']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['headerimage'] )
						delete_option('kubrick_header_image');
					else {
						$headerimage = preg_replace('/^.*?(header-img.php\?upper=[0-9a-fA-F]{6}&lower=[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['headerimage']);
						update_option('kubrick_header_image', $headerimage);
					}
				}

				if ( isset($_REQUEST['fontcolor']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['fontcolor'] )
						delete_option('kubrick_header_color');
					else {
						$fontcolor = preg_replace('/^.*?(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['fontcolor']);
						update_option('kubrick_header_color', $fontcolor);
					}
				}

				if ( isset($_REQUEST['fontdisplay']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['fontdisplay'] || 'inline' == $_REQUEST['fontdisplay'] )
						delete_option('kubrick_header_display');
					else
						update_option('kubrick_header_display', 'none');
				}
			}
			//print_r($_REQUEST);
			wp_redirect("themes.php?page=functions.php&saved=true");
			die;
		}
		add_action('admin_head', 'kubrick_theme_page_head');
	}
	add_theme_page(__('Custom Header'), __('Custom Header'), 'edit_themes', basename(__FILE__), 'kubrick_theme_page');
}

function kubrick_theme_page_head() {
?>
<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
<script type='text/javascript'>
// <![CDATA[
	function pickColor(color) {
		ColorPicker_targetInput.value = color;
		kUpdate(ColorPicker_targetInput.id);
	}
	function PopupWindow_populate(contents) {
		contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" class="button-secondary" value="<?php esc_attr_e('Close Color Picker'); ?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
		this.contents = contents;
		this.populated = false;
	}
	function PopupWindow_hidePopup(magicword) {
		if ( magicword != 'prettyplease' )
			return false;
		if (this.divName != null) {
			if (this.use_gebi) {
				document.getElementById(this.divName).style.visibility = "hidden";
			}
			else if (this.use_css) {
				document.all[this.divName].style.visibility = "hidden";
			}
			else if (this.use_layers) {
				document.layers[this.divName].visibility = "hidden";
			}
		}
		else {
			if (this.popupWindow && !this.popupWindow.closed) {
				this.popupWindow.close();
				this.popupWindow = null;
			}
		}
		return false;
	}
	function colorSelect(t,p) {
		if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
			cp.hidePopup('prettyplease');
		else {
			cp.p = p;
			cp.select(t,p);
		}
	}
	function PopupWindow_setSize(width,height) {
		this.width = 162;
		this.height = 210;
	}

	var cp = new ColorPicker();
	function advUpdate(val, obj) {
		document.getElementById(obj).value = val;
		kUpdate(obj);
	}
	function kUpdate(oid) {
		if ( 'uppercolor' == oid || 'lowercolor' == oid ) {
			uc = document.getElementById('uppercolor').value.replace('#', '');
			lc = document.getElementById('lowercolor').value.replace('#', '');
			hi = document.getElementById('headerimage');
			hi.value = 'header-img.php?upper='+uc+'&lower='+lc;
			document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/'+hi.value+'") center no-repeat';
			document.getElementById('advuppercolor').value = '#'+uc;
			document.getElementById('advlowercolor').value = '#'+lc;
		}
		if ( 'fontcolor' == oid ) {
			document.getElementById('header').style.color = document.getElementById('fontcolor').value;
			document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value;
		}
		if ( 'fontdisplay' == oid ) {
			document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
		}
	}
	function toggleDisplay() {
		td = document.getElementById('fontdisplay');
		td.value = ( td.value == 'none' ) ? 'inline' : 'none';
		kUpdate('fontdisplay');
	}
	function toggleAdvanced() {
		a = document.getElementById('jsAdvanced');
		if ( a.style.display == 'none' )
			a.style.display = 'block';
		else
			a.style.display = 'none';
	}
	function kDefaults() {
		document.getElementById('headerimage').value = '';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#69aee7';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#4180b6';
		document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/kubrickheader.jpg") center no-repeat';
		document.getElementById('header').style.color = '#FFFFFF';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '';
		document.getElementById('fontdisplay').value = 'inline';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kRevert() {
		document.getElementById('headerimage').value = '<?php echo esc_js(kubrick_header_image()); ?>';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#<?php echo esc_js(kubrick_upper_color()); ?>';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#<?php echo esc_js(kubrick_lower_color()); ?>';
		document.getElementById('header').style.background = 'url("<?php echo esc_js(kubrick_header_image_url()); ?>") center no-repeat';
		document.getElementById('header').style.color = '';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '<?php echo esc_js(kubrick_header_color_string()); ?>';
		document.getElementById('fontdisplay').value = '<?php echo esc_js(kubrick_header_display_string()); ?>';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kInit() {
		document.getElementById('jsForm').style.display = 'block';
		document.getElementById('nonJsForm').style.display = 'none';
	}
	addLoadEvent(kInit);
// ]]>
</script>
<style type='text/css'>
	#headwrap {
		text-align: center;
	}
	#kubrick-header {
		font-size: 80%;
	}
	#kubrick-header .hibrowser {
		width: 780px;
		height: 260px;
		overflow: scroll;
	}
	#kubrick-header #hitarget {
		display: none;
	}
	#kubrick-header #header h1 {
		font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-weight: bold;
		font-size: 4em;
		text-align: center;
		padding-top: 70px;
		margin: 0;
	}

	#kubrick-header #header .description {
		font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-size: 1.2em;
		text-align: center;
	}
	#kubrick-header #header {
		text-decoration: none;
		color: <?php echo kubrick_header_color_string(); ?>;
		padding: 0;
		margin: 0;
		height: 200px;
		text-align: center;
		background: url('<?php echo kubrick_header_image_url(); ?>') center no-repeat;
	}
	#kubrick-header #headerimg {
		margin: 0;
		height: 200px;
		width: 100%;
		display: <?php echo kubrick_header_display_string(); ?>;
	}
	#jsForm {
		display: none;
		text-align: center;
	}
	#jsForm input.submit, #jsForm input.button, #jsAdvanced input.button {
		padding: 0px;
		margin: 0px;
	}
	#advanced {
		text-align: center;
		width: 620px;
	}
	html>body #advanced {
		text-align: center;
		position: relative;
		left: 50%;
		margin-left: -380px;
	}
	#jsAdvanced {
		text-align: right;
	}
	#nonJsForm {
		position: relative;
		text-align: left;
		margin-left: -370px;
		left: 50%;
	}
	#nonJsForm label {
		padding-top: 6px;
		padding-right: 5px;
		float: left;
		width: 100px;
		text-align: right;
	}
	.defbutton {
		font-weight: bold;
	}
	.zerosize {
		width: 0px;
		height: 0px;
		overflow: hidden;
	}
	#colorPickerDiv a, #colorPickerDiv a:hover {
		padding: 1px;
		text-decoration: none;
		border-bottom: 0px;
	}
</style>
<?php
}

function kubrick_theme_page() {
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
?>
<div class='wrap'>
	<h2><?php _e('Customize Header'); ?></h2>
	<div id="kubrick-header">
		<div id="headwrap">
			<div id="header">
				<div id="headerimg">
					<h1><?php bloginfo('name'); ?></h1>
					<div class="description"><?php bloginfo('description'); ?></div>
				</div>
			</div>
		</div>
		<br />
		<div id="nonJsForm">
			<form method="post" action="">
				<?php wp_nonce_field('kubrick-header'); ?>
				<div class="zerosize"><input type="submit" name="defaultsubmit" value="<?php esc_attr_e('Save'); ?>" /></div>
					<label for="njfontcolor"><?php _e('Font Color:'); ?></label><input type="text" name="njfontcolor" id="njfontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" /> <?php printf(__('Any CSS color (%s or %s or %s)'), '<code>red</code>', '<code>#FF0000</code>', '<code>rgb(255, 0, 0)</code>'); ?><br />
					<label for="njuppercolor"><?php _e('Upper Color:'); ?></label><input type="text" name="njuppercolor" id="njuppercolor" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
				<label for="njlowercolor"><?php _e('Lower Color:'); ?></label><input type="text" name="njlowercolor" id="njlowercolor" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
				<input type="hidden" name="hi" id="hi" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
				<input type="submit" name="toggledisplay" id="toggledisplay" value="<?php esc_attr_e('Toggle Text'); ?>" />
				<input type="submit" name="defaults" value="<?php esc_attr_e('Use Defaults'); ?>" />
				<input type="submit" class="defbutton" name="submitform" value="&nbsp;&nbsp;<?php esc_attr_e('Save'); ?>&nbsp;&nbsp;" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="njform" value="true" />
			</form>
		</div>
		<div id="jsForm">
			<form style="display:inline;" method="post" name="hicolor" id="hicolor" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>">
				<?php wp_nonce_field('kubrick-header'); ?>
	<input type="button"  class="button-secondary" onclick="tgt=document.getElementById('fontcolor');colorSelect(tgt,'pick1');return false;" name="pick1" id="pick1" value="<?php esc_attr_e('Font Color'); ?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('uppercolor');colorSelect(tgt,'pick2');return false;" name="pick2" id="pick2" value="<?php esc_attr_e('Upper Color'); ?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('lowercolor');colorSelect(tgt,'pick3');return false;" name="pick3" id="pick3" value="<?php esc_attr_e('Lower Color'); ?>"></input>
				<input type="button" class="button-secondary" name="revert" value="<?php esc_attr_e('Revert'); ?>" onclick="kRevert()" />
				<input type="button" class="button-secondary" value="<?php esc_attr_e('Advanced'); ?>" onclick="toggleAdvanced()" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="fontdisplay" id="fontdisplay" value="<?php echo esc_attr(kubrick_header_display()); ?>" />
				<input type="hidden" name="fontcolor" id="fontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" />
				<input type="hidden" name="uppercolor" id="uppercolor" value="<?php echo esc_attr(kubrick_upper_color()); ?>" />
				<input type="hidden" name="lowercolor" id="lowercolor" value="<?php echo esc_attr(kubrick_lower_color()); ?>" />
				<input type="hidden" name="headerimage" id="headerimage" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
				<p class="submit"><input type="submit" name="submitform" class="button-primary" value="<?php esc_attr_e('Update Header'); ?>" onclick="cp.hidePopup('prettyplease')" /></p>
			</form>
			<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
			<div id="advanced">
				<form id="jsAdvanced" style="display:none;" action="">
					<?php wp_nonce_field('kubrick-header'); ?>
					<label for="advfontcolor"><?php _e('Font Color (CSS):'); ?> </label><input type="text" id="advfontcolor" onchange="advUpdate(this.value, 'fontcolor')" value="<?php echo esc_attr(kubrick_header_color()); ?>" /><br />
					<label for="advuppercolor"><?php _e('Upper Color (HEX):');?> </label><input type="text" id="advuppercolor" onchange="advUpdate(this.value, 'uppercolor')" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /><br />
					<label for="advlowercolor"><?php _e('Lower Color (HEX):'); ?> </label><input type="text" id="advlowercolor" onchange="advUpdate(this.value, 'lowercolor')" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /><br />
					<input type="button" class="button-secondary" name="default" value="<?php esc_attr_e('Select Default Colors'); ?>" onclick="kDefaults()" /><br />
					<input type="button" class="button-secondary" onclick="toggleDisplay();return false;" name="pick" id="pick" value="<?php esc_attr_e('Toggle Text Display'); ?>"></input><br />
				</form>
			</div>
		</div>
	</div>
</div>
<?php } 

add_action('template_redirect', 'do_cm_sync');

function do_cm_sync()
{
   global $wp_query;
   if(preg_match('/^unsubscribe\/(.*)/',$wp_query->query['pagename']))
   {
		$email = preg_replace('/^unsubscribe\/(.*)/','$1',$wp_query->query['pagename']);
		include TEMPLATEPATH . "/cm_sync_unsub.php";
		exit;
   }
   elseif(preg_match('/^subscribe\/(.*)/',$wp_query->query['pagename']))
   {
		$email = preg_replace('/^subscribe\/(.*)/','$1',$wp_query->query['pagename']);
		include TEMPLATEPATH . "/cm_sync_sub.php";
		exit;
   }
}


add_filter('query_vars', 'mpage');
function mpage($public_query_vars) {
	$public_query_vars[] = 'mpage';
	return $public_query_vars;
}

function string_trim($string, $trimLength = 40) {
	$string = str_replace('<p>', '', $string);
	$string = preg_replace("/\<div([^>].*)\>([^<]*)<\/div\>/iU", "$2", $string);
	$string = preg_replace("/\<a([^>].*)\>([^<]*)<\/a\>/iU", "$2", $string);
	$length = strlen($string);
  if ($length > $trimLength) {
  	$count = 0;
    $prevCount = 0;
    $array = explode(" ", $string);
    foreach ($array as $word) {
    	$count = $count + strlen($word);
      $count = $count + 1;
      if ($count > ($trimLength - 3)) {
      	return substr($string, 0, $prevCount) . "...";
      }
      $prevCount = $count;
    }
  } else {
  	return $string;
  }
}

if(!function_exists('getPageContent'))
	{
		function getPageContent($pageId,$max_char)
		{
			if(!is_numeric($pageId))
			{
				return;
			}
			global $wpdb;
			$nsquery = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
			' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
			$post_data = $wpdb->get_results($nsquery);
			if(!empty($post_data))
			{
				foreach($post_data as $post)
				{
					$text_out=nl2br($post->post_content);
					$text_out=str_replace('<br />', '', $text_out);
					//$text_out = strip_tags($text_out);
					return substr($text_out,0,$max_char);

				}
			}
		}
}

function vibeExcludePages($query) {
        if ($query->is_search) {
        	$query->set('post_type', 'post');
        }

		switch ( $query->query_vars['category_name'] ) {
	    	case 'regulars/sinofile':
	            $query->set( 'posts_per_page', 4 );
	            break;
	        case 'regulars/cartoon':
	            $query->set( 'posts_per_page', 3 );
	            break;
	        default:
	            break;
    	}

        return $query;
}
add_filter('pre_get_posts','vibeExcludePages');

// Hide backend menu bar for all users except for administrator
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
  	  show_admin_bar(false);
	}
}

// Disable the default WP registration page
add_filter( 'register', 'wic_remove_registration_link' );
function wic_remove_registration_link( $registration_url ) {
	return __( 'Manual registration is disabled', 'wic' );
}
add_action( 'init', 'wic_redirect_registration_page' );
function wic_redirect_registration_page() {
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'register' ) {
		ob_start();
		$login_page = home_url( '/login/' );
		wp_redirect( $login_page );
		ob_clean();
	}
}


// Login without password for the subscribers
function admin_login($user, $username, $password) {
	$login_page  = home_url( '/login/' );
	$referrer = $_SERVER['HTTP_REFERER'];
	$user = get_user_by("login", $username);
	global $pagenow;
	
	if ( strstr($referrer,'/login/') && $username == 'wegerle' ) { // Force the user to logout, if he/she tried to login using Admin account through /login/ page
		wp_logout();
		wp_set_current_user(0);
		wp_redirect( $login_page );
		exit;
	}
 	
	if ( 'wp-login.php' == $pagenow && isset($_GET['redirect_to']) && strpos($_GET['redirect_to'], 'wp-admin') > 0 ) { // Do not redirect WP-ADMIN page to custom login page
		return;
	} elseif ( 'wp-login.php' == $pagenow && !strstr($referrer,'wp-admin') && ($_POST['log'] == '' || empty($user->ID))) { // redirect wp-login.php to /login page
		wp_redirect( $login_page );
	}
	
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $_POST['log'] == '') {
  	// Redirect to the login page and append a querystring of login failed
    wp_redirect( $login_page . '?login=empty' );
	} elseif ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && empty($user->ID)) {
		// Redirect to the login page and append a querystring of login failed
  	wp_redirect( $login_page . '?login=failed');
		// check that were not on the default login page
	}	elseif ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && ($user->ID) ) {
		clean_user_cache($user->ID);
		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true, false);
		update_user_caches($user);
		
		// create a cookie - "exist-user"
		setcookie( "exist-user", "yes", 30 * DAYS_IN_SECONDS, "/", "" );
				
		wp_redirect( $referrer );
	}
}
add_filter("authenticate", "admin_login", 10, 3);

function wic_change_username_label( $defaults ){
	$defaults['label_username'] = __( 'Username' );
	return $defaults;
}
add_filter( 'login_form_defaults', 'wic_change_username_label' );

// bypass wordpress are you sure you want to logout screen when logging out of an already logged out account.
function wic_logout() {
	if (!is_user_logged_in()) {
		$wic_redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '/';
		wp_safe_redirect( $wic_redirect_to );
		exit();
	} else {
		check_admin_referer('log-out');
		wp_logout();
		$wic_redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '/';
		wp_safe_redirect( $wic_redirect_to );
		exit();
	}
}
add_action ( 'login_form_logout' , 'wic_logout' );

// Gravity form hooks for User registration pages
// Handle the form data
add_action( 'gform_pre_submission', 'pre_submission_handler_user_registration' );
function pre_submission_handler_user_registration( $form ) {
	// Check the form is registration form
	if ($_POST['input_17'] == 'yes') {
		if ($_POST['input_12_1'] == 'yes') {
			$_POST['input_14'] = 'Website w/ Email'; // the user has been subscribed to CM
			$_POST['input_16'] = 1;
		} else {
			$_POST['input_14'] = 'Website only'; // the user would like to browse the site only
			$_POST['input_16'] = 0;
		}
	}
}

// Handle form validation
add_filter("gform_validation", "custom_validation");
function custom_validation($validation_result){
	if(is_user_logged_in()) {
        remove_filter('gform_validation', array('GFUser', 'user_registration_validation'));
		$login_page = home_url( '/login/' );
		wp_redirect( $login_page . '?f=signup' ); // redirect to login page if the user logged on to the site
		exit;
    } else {
		$form = $validation_result['form'];
		$input_10 = rgpost( 'input_10' );
		$input_18 = rgpost( 'input_18' );
		if ( !empty($input_10) && strlen($input_10) < 6 ) {
			$validation_result['is_valid'] = false;

			foreach( $form['fields'] as &$field ) {
				if ( $field->id == '10' ) {
					$field->failed_validation = true;
					$field->validation_message = 'Username is too short, at least 6 characters';
					break;
				}
			}
		} elseif ( !empty($input_10) && !empty($input_18) && ( $input_10 != $input_18 ) ) {
			$validation_result['is_valid'] = false;

			foreach( $form['fields'] as &$field ) {
				if ( $field->id == '10' ) {
					$field->failed_validation = true;
					$field->validation_message = 'The Create username does not match the Confirm username field.';
				}
				if ( $field->id == '18' ) {
					$field->failed_validation = true;
					break;
				}
			}
		}
	
		$validation_result['form'] = $form;
    }
	
	return $validation_result;
}

// Update The Country field options in regisration form
// delete the following countries 
add_filter( 'gform_countries', 'remove_country' );
function remove_country( $countries ) {
 $key = array_search( 'French Polynesia', $countries );
 unset( $countries[ $key ] );
 $key = array_search( 'Virgin Islands British', $countries );
 unset( $countries[ $key ] );
 $key = array_search( 'Virgin Islands US', $countries );
 unset( $countries[ $key ] );
 return $countries;
}

// insert 'other location' at the bottom of the list
add_filter( 'gform_countries', 'add_country' );
function add_country( $countries ) {
 $countries[] = 'Other location';
 return $countries;
}

// Add a new feed to User Registration addon and Campaign Monitor addon table when create a new form
add_action("gform_after_save_form", "create_user_registration_cm_row", 10, 2);
function create_user_registration_cm_row($form, $is_news) {
	global $wpdb;
	
	foreach( $form['fields'] as &$field ) {
		if ( $field->id == '17' && $field->label == 'registration form? (Backend only)') { // do the following action if the form is Registration form
			$row_count_ur = $wpdb->get_var("SELECT COUNT(*) FROM wp_rg_userregistration WHERE `form_id` = ".$form['id']);
			// Check the User registration feed record is exist in "wp_rg_userregistration" table
			if ($row_count_ur == 0) {
				$meta = 'a:17:{s:9:"feed_type";s:6:"create";s:8:"username";s:2:"10";s:9:"firstname";s:3:"1.3";s:8:"lastname";s:3:"1.6";s:11:"displayname";s:8:"username";s:5:"email";s:1:"2";s:8:"password";s:2:"11";s:4:"role";s:10:"subscriber";s:9:"user_meta";a:12:{i:0;a:3:{s:9:"meta_name";s:10:"wpcmwiccf1";s:10:"meta_value";s:3:"6.6";s:6:"custom";b:0;}i:1;a:3:{s:9:"meta_name";s:10:"wpcmwiccf2";s:10:"meta_value";s:2:"13";s:6:"custom";b:0;}i:2;a:3:{s:9:"meta_name";s:8:"industry";s:10:"meta_value";s:1:"3";s:6:"custom";b:0;}i:3;a:3:{s:9:"meta_name";s:7:"company";s:10:"meta_value";s:1:"4";s:6:"custom";b:0;}i:4;a:3:{s:9:"meta_name";s:9:"job_title";s:10:"meta_value";s:1:"5";s:6:"custom";b:0;}i:5;a:3:{s:9:"meta_name";s:8:"location";s:10:"meta_value";s:3:"6.6";s:6:"custom";b:0;}i:6;a:3:{s:9:"meta_name";s:13:"business_line";s:10:"meta_value";s:1:"7";s:6:"custom";b:0;}i:7;a:3:{s:9:"meta_name";s:26:"business_line_other_option";s:10:"meta_value";s:1:"8";s:6:"custom";b:0;}i:8;a:3:{s:9:"meta_name";s:20:"relationship_manager";s:10:"meta_value";s:1:"9";s:6:"custom";b:0;}i:9;a:3:{s:9:"meta_name";s:10:"wpcmwiccf3";s:10:"meta_value";s:2:"14";s:6:"custom";b:0;}i:10;a:3:{s:9:"meta_name";s:7:"inviter";s:10:"meta_value";s:2:"15";s:6:"custom";b:0;}i:11;a:3:{s:9:"meta_name";s:16:"wpcmwicsubstatus";s:10:"meta_value";s:2:"16";s:6:"custom";b:0;}}s:21:"reg_condition_enabled";s:0:"";s:22:"reg_condition_field_id";s:1:"2";s:22:"reg_condition_operator";s:2:"is";s:19:"reg_condition_value";s:0:"";s:12:"notification";s:0:"";s:15:"set_post_author";s:1:"1";s:15:"user_activation";s:0:"";s:20:"user_activation_type";b:0;}';
		
				// Add a row for User Registration
				$query = "INSERT INTO wp_rg_userregistration VALUES('',".$form['id'].",'1','".$meta."')";
				$wpdb->query($wpdb->prepare($query));
			}
	
			// Check the Campaign Monitor feed record is exist in "wp_gf_addon_feed" table
			$row_count_cm = $wpdb->get_var("SELECT COUNT(*) FROM wp_gf_addon_feed WHERE `form_id` = ".$form['id']." AND `addon_slug` = 'gravityformscampaignmonitor'");
			if ($row_count_cm == 0) {
				$feed_list_name = "WiC-".$form['id'];
				$cm_client_key = constant('cm_client_key');
				$cm_contactlist_key = constant('cm_contactlist_key');
				$cm_meta = '{"feedName":"'.$feed_list_name.'","client":"'.$cm_client_key.'","contactList":"'.$cm_contactlist_key.'","listFields_email":"2","listFields_fullname":"1","listFields_wpcmwiccf1":"6.6","listFields_wpcmwiccf2":"13","feed_condition_conditional_logic":"1","feed_condition_conditional_logic_object":{"conditionalLogic":{"actionType":"show","logicType":"all","rules":[{"fieldId":"12","operator":"is","value":"yes"}]}},"resubscribe":"1"}';
		
				// Add a row for Campaign monitor feed
				$query = "INSERT INTO wp_gf_addon_feed VALUES('',".$form['id'].",'1','".$cm_meta."','gravityformscampaignmonitor','0')";
				$wpdb->query($wpdb->prepare($query));
			}
	
			return $wpdb->insert_id;
		}
	}
}

// Delete the feed from User Registration addon and Campaign Monitor addon table manually
add_action("gform_after_delete_form", "delete_user_registration_cm_row");
function delete_user_registration_cm_row($form_id) {
	global $wpdb;
	
	$row_count_ur = $wpdb->get_var("SELECT COUNT(*) FROM wp_rg_userregistration WHERE `form_id` = ".$form_id);
	// Check the User registration feed record is exist in "wp_rg_userregistration" table
	if ($row_count_ur != 0) {
		$query = "DELETE FROM wp_rg_userregistration WHERE `form_id` = ".$form_id;
		$wpdb->query($query);
	}
	
	$row_count_cm = $wpdb->get_var("SELECT COUNT(*) FROM wp_gf_addon_feed WHERE `form_id` = ".$form_id);
	// Check the Campaign Monitor feed record is exist in "wp_gf_addon_feed" table
	if ($row_count_cm != 0) {
		$query = "DELETE FROM wp_gf_addon_feed WHERE `form_id` = ".$form_id;
		$wpdb->query($query);
	}
}

/**
* Skip Registration for Logged In Users
* http://gravitywiz.com/2012/04/24/skip-user-registration-for-logged-in-users/
*/

add_action('gform_post_submission', 'maybe_skip_registration');
add_action('gform_after_submission', 'maybe_skip_registration');
function maybe_skip_registration($entry) {
	if (is_user_logged_in()) {
		remove_action('gform_post_submission', array('GFUser', 'gf_create_user'));
		remove_action('gform_after_submission', array('GFUser', 'gf_create_user'));
	}
}

// Disable New User Email Notification
if ( !function_exists ( 'gf_new_user_notification')) {
	function gf_new_user_notification ( $user_id, $notify = '' ) { }
}

// After logging in, reader should be returned to the page they were trying to access at prompt
function store_current_url_to_cookie( $post_id ) {
 global $user_ID;
 $curr_page_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
 $curr_page_url = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
 
 switch ($curr_page_template) {
  case "login.php":
  case "welcome.php":
  case "successful.php": 
  case "subscribe_successful.php":
		return;
	 	break;
  default:
		if ( !is_home() && ($user_ID == 0 || $user_ID == '99999999999') ) setcookie('curr_page', $curr_page_url, time() + 86400, "/", "");
   	return;
 }
}


// Get Algolia API keys
function get_algolia_api_keys() {
	$algolia_options = get_option('algolia');
	global $admin_api_key;
	global $application_id;
	global $search_only_api_key;
	global $index_name;
	global $index_name_sort_by_date;
	global $index_name_company;
	global $index_name_company_sort_by_date;
	
	$admin_api_key = $algolia_options['admin_key'];
	$application_id= $algolia_options['app_id'];
	$search_only_api_key = $algolia_options['search_key'];
	$index_name = $algolia_options['index_name'].'post'; // 'wic_posts' index, used for general search
	$index_name_sort_by_date = $algolia_options['index_name'].'post_sort_date'; // 'wic_post_sort_date' index, used for general search with sort by date
	$index_name_company = $algolia_options['index_name'].'all_post_tag_desc'; // 'wic_all_post_tag_desc' index, used for searching in Company index
	$index_name_company_sort_by_date = $algolia_options['index_name'].'all_category_desc'; // 'wic_all_category_desc' index, used for Company index search with sort by date
}
add_action('init', 'get_algolia_api_keys');

/** Global function for getting URI segments **/
function get_segments( $index = NULL ) {
    static $segments;
    // build $segments on first function call
    if ( NULL === $segments )
    {
        $segments = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
        $segments = explode( '/', $segments );
        $segments = array_filter( $segments );
        $segments = array_values( $segments );
    }
    // if $index is NULL, emulate REQUEST_URI
    if ( NULL === $index )
    {
        return '/' . implode( '/', $segments );
    }
    // return the segment index if valid, otherwise NULL
    $index =  ( int ) $index - 1;
    return isset( $segments[$index] ) ? $segments[$index] : NULL;
}
add_action('init', 'get_segments');

// Get Stand-first(Excerpt) by Post title for Most viewed stories block
function get_page_by_post_title($post_title, $output = OBJECT, $post_type = 'post' ) {
	global $wpdb;
	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $post_title, $post_type ) );
	if ( $page ) return get_post( $page, $output ); return null;
}
add_action('init','get_page_by_post_title');



/******
 Layout options: difference layout in Article page, such as image position
 ******/

function wic_layout_type_box_markup( $object, $box ) {
	wp_nonce_field( basename( __FILE__ ), 'wic_layout_type_nonce' );
	
	$obj_field = get_post_meta( $object->ID, 'wic_layout_type', true );
?>

	<p>
	    <label for="wic-post-class"><?php _e( "Choose layout type, which will be applied the layout into article page.", 'example' ); ?></label>
	    <br /><br />
	    <select class="widefat" name="wic-layout-type" id="wic-layout-type">
			<option value="type-1" <?php echo ( empty($obj_field) || $obj_field == 'type-1' ) ? 'selected' : ''; ?>>Image on right-hand-side</option>
			<option value="type-2" <?php echo ( $obj_field == 'type-2' ) ? 'selected' : ''; ?>>Image on top</option>
		</select>
	</p>
<?php	
}

/* Save the meta box's post metadata. */
function wic_save_layout_type_meta( $post_id, $post ) {
  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['wic_layout_type_nonce'] ) || !wp_verify_nonce( $_POST['wic_layout_type_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['wic-layout-type'] ) ? sanitize_html_class( $_POST['wic-layout-type'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'wic_layout_type';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

function wic_add_layout_type_box() {
	add_meta_box( 'wic-layout-type', 'Layout type', 'wic_layout_type_box_markup', 'post', 'side', 'high', null);
}

/******
 END of Layout options for different layout in Article page 
 ******/

/******
 Define a new custom field -- Summary -- for Article, shown on Article, search result(TBC) and Weekly EDM
 ******/
function wic_article_summary_box( $object, $box ) {
	wp_nonce_field( basename( __FILE__ ), 'wic_article_summary_nonce' );
	
	$obj_field = get_post_meta( $object->ID, 'wic_article_summary', true );
?>

	<p>
	    <label for="wic-post-class"><?php _e( "This summary are optional and shown on Article, Search result and Weekly EDM.", 'example' ); ?></label>
	    <br /><br />
		<textarea name="wic-article-summary" id="wic-article-summary" rows="3" cols="40" style="width:98%"><?php echo $obj_field; ?></textarea>
	</p>
<?php	
}

function wic_add_article_summary_box() {
	add_meta_box( 'wic-article-summary', 'Summary', 'wic_article_summary_box', 'post', 'normal', 'high', null);
}

/* Save the meta box's post metadata. */
function wic_save_article_summary_meta( $post_id, $post ) {
  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['wic_article_summary_nonce'] ) || !wp_verify_nonce( $_POST['wic_article_summary_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['wic-article-summary'] ) ? esc_textarea( strip_tags($_POST['wic-article-summary']) ) : '' );

  /* Get the meta key. */
  $meta_key = 'wic_article_summary';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}
/******
  END of Define a new custom field -- Summary
 ******/

/* Meta box setup function */
function wic_meta_boxes_setup() {
	/* Add meta box on the 'add_meta_boxes' hooks. */
	add_action( 'add_meta_boxes', 'wic_add_layout_type_box' );
	add_action( 'add_meta_boxes', 'wic_add_article_summary_box' );
	
	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'wic_save_layout_type_meta', 10, 2 );
	add_action( 'save_post', 'wic_save_article_summary_meta', 10, 2 );
}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'wic_meta_boxes_setup' );
add_action( 'load-post-new.php', 'wic_meta_boxes_setup' );



/*****
 Setup widgets for WP admin dashboard
 *****/
function wic_add_dashboard_widgets() {
	// Algolia statistics widget
	wp_add_dashboard_widget(
		'wic_algolia_statistics_dashboard_widget',         				// Widget slug.
		'Search results in Last 7 days (Algolia)',         				// Title.
        'wic_algolia_statistics_dashboard_widget_function' 				// Display function.
	);
	
	// Algolia statistics widget
	wp_add_dashboard_widget(
		'wic_pdf_downloads_dashboard_widget',
		'PDF downloads stats',
        'wic_pdf_downloads_dashboard_widget_function'
	);
}
add_action( 'wp_dashboard_setup', 'wic_add_dashboard_widgets' );

/*****
 Add Algolia statistics widget box in WP Admin Dashboard
 *****/

function wic_algolia_statistics_dashboard_widget_function() {
	require_once( ABSPATH . 'wp-content/plugins/algoliasearch-wordpress-master/lib/algolia/algoliasearch.php' );
	
	global $admin_api_key;
	global $application_id;
	global $index_name;
	
	$client = new \AlgoliaSearch\Client( $application_id, $admin_api_key );
	$index = $client->initIndex($index_name);
	if ( empty($index) ) {
		echo "No data get from Algolia server, please try again later.";
	} else {
		$start_at = strtotime( date('Y-m-d', strtotime("-7 days")) );
		$end_at = strtotime( date('Y-m-d', strtotime("+1 days")) );
		
		$return_data = $index->getPopular( $start_at, $end_at );
		
		if ( empty($return_data) ) {
			echo "No data get from Algolia server, please try again later.";
		} else {
			$search_count = $return_data['searchCount']; // Search Count
			if ( $search_count == 0 ) {
				echo "0 search count in last 7 days";
			} else {
				// Extract the data
				$last_search = date('Y-m-d h:i a', strtotime($return_data['lastSearchAt']));
	
				echo "Total search count: " . $search_count . "<br />";
				echo "Last search at: " . $last_search . "<br /><br />";
	
				if ( !empty($return_data['topSearches']) ) {
					?>
					<div class="datagrid"><table>
						<thead>
							<tr>
								<th width="75%"><?php _e('Search Query'); ?></th>
						    	<th width="25%" align="center"><?php _e('Count'); ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = $count = 1;
					$class = "";
					foreach ( $return_data['topSearches'] as $top_search ) {
						if ( $i % 2 == 0 ) {
							$class = "class='alt'";
							$i = 1;
						} else {
							$class = "";
							$i++;
						}
					?>
							<tr <?php echo $class; ?>>
								<td><?php echo $top_search['query']; ?></td>
								<td align="center"><?php echo $top_search['count']; ?></td>
							</tr>
					<?php
						$count++;
						if ($count > 10) break;
					}
					?>
						</tbody>
					</table></div>
					<?php
				}
			}
		}
	}
}

/*****
 END of Add Algolia statistics widget box in WP Admin Dashboard
 *****/

/*****
 Add PDF downloads widget box in WP Admin Dashboard
 *****/

function wic_pdf_downloads_dashboard_widget_function() {
	global $wpdb;
	$pdf_dl_tablename = "pdf_download_logs";
	$web_site = $wpdb->get_var( "SELECT COUNT(*) as total FROM {$pdf_dl_tablename} WHERE type = 1" );
	$html_edm = $wpdb->get_var( "SELECT COUNT(*) as total FROM {$pdf_dl_tablename} WHERE type = 2" );
	$txt_edm = $wpdb->get_var( "SELECT COUNT(*) as total FROM {$pdf_dl_tablename} WHERE type = 3" );
	
	if ( !empty($web_site) ) echo "From WiC site: <b>" . number_format($web_site) . "</b><br /><br />";
	if ( !empty($html_edm) ) echo "From EDM HTML version: <b>" . number_format($html_edm) . "</b><br /><br />";
	if ( !empty($txt_edm) ) echo "From Plain-text version: <b>" . number_format($txt_edm) . "</b><br />";
}

/*****
 END of Add PDF downloads widget box in WP Admin Dashboard
 *****/


// Add a Custom CSS file to WP Admin Area
function admin_theme_style() {
    wp_enqueue_style('custom-admin-style', '/wp-content/plugins/wic-widgets/css/hp-dashboard-style.css');
	wp_enqueue_script('custom-admin-script', '/wp-content/plugins/wic-widgets/js/keep-line-break-tinymce.js');
}
add_action('admin_enqueue_scripts', 'admin_theme_style');


/****** 
 Gets image attached to a post by Post ID and template opiton
 @return string
 ******/
function wpse_get_images( $id, $template_type ) {
	global $post;
	$size = 'large';
	$output = intval( $id );
	$attachments = get_children( array(
		'post_parent' => $id,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order'
	) );
	if ( empty( $attachments ) )
	   return '';

	$output = "\n";
	
	/***
	 Wrap the image by Post type: 
	 type-1 = normal view, attachment order: index 1
	 type-2 = large image on top of article , attachment order: index 2
	 ***/
	$attach_index = 0;
	$wrapper_class = 'normal';
	if ( $template_type == 'type-2' ) {
		$attach_index = 1;
		$wrapper_class = 'large';
	}
	
	$i = 0;
	foreach ($attachments as $id => $attachment) {
		if ( $attach_index == $i ) {
			$title = esc_html( $attachment->post_title, 1 );
			$caption = esc_html( $attachment->post_excerpt, 1 );
			$img = wp_get_attachment_image_src( $id, $size );

			$output .= '<div class="imgCaption delay '.$wrapper_class.'">';
			$output .= '<img width="100%" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" data-no-retina />';
			$output .= '<p class="caption">'.$caption.'</p>';
			break;
		} else {
			$i++;
		}
	}
	
	return $output;
}
/****** 
 END of Gets image attached to a post by Post ID and template opiton
 ******/


/******
 Completely disable comments
 ******/
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');
/******
 END of Completely disable comments
 ******/

// Fix thumbnail missing when post a link on LinkedIn 
$data = apply_filters( 'oembed_response_data', $data, $post, $width, $height );
if ( !empty( $data ) ) {
 // define the oembed_response_data callback
 function filter_oembed_response_data( $data, $post, $width, $height ) {
  $attachments = get_children( array(
   'post_parent' => $post->ID,
   'post_status' => 'inherit',
   'post_type' => 'attachment',
   'post_mime_type' => 'image',
   'order' => 'DESC',
   'orderby' => 'menu_order'
  ) );
  if ( $attachments ) {
   foreach ( $attachments as $attachment ) {
    $image_attributes = wp_get_attachment_image_src( $attachment->ID, 'full' );
    
    if ( $image_attributes ) {
     // make filter magic happen here...
     $data['thumbnail_url'] = $image_attributes[0];
     $data['thumbnail_width'] = $image_attributes[1];
     $data['thumbnail_height'] = $image_attributes[2];
    }
   }
  }
  
  return $data;
 };
 // add the filter
 add_filter( 'oembed_response_data', 'filter_oembed_response_data', 10, 4 );
}


// Trim the content on /theyearahead page if the reader without logged on
// function wic_trim_content_theyearahead( $content ) {
//  global $user_ID;
 
//  if ( $user_ID == 0 || $user_ID == '99999999999' ) {
//   $replace = [
//    "/(<trim_1>)(.*)(<\/trim_1>)/eis" => "",
//    "/(<trim_2>)(.*)(<\/trim_2>)/eis" => "",
//    "/(<trim_3>)(.*)(<\/trim_3>)/eis" => "",
//    "/(<trim_4>)(.*)(<\/trim_4>)/eis" => "",
//   ];
//   $patterns_and_callbacks = array_combine(array_keys( $replace ), array_values( $replace ));
//   $content = preg_replace_callback_array($patterns_and_callbacks, $content);
//  } else {
//   $content = preg_replace_callback('/<\/?trim_[1-4]>/eis', '', $content);
//  }
//  return $content;
// }
// add_filter( 'the_content', 'wic_trim_content_theyearahead' );

// remove wp version param from any enqueued scripts
function wic_remove_wp_ver_css_js( $src ) {
 if ( strpos( $src, 'ver=' ) )
  $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'wic_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'wic_remove_wp_ver_css_js', 9999 );

// Disable insert GA tracking code by MonsterInsights plugin
// remove_action( 'wp_head', 'monsterinsights_tracking_script', 8 );

// to create a custom image sizes:
add_image_size('issue-cover',146,207); // display on the List of "Missed a recent edition of WiC" in homepage and Back issues page 

add_filter( 'wp_generate_attachment_metadata', 'wic_retina_support_attachment_meta', 10, 2 );
function wic_retina_support_attachment_meta( $metadata, $attachment_id ) {
 foreach ( $metadata as $key => $value ) {
  if ( is_array( $value ) ) {
   foreach ( $value as $image => $attr ) {
    if ( is_array( $attr ) && $attr['width'] == 146 ) // create Retina image for Issue Cover
     wic_retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
   }
  }
 }
 return $metadata;
}

function wic_retina_support_create_images( $file, $width, $height, $crop = false ) {
 if ( $width || $height ) {
  $resized_file = wp_get_image_editor( $file );
  if ( ! is_wp_error( $resized_file ) ) {
   $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
   $resized_file->resize( $width * 2, $height * 2, $crop );
   $resized_file->save( $filename );
   $info = $resized_file->get_size();
   return array(
    'file' => wp_basename( $filename ),
    'width' => $info['width'],
    'height' => $info['height'],
   );
  }
 }
 return false;
}

add_filter( 'delete_attachment', 'wic_delete_retina_support_images' );
function wic_delete_retina_support_images( $attachment_id ) {
 $meta = wp_get_attachment_metadata( $attachment_id );
 $upload_dir = wp_upload_dir();
 $path = pathinfo( $meta['file'] );
 foreach ( $meta as $key => $value ) {
  if ( 'sizes' === $key ) {
   foreach ( $value as $sizes => $size ) {
    $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
    $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
    if ( file_exists( $retina_filename ) )
     unlink( $retina_filename );
   }
  }
 }
}

// Move plugin JavaScript files from the Head to the Footer
function wic_remove_head_scripts() { 
 if ( is_admin() ) return false;

 remove_action('wp_enqueue_scripts', 'open_social_style', 100); // Open social plugin
 remove_action('wp_head','include_js_file'); // Contact form Captcha plugin
 wp_dequeue_script( 'theme.js' ); // Algolia search plugin
 wp_dequeue_style('algolia_bundle'); // Algolia search plugin
 wp_deregister_style('algolia_styles'); // Algolia search plugin

 add_action('wp_footer', 'open_social_style', 5);
 add_action('wp_footer','include_js_file');
} 
add_action( 'wp_enqueue_scripts', 'wic_remove_head_scripts' );

// custom init the JS scripts & CSS files and move them to footer (Recommend to a friend plugin)
function wic_raf_init_styles_scripts() {
 if ( is_admin() ) return false;

 // Register scripts
 wp_enqueue_script( 'jquery', '', '', '', true );
 wp_enqueue_script( 'fancy_box', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.3', true );
 wp_enqueue_script( 'raf_script', RAF_URL . 'js/raf_script.js', array( 'jquery', 'fancy_box' ), '1.0', true );

 // Register styles
 wp_enqueue_style( 'fancy_box_css', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.css', '', '1.3.4' );
 // Specific RAF styles
 if ( file_exists( get_template_directory() . "/raf-styles.css" ) ) {
  wp_enqueue_style( 'raf-style', get_template_directory_uri() . '/raf-styles.css', array(), '1.0' );
 }
}
remove_action( 'init', array( 'RAF_Client', 'init_styles_scripts' ) );
add_action( 'wp_footer', 'wic_raf_init_styles_scripts' );

// Move Gravity form jQuery init calls to footer
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
 return true;
}
// END of Move plugin JavaScript files from the Head to the Footer

// Remove WP EMOJI from header
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


// MobileCoderz@arvind - Event Notification Start
add_action( 'admin_menu', 'wpse_91693_register' );

function wpse_91693_register()
{
    add_menu_page(
        'Event/Message Notification',     // page title
        'Event/Message Notification',     // menu title
        'manage_options',   // capability
        'event-notification-codrz',     // menu slug
        'event_9193_render' // callback function
    );
	add_submenu_page( 
		'event-notification-codrz',
		'PostView',
		'PostView',
		'manage_options',
		'post-view-analytics',
		'post_view_analytics'
	);
}
function event_9193_render(){
    
    $file = plugin_dir_path( __FILE__ ) . "Event-Notification/home_cz.php";

    if ( file_exists( $file ) )
        require $file;
}
function post_view_analytics(){
	
	$file = plugin_dir_path( __FILE__ ) . "Event-Notification/post_analytics.php";

    if ( file_exists( $file ) )
        require $file;
	
}

/*
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
        echo $whatever;
	wp_die();
}*/

// MobileCoderz@arvind - Event Notification End

// MobileCoderz@arvind - Send Notification
add_action('publish_post', 'wpse120996_add_custom_field_automatically');
function wpse120996_add_custom_field_automatically($post_id) {
	
    global $wpdb;
	$result = $wpdb->get_results ("SELECT * FROM wp_mobile_notifications where status =1");
	if( $_POST['original_publish'] == 'Publish' ) {
	foreach ( $result as $page ){
	if($page->device_type == "IOS" && $page->notify_type == 0)
		{
			  // For IOS	
			  $keyfile = dirname(__FILE__) . '/IOSp8/'.'AuthKey_533B4Q92NL.p8';               # <- Your AuthKey file
			  $keyid = '533B4Q92NL';                        # <- Your Key ID
			  $teamid = '9JGAMF8EHX';                       # <- Your Team ID (see Developer Portal)
			  $bundleid = 'com.weekinchina.iphoneedition';           # <- Your Bundle ID
			  $url = 'https://api.development.push.apple.com';  # <- development url, or use https://api.development.push.apple.com    development http://api.push.apple.com for production environment
			  $token = $page->device_id;             # <- Device Token
		 //$token = '5fec5416810c6cad0042441d0df53b0f9e9b35c7a361bc7b2d0f28833dd4eec9';
			  //$message = '{"aps":{"alert":{"title": "'.$message['title'].'","subtitle": "","body":"'.$message['message'].'"},"badge":"'.$message['badge'].'","sound":"default"}}';
				
				$title = substr($_POST['post_title'],0,40).'...';
				$body = substr($_POST['content'],0,50).'....';
				
				//$message = '{"aps":{"alert":{"title": "'.$title.'","subtitle": "","body":"'.$messages.'"},"badge":"1","sound":"default"},"data":{"message":"'.$messages.'","title":"'.$title.'"}}';

				//$message = '{"aps":{"alert":{"title": "'.$title.'","subtitle": "","body":"'.$messages.'"},"badge":'.$noti_count.',"sound":"default"},"data":{"userId":"1","type":"1","senderId":"1"}}';

				//print_r($message);die;
				$message = '{"aps":{"alert":{"title": "'.$title.'","body":"'.$body.'","post_id":"'.$post_id.'"},"badge":1,"sound":"default"}}';
			  

			  //$message = '{"aps":{"alert":"test","sound":"default"}}';
			  $key = openssl_pkey_get_private('file://'.$keyfile);
			  $header = ['alg'=>'ES256','kid'=>$keyid];
			  $claims = ['iss'=>$teamid,'iat'=>time()];
			 
		$header_encoded = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
		$claims_encoded = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');


			  $signature = '';
			  openssl_sign($header_encoded . '.' . $claims_encoded, $signature, $key, 'sha256');
			  $jwt = $header_encoded . '.' . $claims_encoded . '.' . base64_encode($signature);

			  //only needed for PHP prior to 5.5.24
			  if (!defined('CURL_HTTP_VERSION_2_0')) {
				  define('CURL_HTTP_VERSION_2_0', 3);
			  }

			  $http2ch = curl_init();
			  curl_setopt_array($http2ch, array(
			   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
				CURLOPT_URL => "$url/3/device/$token",
				CURLOPT_PORT => 443,
				CURLOPT_HTTPHEADER => array(
				  "apns-topic: {$bundleid}",
				  "authorization: bearer $jwt"
				),
				CURLOPT_POST => TRUE,
				CURLOPT_POSTFIELDS => $message,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HEADER => 1
			  ));

			  $result = curl_exec($http2ch);
		
			  if ($result === FALSE) {
				$err =  "Curl failed: ".curl_error($http2ch);
				$send = false;
			  }else{
				$status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
				 $send = true;
			  }

		}
		if($page->device_type == "ANDROID" && $page->notify_type == 0)
		{

			// For Android
				$key =   "AIzaSyAAqrZmrIR3VvzWk4Q6h_81RWIKMnP_Q0o";   
				$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
				$headers = array(
				   'Authorization: key='. $key,
					'Content-Type:application/json'
				 );
				$message = $post_id;
				$title = substr($_POST['post_title'],0,40).'...';
				$body = substr($_POST['content'],0,50).'....';
				$device_id = $page->device_id;
				if(strlen($device_id) > 12)
				{
			   $fields = array(
					'to' => $device_id,
					'notification' => array('title' => $title, 'body' => $body,'vibrate'	=> 'default','sound'=> 'default'),'data' => array('message' => $message,'title'=>$title));
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);					       
			curl_close($ch);
			if($result)
			{
				$send = true;
			}else{
				$send = false;
			}

			}
	 }
	}
}
}
// MobileCoderz@arvind - End Send Notification