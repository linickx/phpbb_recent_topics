<?php

//Obviously we can't grab the PHPBB settings, so type them here !
//$PHPBBDB = "phpbb_database"; // phpBB db name
//$TOPIC_TABLE = "phpbb_topics"; // phpbb topics table
//$SITEURL = "http://www.domain.com/phpbb"; //Forum (phpbb) URL 

$PHPBBDB = "web4_db2"; //phpBB db name
$TOPIC_TABLE = "phpbb_topics"; //phpbb topics table
$SITEURL = "http://www.allaboutmice.co.uk/forum"; //Forum URL


//
// Do not edit beyond this point
// -----------------------------
	global $wpdb;

	if (is_null($limit)) { 
		$limit = 5; 
	}

$wpdb->select($PHPBBDB);

$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE WHERE forum_id != 27 ORDER BY topic_time DESC LIMIT $limit");

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

?>
