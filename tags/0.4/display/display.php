<?php

# Get the Options from the Database

$PHPBBDB = stripslashes(get_option('prt_phpbb_db'));
$TOPIC_TABLE = stripslashes(get_option('prt_phpbb_tt'));
$SITEURL = stripslashes(get_option('prt_phpbb_url'));
$PHPBBDATE = stripslashes(get_option('prt_phpbb_date'));

# Setup our Wordpress DB Connection
	global $wpdb;

# Are we a function call or Page call ? Set up our list length...

	if (is_null($LIMIT)) { 
		
		$LIMIT = stripslashes(get_option('prt_phpbb_LIMIT'));

		if (is_null($LIMIT)) {
                $LIMIT = 5;
	        }
	}

# Check the $TOPIC_TABLE variable

	if (is_null($TOPIC_TABLE)) {

		$TOPIC_TABLE = "phpbb_topics";

	}

	# if $TOPIC_TABLE is set up empty :)
	if ($TOPIC_TABLE == "") {

                $TOPIC_TABLE = "phpbb_topics";

        }

# Connect to php BB
$wpdb->select($PHPBBDB);

# Run The query
$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE ORDER BY topic_time DESC LIMIT $LIMIT");

if ($results){
	
		echo "<ul>";	
	
	# Loop away baby !
	foreach ($results as $topic)
		{

		echo "<li>";
		echo "<a href='" . $SITEURL . "/viewtopic.php?t=$topic->topic_id'>";
		echo "$topic->topic_title";
		echo "</a>";

		if ($PHPBBDATE != "") {
			echo "<br />\n";
			echo "<small><i>" . date("$PHPBBDATE", $topic->topic_time) . "</i></small>\n";
		}

		echo "</li>";
		}

		echo "</ul>";
} else {
		echo "<h2> phpBB Error  -$TOPIC_TABLE </h2>";
}

# Connect back to wordpress :-)
$wpdb->select(DB_NAME);

?>
