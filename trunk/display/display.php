<?php
	
	# Get the Options from the Database
	
	$prt_phpbb_db = stripslashes(get_option('prt_phpbb_db'));
	$prt_phpbb_tt = stripslashes(get_option('prt_phpbb_tt'));
	$prt_phpbb_pt = stripslashes(get_option('prt_phpbb_pt'));
	$prt_phpbb_url = stripslashes(get_option('prt_phpbb_url'));
	$prt_phpbb_date = stripslashes(get_option('prt_phpbb_date'));
	$prt_phpbb_exclued = get_option('prt_phpbb_exclued');
	$prt_phpbb_newwin = stripslashes(get_option('prt_phpbb_newwin'));
	$prt_phpbb_dbinsecureon = stripslashes(get_option('prt_phpbb_dbinsecureon'));
	$prt_phpbb_latest_topic = stripslashes(get_option('prt_phpbb_latest_topic'));
	$prt_phpbb_body_as_tooltip = stripslashes(get_option('prt_phpbb_body_as_tooltip'));
	$prt_phpbb_tooltipsize = stripslashes(get_option('prt_phpbb_tooltipsize'));
	
	# Setup our Wordpress DB Connection
	global $wpdb;
	
	# Limit can be set either in the DB or via a Template Tag....
	
	if (is_null($LIMIT)) { 
		
		$LIMIT = stripslashes(get_option('prt_phpbb_LIMIT'));
		
		if (is_null($LIMIT)) {
			$LIMIT = 5;
		}
		
		
	}
	
	# Error Check $LIMIT...
	if (!is_numeric($LIMIT)) {
		
		$LIMIT = 5;
		
	}
	settype($LIMIT, "integer"); // No fractions jokers
	
	# Error check $prt_phpbb_tooltipsize
	if (!is_numeric($prt_phpbb_tooltipsize)) {
		
		$prt_phpbb_tooltipsize = 512;
		
	}
	settype($prt_phpbb_tooltipsize, "integer");
	
	
	# Check the $prt_phpbb_tt variable
	if (is_null($prt_phpbb_tt)) {
		
		$prt_phpbb_tt = "phpbb_topics";
		
	}
	
	# if $prt_phpbb_tt is set up empty :)
	if ($prt_phpbb_tt == "") {
		
		$prt_phpbb_tt = "phpbb_topics";
		
	}
	
	# Check the $prt_phpbb_pt variable
	if (is_null($prt_phpbb_pt)) {
		
		$prt_phpbb_tt = "phpbb_posts";
		
	}
	
	# if $prt_phpbb_pt is set up empty :)
	if ($prt_phpbb_pt == "") {
		
		$prt_phpbb_pt = "phpbb_posts";
		
	}
	
	
	# Connect to php BB
	#
	# Insecure Method
	if ($prt_phpbb_dbinsecureon == "1") { 
		
		$prt_phpbb_dbinsecureuid = stripslashes(get_option('prt_phpbb_dbinsecureuid'));
		$prt_phpbb_dbinsecurepw = stripslashes(get_option('prt_phpbb_dbinsecurepw'));
		$prt_phpbb_dbinsecurehost = stripslashes(get_option('prt_phpbb_dbinsecurehost'));
		
		$phpbbdb = new wpdb($prt_phpbb_dbinsecureuid, $prt_phpbb_dbinsecurepw, $prt_phpbb_db, $prt_phpbb_dbinsecurehos);
		
	} else {
		
		# Secure Method
		$wpdb->select($prt_phpbb_db);
		
	}
	
	# Run The query - SQL Querey restructuring by Number3NL
	
	if (is_array($prt_phpbb_exclued)) {
		$counter = 0;
		$countermax = count($prt_phpbb_exclued) -1;
		# Construct Excluded Query
		$EXCLUDED_FORUM = "AND ";
		foreach ($prt_phpbb_exclued as $EXCLUDED) {
			$EXCLUDED_FORUM .= "forum_id !=$EXCLUDED";
			if ($counter < $countermax  ) {
				$EXCLUDED_FORUM .= " AND ";
			}
			$counter++;
		}
	} else {
        $EXCLUDED_FORUM = "";
	}
	
	# Added WHERE TOPIC_APPROVED = 1 to the following, creditz Ashish http://www.microstrategy101.com/
	$sql_query = "SELECT * FROM $prt_phpbb_tt WHERE TOPIC_APPROVED = 1 $EXCLUDED_FORUM $EXCLUDED_FORUM ORDER BY";
	
	if ($prt_phpbb_latest_topic == "1") {
		$sql_query .= " topic_last_post_time"; // Sort by Post Date/Time
	} else {
		$sql_query .= " topic_time"; // Sort by Topic Date/Time
	} 
	
	$sql_query .= " DESC LIMIT $LIMIT";
	
	# Execute SQL Query
	if ($prt_phpbb_dbinsecureon == "1") {
		$results = $phpbbdb->get_results($sql_query);
	} else {
		$results = $wpdb->get_results($sql_query);
	}
	
	# Build the recent (active) topics now
	if ($results){
		
		echo "<ul>";	
		
		# Loop away baby !
		foreach ($results as $topic)
		{
			
			echo "<li>";
			echo "<a ";
			
			if ($prt_phpbb_newwin == "1") { echo "target=\"_blank\""; } // Enable open in new window feature.
			
			if ($prt_phpbb_latest_topic == "1") {
				echo " href='" . $prt_phpbb_url . "/viewtopic.php?p=$topic->topic_last_post_id#p$topic->topic_last_post_id'";	
			} else {
				echo " href='" . $prt_phpbb_url . "/viewtopic.php?t=$topic->topic_id'"; 
			}
			if ($prt_phpbb_body_as_tooltip == "1") { // Body tooltips are enabled <- Feature by Number3NL
				
				$sql_query = "SELECT * FROM $prt_phpbb_pt WHERE "; 
				
				if ($prt_phpbb_latest_topic == "1") { 
					$sql_query .= "post_id=" . $topic->topic_last_post_id;
				} else {
					$sql_query .= "topic_id=" . $topic->topic_id;
				}
				$sql_query .= " LIMIT 1";

				# Run Query
				if ($prt_phpbb_dbinsecureon == "1") {
					$post= $phpbbdb->get_row($sql_query);
				} else {
					$post = $wpdb->get_row($sql_query);
				}
				
	        	$post->post_text = preg_replace("(\[.+?\])is",'',$post->post_text); // strip BBcodes from post
				$post->post_text = strip_tags($post->post_text); // Strip HTML / PHP Tags from post.
				$post->post_text = substr($post->post_text,0,$prt_phpbb_tooltipsize)."..."; //limit the quote from the body to $prt_phpbb_tooltipsize chars
	        	
				echo " title='" . $post->post_text . "' ";

			}
			echo ">";
			
			if ($prt_phpbb_latest_topic == "1") {
				echo "$topic->topic_last_post_subject";
			} else {
				echo "$topic->topic_title";
			}
			echo "</a>";
			
			if ($prt_phpbb_date != "") {
				echo "<br />\n";
				if ($prt_phpbb_latest_topic == "1") { 
					echo "<small><i>" . date("$prt_phpbb_date", $topic->topic_last_post_time) . "</i></small>\n";
				} else {
					echo "<small><i>" . date("$prt_phpbb_date", $topic->topic_time) . "</i></small>\n";
				}
			}
			
			echo "</li>";
		}
		
		echo "</ul>";
		
	} else {
		echo "<h2> phpBB Error - $prt_phpbb_tt </h2>"; // No Results!
	}
	
	if ($prt_phpbb_dbinsecureon != "1") {
		# Connect back to wordpress :-)
		$wpdb->select(DB_NAME);
	}
	
	?>