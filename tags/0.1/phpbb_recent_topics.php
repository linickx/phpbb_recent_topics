<?php
/*
Plugin Name: phpbb_recent_topics
Plugin URI: http://www.linickx.com/blog/archives/266/recent-phpbb-topics-on-wordpress-plugin
Description: This plugin gives you the recent posts in your phpBB, derived from the phpBB Recent Posts plugin for Wordpress by <a href="http://yoda.gatewayy.net/">Brandon Alexander</a>
Version: 0.1
Author: Nick [LINICKX] Bettison
Author URI: http://www.linickx.com
*/


function phpbb_topics($limit = 10) {

//Obviously we can't grab the PHPBB settings, so type them here !
$PHPBBDB = "phpbb_database"; // phpBB db name
$TOPIC_TABLE = "phpbb_topics"; // phpbb topics table
$SITEURL = "http://www.domain.com/phpbb"; //Forum (phpbb) URL 

//
// Do not edit beyond this point
// -----------------------------
	global $wpdb;


$wpdb->select($PHPBBDB);

$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE ORDER BY topic_time DESC LIMIT $limit");

if ($results){
	
		echo "<ul>";	
	
	foreach ($results as $topic)
		{

		echo "<li>";
		echo "<a href='" . $SITEURL . "/viewtopic.php?t=$topic->topic_id'>";
		echo "$topic->topic_title";
		echo "</a>";
		echo "<br />\n";
		 echo "<small><i>" . date("d/M/y - g:i a", $topic->topic_time) . "</i></small>\n";
		echo "</li>";
		}

		echo "</ul>";
	}

$wpdb->select(DB_NAME);

}

function phpbb_inlinetopics( $content = '' ) {
	
	ob_start(); // Enable output buffering to supress echos

	phpbb_topics(5); // run function

	$result = ob_get_contents(); 

	ob_end_clean(); // Empty the Buffer

	echo str_replace("{phpbb_recent_topics}", $result, $content);


}

add_filter('the_content', 'phpbb_inlinetopics');

?>
