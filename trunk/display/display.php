<?php
	
	# Get the Options from the Database
	
	$PHPBBDB = stripslashes(get_option('prt_phpbb_db'));
	$TOPIC_TABLE = stripslashes(get_option('prt_phpbb_tt'));
	$SITEURL = stripslashes(get_option('prt_phpbb_url'));
	$PHPBBDATE = stripslashes(get_option('prt_phpbb_date'));
	$PHPBBEXCLUDED = get_option('prt_phpbb_exclued');
	$OPENINNEWWIN = stripslashes(get_option('prt_phpbb_newwin'));
	# TODO change above variables to match "admin-display" style, cause it makes more sense!
	$prt_phpbb_dbinsecureon = stripslashes(get_option('prt_phpbb_dbinsecureon'));
	
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
	#
	# Insecure Method
	if ($prt_phpbb_dbinsecureon == "1") { 
		
		$prt_phpbb_dbinsecureuid = stripslashes(get_option('prt_phpbb_dbinsecureuid'));
		$prt_phpbb_dbinsecurepw = stripslashes(get_option('prt_phpbb_dbinsecurepw'));
		$prt_phpbb_dbinsecurehost = stripslashes(get_option('prt_phpbb_dbinsecurehost'));
		
		$phpbbdb = new wpdb($prt_phpbb_dbinsecureuid, $prt_phpbb_dbinsecurepw, $PHPBBDB, $prt_phpbb_dbinsecurehos);
		
	} else {
		# Secure Method
		
		$wpdb->select($PHPBBDB);
		
	}
	
	# Run The query
	
	if (is_array($PHPBBEXCLUDED)) {
		$counter = 0;
		$countermax = count($PHPBBEXCLUDED) -1;
		# Construct Excluded Query
		$EXCLUDED_FORUM = "AND ";
		foreach ($PHPBBEXCLUDED as $EXCLUDED) {
			$EXCLUDED_FORUM .= "forum_id !=$EXCLUDED";
			if ($counter < $countermax  ) {
				$EXCLUDED_FORUM .= " AND ";
			}
			$counter++;
		}
		
			// Added WHERE TOPIC_APPROVED = 1 to the following, creditz Ashish http://www.microstrategy101.com/
		
		if ($prt_phpbb_dbinsecureon == "1") {
			
			$results = $phpbbdb->get_results("SELECT * FROM $TOPIC_TABLE WHERE TOPIC_APPROVED = 1 $EXCLUDED_FORUM ORDER BY topic_time DESC LIMIT $LIMIT");
			
		} else {
			
			$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE WHERE TOPIC_APPROVED = 1 $EXCLUDED_FORUM ORDER BY topic_time DESC LIMIT $LIMIT");
			
		}
	} else {
		# No excluded Query
		
		if ($prt_phpbb_dbinsecureon == "1") {
			
			$results = $phpbbdb->get_results("SELECT * FROM $TOPIC_TABLE WHERE TOPIC_APPROVED = 1 ORDER BY topic_time DESC LIMIT $LIMIT");
		} else {
			$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE  WHERE TOPIC_APPROVED = 1 ORDER BY topic_time DESC LIMIT $LIMIT");
		}
	}
	
	if ($results){
		
		echo "<ul>";	
		
		# Loop away baby !
		foreach ($results as $topic)
		{
			
			echo "<li>";
			echo "<a ";
			if ($OPENINNEWWIN == "1") { echo "target=\"_blank\""; }
			echo " href='" . $SITEURL . "/viewtopic.php?t=$topic->topic_id'>";
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
	
	if ($prt_phpbb_dbinsecureon != "1") {
		# Connect back to wordpress :-)
		$wpdb->select(DB_NAME);
	}
	
	?>