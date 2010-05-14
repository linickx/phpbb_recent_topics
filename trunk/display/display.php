<?php
	
	# Get the Options from the Database
	
	$PHPBBDB = stripslashes(get_option('prt_phpbb_db'));
	$TOPIC_TABLE = stripslashes(get_option('prt_phpbb_tt'));
	$POSTS_TABLE = stripslashes(get_option('prt_phpbb_pt'));
	$SITEURL = stripslashes(get_option('prt_phpbb_url'));
	$PHPBBDATE = stripslashes(get_option('prt_phpbb_date'));
	$PHPBBEXCLUDED = get_option('prt_phpbb_exclued');
	$OPENINNEWWIN = stripslashes(get_option('prt_phpbb_newwin'));
	# TODO change above variables to match "admin-display" style, cause it makes more sense!
	$prt_phpbb_dbinsecureon = stripslashes(get_option('prt_phpbb_dbinsecureon'));
	$prt_phpbb_latest_topic = stripslashes(get_option('prt_phpbb_latest_topic'));
	$prt_phpbb_body_as_tooltip = stripslashes(get_option('prt_phpbb_body_as_tooltip'));
	
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
	
	# Check the $POSTS_TABLE variable
	
	if (is_null($POSTS_TABLE)) {
		
		$TOPIC_TABLE = "phpbb_posts";
		
	}
	
	# if $POSTS_TABLE is set up empty :)
	if ($POSTS_TABLE == "") {
		
		$POSTS_TABLE = "phpbb_topics";
		
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
		// Build a query based on some paramters Changed by Number3NL (12 may 2010)
	
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
	} else {
        $EXCLUDED_FORUM = "";
	}
	
		// Added WHERE TOPIC_APPROVED = 1 to the following, creditz Ashish http://www.microstrategy101.com/
	$sql_query = "SELECT * FROM $TOPIC_TABLE WHERE TOPIC_APPROVED = 1 $EXCLUDED_FORUM $EXCLUDED_FORUM ORDER BY";
	
	if ($prt_phpbb_latest_topic == "1") {
		$sql_query .= " topic_last_post_time";
	} else {
		$sql_query .= " topic_time";
	} 
	
	$sql_query .= " DESC LIMIT $LIMIT";
	
		//finally fetch it from the database
	if ($prt_phpbb_dbinsecureon == "1") {
		$results = $phpbbdb->get_results($sql_query);
	} else {
		$results = $wpdb->get_results($sql_query);
	}
	
		//Next build the recent (active) topics now
	if ($results){
		
		echo "<ul>";	
		
		# Loop away baby !
		foreach ($results as $topic)
		{
			
			echo "<li>";
				//echo "$topic->post_text";
			echo "<a ";
			if ($OPENINNEWWIN == "1") { echo "target=\"_blank\""; }
			if ($prt_phpbb_latest_topic == "1") {
				echo " href='" . $SITEURL . "/viewtopic.php?p=$topic->topic_last_post_id#p$topic->topic_last_post_id'";	
			} else {
				echo " href='" . $SITEURL . "/viewtopic.php?t=$topic->topic_id'"; 
			}
			if ($prt_phpbb_body_as_tooltip == "1") {
					//** fetch post body
					//build query
				$sql_query = "SELECT * FROM $POSTS_TABLE WHERE "; 
				if ($prt_phpbb_latest_topic == "1") { 
					$sql_query .= "post_id=" . $topic->topic_last_post_id;
				} else {
					$sql_query .= "topic_id=" . $topic->topic_id;
				}
				$sql_query .= " LIMIT 1";
					//run query
				if ($prt_phpbb_dbinsecureon == "1") {
					$post= $phpbbdb->get_row($sql_query);
				} else {
					$post = $wpdb->get_row($sql_query);
				}
				
					//strip BBcodes from post
	        	$post->post_text = preg_replace("(\[.+?\])is",'',$post->post_text);
					//limit the quote from the body to xxx chars
        		$post->post_text = substr($post->post_text,0,512)."..."; 
	        	echo " title='" . $post->post_text . "' ";
					//** and that's all folks
			}
			echo ">";
			
			if ($prt_phpbb_latest_topic == "1") {
				echo "$topic->topic_last_post_subject";
			} else {
				echo "$topic->topic_title";
			}
			echo "</a>";
			
			if ($PHPBBDATE != "") {
				echo "<br />\n";
				if ($prt_phpbb_latest_topic == "1") { 
					echo "<small><i>" . date("$PHPBBDATE", $topic->topic_last_post_time) . "</i></small>\n";
				} else {
					echo "<small><i>" . date("$PHPBBDATE", $topic->topic_time) . "</i></small>\n";
				}
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