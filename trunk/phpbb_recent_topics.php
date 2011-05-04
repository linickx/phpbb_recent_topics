<?php 
	/*
	 Plugin Name: phpbb_recent_topics
	 Plugin URI: http://www.linickx.com/archives/2998/phpbb_recent_topics-version-0-6
	 Description: This plugin grabs your recent phpBB topics for you to display in wordpress.
	 Version: 0.6.1
	 Author: Nick [LINICKX] Bettison
	 Author URI: http://www.linickx.com
	 */
	
	require_once(WP_PLUGIN_DIR . "/phpbb-recent-topics/upgrade.php"); // before we start, check for upgrades.
	
	$lnx_PRT_options = get_option('lnx_PRT_options'); // Plugin Options
	
	if (is_admin()) { // load admin stuff if we are an admin.
		include_once(WP_PLUGIN_DIR . "/phpbb-recent-topics/admin.php");
	}
	
	if ($lnx_PRT_options) { // only move on if we have options..
		
		
			// The path to the plugin 
		
		define('PRTPLUGINPATH', (DIRECTORY_SEPARATOR != '/') ? str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__)) : dirname(__FILE__));
		/* * The base class */
		class phpbbRecentTopics { 
			/* * The boostrap function */
			function bootstrap() { 
					// Add the installation and uninstallation hooks 
				$file = PRTPLUGINPATH . '/' . basename(__FILE__);
				
					// Add the actions 
				add_action('wp_head', array('phpbbRecentTopics', 'DisplayPRTHeader'));
				
			} 
			
			/* * The function to check for the presence of a contact form and link to it's CSS if required */
			function DisplayPRTHeader() { 
				global $post;
				
					// Add the content filter 
				add_filter('the_content', array('phpbbRecentTopics', 'DisplayPRTMagicFilter'));
			} 
			/* * The function to display the contact form */
			function DisplayPRTMagicFilter($content) { 
				return str_replace('{phpbb_recent_topics}', phpbbRecentTopics::DisplayPRT(), $content);
			} 
			/* * The function to get the contact form's markup */
			function DisplayPRT() { 
				
					// Start the cache 
				ob_start();
					// Add the contact form 
				require(PRTPLUGINPATH . '/display/display.php');
					// Get the markup 
				$PRT_html = ob_get_contents();
					// Cleanup 
				ob_end_clean();
				return $PRT_html;
			} 
			
			
			
		} 
		
		
		phpbbRecentTopics::bootstrap();
		
			// legacy sidebar function
		function phpbb_topics($LIMIT) {
			require(PRTPLUGINPATH . '/display/display.php');
		}
		
		
			// Wiget functions...
		
		function wiget_options_phpbb_recent_topics() {
			
			$options = $newoptions = get_option('prt_widget');
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
	
	function widget_phpbb_recent_topics($args) {
		
		# Credits to http://toni.uebernickel.info/entwicklung/wordpress/phpbb-recent-topics-widget/
		# for pointing out my mistake!!
		
			// get variables
		extract($args);
			// retrieve title
		$options = get_option('prt_widget');
		$title = stripslashes($options['title']);
		
		echo $before_widget, $before_title, $title, $after_title;
		
		require(PRTPLUGINPATH . '/display/display.php');
		
		echo $after_widget;
	}
	
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