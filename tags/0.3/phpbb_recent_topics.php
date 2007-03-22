<?php 
/*
Plugin Name: phpbb_recent_topics
Plugin URI: http://www.linickx.com/blog/archives/273/recent-phpbb-topics-on-wordpress-plugin-v03
Description: This plugin grabs your recent phpBB topics for you to display in wordpress.
Version: 0.3
Author: Nick [LINICKX] Bettison
Author URI: http://www.linickx.com
*/

 // The path to the plugin 

define('PRTPLUGINPATH', (DIRECTORY_SEPARATOR != '/') ? str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__)) : dirname(__FILE__));
 /* * The base class */
 	class phpbbRecentTopics { 
	/* * The boostrap function */
 		function bootstrap() { 
			// Add the installation and uninstallation hooks 
			$file = PRTPLUGINPATH . '/' . basename(__FILE__);
 			register_activation_hook($file, array('phpbbRecentTopics', 'install'));
 			register_deactivation_hook($file, array('phpbbRecentTopics', 'uninstall'));
 			// Add the actions 
			add_action('wp_head', array('phpbbRecentTopics', 'DisplayPRTHeader'));
			add_action('admin_head', array('phpbbRecentTopics','PRT_add_admin_options'));
 			} 
			/* * The installation function */
 			function install() { } 
			/* * The uninstallation function */
 			function uninstall() { } 
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

			function PRT_add_admin_options() {
    			
			add_options_page('phpBB Recent Topics Options', 'phpBB Recent Topics', 'manage_options', 'phpbb_recent_topics/display/admin-options.php');


			}



} 

 
phpbbRecentTopics::bootstrap();

// legacy sidebar function
function phpbb_topics($LIMIT) {
	require(PRTPLUGINPATH . '/display/display.php');
}
 
?>
