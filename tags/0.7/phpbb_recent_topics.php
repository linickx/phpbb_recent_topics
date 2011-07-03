<?php 
	/*
	 Plugin Name: phpbb_recent_topics
	 Plugin URI: http://www.linickx.com/3311/phpbb_recent_topics-version-0-7
	 Description: This plugin grabs your recent phpBB topics for you to display in wordpress.
	 Version: 0.7
	 Author: Nick [LINICKX] Bettison
	 Author URI: http://www.linickx.com
	 */
	
	# before we start, check for upgrades.
	require_once(WP_PLUGIN_DIR . "/phpbb-recent-topics/upgrade.php");
	
	# Load Plugin Options from WP DB
	$lnx_PRT_options = get_option('lnx_PRT_options'); 
	
	# Only run admin code,if in admin screen.
	if (is_admin()) { 
		include_once(WP_PLUGIN_DIR . "/phpbb-recent-topics/admin.php");
	}
	
	# Go!
	if ($lnx_PRT_options) { // only move on if we have options..
		
		add_action('wp_head', 'DisplayPRTHeader'); // Hook into the WP Header
		
		function DisplayPRTHeader() { // Filter the post content
			
			global $post;
			
			add_filter('the_content', 'DisplayPRTMagicFilter');
		} 
		
		function DisplayPRTMagicFilter($content) {  // Replace magic text with list of topics
			
			return str_replace('{phpbb_recent_topics}', DisplayPRT(), $content);
		} 
		
		
		function DisplayPRT() {  // The standard display function
			
			ob_start(); // Start the cache 
			
			require(WP_PLUGIN_DIR . "/phpbb-recent-topics/display/display.php"); // run my code.
			
			$PRT_html = ob_get_contents();
			
			ob_end_clean(); // clean cache
			
			return $PRT_html; // return output
		} 
		
		# Legacy function for side bar
		function phpbb_topics($LIMIT = "") {
			
			require(WP_PLUGIN_DIR . "/phpbb-recent-topics/display/display.php");
		}
		
		# New sidebar widget (options)
		function wiget_options_phpbb_recent_topics() {
			
			$options = $newoptions = get_option('prt_widget'); // widget options
			
			if ( $_POST["prt-submit"] ) {
				$newoptions['title'] = strip_tags(stripslashes($_POST["prt-title"]));
			}
			
			if ( $options != $newoptions ) {
				$options = $newoptions;
				update_option('prt_widget', $options);
			}
			
			$title = attribute_escape($options['title']);
			?>
<p><label for="prt-title"><?php _e('Title:'); ?> <input class="widefat" id="prt-title" name="prt-title" type="text" value="<?php echo $title; ?>" /></label></p>
<input type="hidden" id="prt-submit" name="prt-submit" value="1" />
<?php
		}
	
		# New sidebar widget (display)
		function widget_phpbb_recent_topics($args) {
			
			# Credits to http://toni.uebernickel.info/entwicklung/wordpress/phpbb-recent-topics-widget/
			# for pointing out my mistake!!
			
			extract($args); // get variables
			$options = get_option('prt_widget'); // retrieve title
			$title = stripslashes($options['title']);
			
			echo $before_widget, $before_title, $title, $after_title;
			
			require(WP_PLUGIN_DIR . "/phpbb-recent-topics/display/display.php");
			
			echo $after_widget;
		}
		
		# Widget init function (for action below).
		function phpbb_recent_topics_init_widget() {
			if (!function_exists('register_sidebar_widget'))
				
				return;
			
			register_sidebar_widget('phpBB Recent Topics','widget_phpbb_recent_topics');
			register_widget_control('phpBB Recent Topics', 'wiget_options_phpbb_recent_topics', 300, 100);
		}
		
		# Delay plugin execution until sidebar is loaded
		add_action('widgets_init', 'phpbb_recent_topics_init_widget');
	
	}
	
	?>