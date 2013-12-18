<?php

/*

Plugin Name: ZOMBI Bootsrap Usermenu Widget

Plugin URI: http://zombimedia.com/

Description: Bootstrap styled menu for navbar. Based on a widget by Brian D. Goad.

Version: 1.01

Author: Pete Toborek

Author URI: http://www.zombimedia.com

*/

/*  

	Copyright 2013 Pete Toborek  (email : pt@zombimedia.com)



    This program is free software; you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation; either version 2 of the License, or

    (at your option) any later version.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with this program; if not, write to the Free Software

    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/
if (!function_exists("htmlspecialchars_decode")) {
	function htmlspecialchars_decode($string,$style=ENT_COMPAT){
        $translation = array_flip(get_html_translation_table(HTML_SPECIALCHARS,$style));
        if($style === ENT_QUOTES){ $translation['&#039;'] = '\''; }
        return strtr($string,$translation);
    }
}

function widget_zombi_usermenu_init() {

	if (!function_exists('register_sidebar_widget')) {

		return;

	}

	function widget_zombi_usermenu_sc_fname() {
		$current_user = wp_get_current_user();
		return $current_user->user_firstname;
	}
	add_shortcode('firstname', 'widget_zombi_usermenu_sc_fname');

	function widget_zombi_usermenu_sc_displayname() {
		$current_user = wp_get_current_user();
		return $current_user->display_name;
	}
	add_shortcode('fullname', 'widget_zombi_usermenu_sc_fname');
	
	function widget_zombi_alertmsg() {
		if ($_GET['loggedout'] == '1') {
			return '<div class="alert alert-danger">You have been logged-out</div>';
		}
	}
	add_shortcode('wzu-alerts', 'widget_zombi_alertmsg');	
	
	function widget_zombi_usermenu($args) {
	    extract($args);
		
		$options = get_option('widget_zombi_usermenu');
	
		//$title = htmlspecialchars($options['title'], ENT_QUOTES);
		//$title = empty($options['title']) ? __('Search') : $options['title'];
		//
		//$input = htmlspecialchars($options['input'], ENT_NOQUOTES);
		//
		//$size = htmlspecialchars($options['size'], ENT_NOQUOTES);
		//
		//$other_text_mods = htmlspecialchars($options['other_text_mods'], ENT_QUOTES);
		//
		//$wrap_button = htmlspecialchars($options['wrap_button'], ENT_NOQUOTES);
		//
		//$button_type = htmlspecialchars($options['button_type'], ENT_NOQUOTES);
		//
		//$button_value = htmlspecialchars($options['button_value'], ENT_QUOTES);
		//
		//$other_button_mods = htmlspecialchars($options['other_button_mods'], ENT_QUOTES);
		
		$login_url = htmlspecialchars($options['login_url'], ENT_QUOTES);
		$login_url = empty($options['login_url']) ? __('/wp-admin') : $options['login_url'];
	
		$logout_text = htmlspecialchars($options['logout_text'], ENT_QUOTES);
		$logout_text = empty($options['logout_text']) ? __('Log Out') : $options['logout_text'];
		
		$glyphicon = htmlspecialchars($options['glyphicon'], ENT_QUOTES);
		$glyphicon = empty($options['glyphicon']) ? __('lock') : $options['glyphicon'];
	
		$glyphicon_loggedin = htmlspecialchars($options['glyphicon_loggedin'], ENT_QUOTES);
		$glyphicon_loggedin = empty($options['glyphicon_loggedin']) ? __('user') : $options['glyphicon_loggedin'];
	
		$classes_navbartext = htmlspecialchars($options['classes_navbartext'], ENT_QUOTES);
		$classes_navbartext = empty($options['classes_navbartext']) ? __('') : $options['classes_navbartext'];	
	
		$classes_navbarmenu = htmlspecialchars($options['classes_navbarmenu'], ENT_QUOTES);
		$classes_navbarmenu = empty($options['classes_navbarmenu']) ? __('') : $options['classes_navbarmenu'];
		
		$loggedin_menu_title = htmlspecialchars($options['loggedin_menu_title'], ENT_QUOTES);
		$loggedin_menu_title = empty($options['loggedin_menu_title']) ? __('') : $options['loggedin_menu_title'];
		
		$loggedin_menu_label = htmlspecialchars($options['loggedin_menu_label'], ENT_QUOTES);
		$loggedin_menu_label = empty($options['loggedin_menu_label']) ? __('User Menu') : $options['loggedin_menu_label'];
		
		$loggedout_text_label = htmlspecialchars($options['loggedout_text_label'], ENT_QUOTES);
		$loggedout_text_label = empty($options['loggedout_text_label']) ? __('Sign-In') : $options['loggedout_text_label'];
		
		$logout_redirect = htmlspecialchars($options['logout_redirect'], ENT_QUOTES);
		$logout_redirect = empty($options['logout_redirect']) ? home_url() : $options['logout_redirect'];
		
		if($wrap_button==1)
		{
		$button_placement = '';
		}
		else
		{
		$button_placement = '</td><td valign="bottom">';
		}
		
	
		
			
	?>
		<?php echo $before_widget; ?>
		    <?php echo $before_title
			. $after_title;
			if (is_user_logged_in()) {
			?>
				<ul class="nav navbar-nav <?php echo $classes_navbarmenu; ?>">
				  <li class="dropdown">
				     <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> <?php echo do_shortcode( $loggedin_menu_label ); ?> <b class="caret"></b></a>
				    <ul class="dropdown-menu">
					<?php if (!empty($loggedin_menu_title)) { ?>
					<li class="title"><span class="label label-default"><?php echo do_shortcode($loggedin_menu_title); ?></span></li>
					<?php } ?>
					<?php if (current_user_can('edit_posts')) { ?>
				      <li><a href="/wp-admin/edit.php">Manage Posts</a></li>
					<?php } ?>					
					<?php if (function_exists('is_bbpress') && current_user_can('delete_forums')) { ?>
				      <li><a href="/wp-admin/edit.php?post_type=forum">Manage Forums</a></li>
					<?php } ?>			
					<?php if (function_exists('is_qa') && current_user_can('delete_others_questions')) { ?>
				      <li><a href="/wp-admin/edit.php?post_type=question">Manage Questions</a></li>
					<?php } ?>
				      <li><a href="<?php echo widget_zombi_usermenu_profile_url(); ?>" title="Your Profile">Your Profile</a></li>
				      <li><a href="<?php echo wp_logout_url($logout_redirect); ?>" title="<?php echo do_shortcode( $logout_text); ?>"><?php echo do_shortcode( $logout_text ); ?></a></li>
				    </ul>
				  </li>
				</ul>				
			<?php
			// User is NOT logged in
			} else {
			?>
				<p class="navbar-text <?php echo $classes_navbartext; ?>"><a href="<?php echo $login_url; ?>" rel="nofollow"><i class="glyphicon glyphicon-<?php echo $glyphicon; ?>"></i> <?php echo $loggedout_text_label; ?></a></p>
			<?php
			}
			?>
		<?php echo $after_widget; ?>
	<?php
	}
	
	function widget_zombi_usermenu_profile_url() {
		$current_user = wp_get_current_user();
		if (function_exists('bbp_get_user_profile_url')) {
			return bbp_get_user_profile_url( $current_user->ID );			
		}
	}
	
	function widget_zombi_usermenu_control() {
		$options = get_option('widget_zombi_usermenu');
		if ( !is_array($options) )
			$options = array('title'=>__('Search'), 'input' => 0, 'size' => 15, 'other_text_mods' => '', 'wrap_button' => 1, 'button_type' => __('0'), 'button_value' => __('Search'), 'other_button_mods' => '');
		if ( $_POST['zombiusermenu-submit'] ) {
			//$options['title'] = strip_tags(stripslashes($_POST['zombiusermenu-title']));
			//$options['input'] = intval($_POST['zombiusermenu-input']);
			//$options['size'] = intval($_POST['zombiusermenu-size']);
			//$options['other_text_mods'] = strip_tags(stripslashes($_POST['zombiusermenu-other_text_mods']));
			//$options['wrap_button'] = intval($_POST['zombiusermenu-wrap_button']);
			//$options['button_type'] = intval($_POST['zombiusermenu-button_type']);
			////$options['button_value'] = strip_tags(stripslashes($_POST['zombiusermenu-button_value']));
			//$options['button_value'] = strip_tags(stripslashes($_POST['zombiusermenu-button_value']));
			//$options['other_button_mods'] = strip_tags(stripslashes($_POST['zombiusermenu-other_button_mods']));
			//
			$options['glyphicon'] = strip_tags(stripslashes($_POST['zombiusermenu-glyphicon']));
			$options['glyphicon_loggedin'] = strip_tags(stripslashes($_POST['zombiusermenu-glyphicon_loggedin']));
			$options['classes_navbartext'] = strip_tags(stripslashes($_POST['zombiusermenu-classes_navbartext']));
			$options['classes_navbarmenu'] = strip_tags(stripslashes($_POST['zombiusermenu-classes_navbarmenu']));
			$options['login_url'] = strip_tags(stripslashes($_POST['zombiusermenu-login_url']));
			$options['loggedin_menu_label'] = strip_tags(stripslashes($_POST['zombiusermenu-loggedin_menu_label']));
			$options['loggedin_menu_title'] = strip_tags(stripslashes($_POST['zombiusermenu-loggedin_menu_title']));
			$options['loggedout_text_label'] = strip_tags(stripslashes($_POST['zombiusermenu-loggedout_text_label']));
			$options['logout_text'] = strip_tags(stripslashes($_POST['zombiusermenu-logout_text']));
			$options['logout_redirect'] = strip_tags(stripslashes($_POST['zombiusermenu-logout_redirect']));
			update_option('widget_zombi_usermenu', $options);
		}
		
		//Set values
		//$title = htmlspecialchars($options['title'], ENT_QUOTES);
		//$title = empty($options['title']) ? __('Search') : $options['title'];
		//
		//$input = htmlspecialchars($options['input'], ENT_NOQUOTES);
		//
		//$size = htmlspecialchars($options['size'], ENT_NOQUOTES);
		//
		//$other_text_mods = htmlspecialchars($options['other_text_mods'], ENT_QUOTES);
		//
		//$wrap_button = htmlspecialchars($options['wrap_button'], ENT_NOQUOTES);
		//
		//$button_type = htmlspecialchars($options['buttton_type'], ENT_NOQUOTES);
		//
		//$button_value = htmlspecialchars($options['button_value'], ENT_QUOTES);
		//
		//$other_button_mods = htmlspecialchars($options['other_button_mods'], ENT_QUOTES);
		
		$glyphicon = htmlspecialchars($options['glyphicon'], ENT_QUOTES);
		$glyphicon_loggedin = htmlspecialchars($options['glyphicon_loggedin'], ENT_QUOTES);
		$login_url = htmlspecialchars($options['login_url'], ENT_QUOTES);
		$classes_navbartext = htmlspecialchars($options['classes_navbartext'], ENT_QUOTES);
		$classes_navbarmenu = htmlspecialchars($options['classes_navbarmenu'], ENT_QUOTES);
		$loggedin_menu_label = htmlspecialchars($options['loggedin_menu_label'], ENT_QUOTES);
		$loggedin_menu_title = htmlspecialchars($options['loggedin_menu_title'], ENT_QUOTES);
		$loggedout_text_label = htmlspecialchars($options['loggedout_text_label'], ENT_QUOTES);
		$logout_text = htmlspecialchars($options['logout_text'], ENT_QUOTES);
		$logout_redirect = htmlspecialchars($options['logout_redirect'], ENT_QUOTES);
		
		//Display Admin Options
		
		//echo '<p style="text-align:left;"><label for="zombiusermenu-title">' . __('Title:') . ' <br /><input style="width: 200px;" id="zombiusermenu-title" name="zombiusermenu-title" type="text" value="'.$title.'" /></label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-input">' . __('Remember User Input in Text Box:') . '  <br /><select id="zombiusermenu-input" name="zombiusermenu-input" size="1">'."\n";
		//echo '<option value="0"';
		//selected('0', $options['input']);
		//echo '>No</option>'."\n";
		//echo '<option value="1"';
		//selected('1', $options['input']);
		//echo '>Yes</option>'."\n";
		//echo '</select></p>'."\n" . '</label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-size">' . __('Size of Search Box:') . '  <br /><input style="width: 50px;" id="zombiusermenu-size" name="zombiusermenu-size" type="text" value="'.$size.'" /></label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-other_text_mods">' . __('Other Textbox Stylizing Modifications'. "\n" .'(i.e. id="textbox", etc):') . '  <br /><input style="width: 230px;" id="zombiusermenu-other_text_mods" name="zombiusermenu-other_text_mods" type="text" value="'.$other_text_mods.'" /></label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-wrap_button">' . __('Button Placement:') . '  <br /><select id="zombiusermenu-wrap_button" name="zombiusermenu-wrap_button" size="1">'."\n";
		//echo '<option value="0"';
		//selected('0', $options['wrap_button']);
		//echo '>Button Beside Textbox</option>'."\n";
		//echo '<option value="1"';
		//selected('1', $options['wrap_button']);
		//echo '>Button Below Textbox</option>'."\n";
		//echo '</select></p>'."\n" . '</label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-button_type">' . __('Button Type:') . '  <br /><select id="zombiusermenu-button_type" name="zombiusermenu-button_type" size="1">'."\n";
		//echo '<option value="0"';
		//selected('0', $options['button_type']);
		//echo '>Normal Button</option>'."\n";
		//echo '<option value="1"';
		//selected('1', $options['button_type']);
		//echo '>Image Button</option>'."\n";
		//echo '</select></p>'."\n" . '</label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-button_value">' . __('Value Modifying Above Button Type (Either Text Displayed in Button or Path to Image Located in Theme Folder):') . '  <br /><input style="width: 230px;" id="zombiusermenu-button_value" name="zombiusermenu-button_value" type="text" value="'.$button_value.'" /></label></p>';
		//echo '<p style="text-align:left;"><label for="zombiusermenu-other_button_mods">' . __('Other Button Stylizing Modifications (i.e. id="button", etc):') . '  <br /><input style="width: 230px;" id="zombiusermenu-other_button_mods" name="zombiusermenu-other_button_mods" type="text" value="'.	$other_button_mods .'" /></label></p>';
		
		echo '<div style="padding:8px; border-radius: 8px; background:#FEFEFE; margin-bottom:15px;">You may use shortcodes [firstname], [fullname] in any of the designated fields below logged-in user info</div>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-loggedout_text_label">' . __('Login Text (Default <em>Sign-In</em>):') . '  <br /><input style="width: 226px;" id="zombiusermenu-loggedout_text_label" name="zombiusermenu-loggedout_text_label" type="text" value="'.$loggedout_text_label.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-loggedin_menu_label">' . __('Logged In Menu label (Default <em>User Menu</em>):') . '  <br /><input placeholder="text or [shortcode]" style="width: 226px;" id="zombiusermenu-loggedin_menu_label" name="zombiusermenu-loggedin_menu_label" type="text" value="'.$loggedin_menu_label.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-loggedin_menu_title">' . __('Logged In Menu title inside dropdown (Default <em>None</em>):') . '  <br /><input placeholder="text or [shortcode]" style="width: 226px;" id="zombiusermenu-loggedin_menu_title" name="zombiusermenu-loggedin_menu_title" type="text" value="'.$loggedin_menu_title.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-logout_text">' . __('Logout Text (Default <em>Logout</em>):') . '  <br /><input placeholder="text or [shortcode]" style="width: 226px;" id="zombiusermenu-logout_text" name="zombiusermenu-logout_text" type="text" value="'.$logout_text.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-classes_navbartext">' . __('Logged Out Classes (space separated):') . '  <br /><input style="width: 226px;" id="zombiusermenu-classes_navbartext" name="zombiusermenu-classes_navbartext" type="text" value="'.$classes_navbartext.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-classes_navbarmenu">' . __('Logged In Classes (space separated):') . '  <br /><input style="width: 226px;" id="zombiusermenu-classes_navbarmenu" name="zombiusermenu-classes_navbarmenu" type="text" value="'.$classes_navbarmenu.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-glyphicon">' . __('Logged Out Glyphicon (user, lock, etc.):') . '  <br /><input style="width: 226px;" id="zombiusermenu-glyphicon" name="zombiusermenu-glyphicon" type="text" value="'.$glyphicon.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-glyphicon_loggedin">' . __('Logged In Glyphicon (user, lock, etc.):') . '  <br /><input style="width: 226px;" id="zombiusermenu-glyphicon_loggedin" name="zombiusermenu-glyphicon_loggedin" type="text" value="'.$glyphicon_loggedin.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-login_url">' . __('Login Redirect Url (Default /wp-admin):') . '  <br /><input style="width: 226px;" id="zombiusermenu-login_url" name="zombiusermenu-login_url" type="text" value="'.$login_url.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="zombiusermenu-login_url">' . __('Logout Redirect Url (Default home_url()):') . '  <br /><input style="width: 226px;" id="zombiusermenu-logout_redirect" name="zombiusermenu-logout_redirect" type="text" value="'.$logout_redirect.'" /></label><br />Place the shortcode [wzu-alerts] on logout page to display logout message.</p>';
		
		echo '';
		echo '<input type="hidden" id="zombiusermenu-submit" name="zombiusermenu-submit" value="1" />';
		
	}
	register_sidebar_widget(array('Bootstrap Usermenu', 'widgets'), 'widget_zombi_usermenu');
	register_widget_control(array('Bootstrap Usermenu', 'widgets'), 'widget_zombi_usermenu_control', 250);
	
}
	
add_action('widgets_init', 'widget_zombi_usermenu_init');

?>