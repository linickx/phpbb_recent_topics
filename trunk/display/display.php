<?php
	
	# Setup our Wordpress DB Connection
	global $wpdb, $lnx_PRT_options;
	
	# Limit can be set either in the DB or via a Template Tag, so we check it here....
	
	if (is_null($LIMIT)) { 
		
		$LIMIT = $lnx_PRT_options['prt_phpbb_limit'];
		
		if (is_null($LIMIT)) {
			$LIMIT = 5;
		}
		
	}
	
	# Error Check $LIMIT...
	if (!is_numeric($LIMIT)) {
		
		$LIMIT = 5;
		
	}
	settype($LIMIT, "integer"); // No fractions jokers
	$LIMIT = abs($LIMIT); //and no negative limits 
	
	
	
	# Connect to php BB
	#
	# Insecure Method
	if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") { 
		
		$phpbbdb = new wpdb($lnx_PRT_options['prt_phpbb_dbinsecureuid'], $lnx_PRT_options['prt_phpbb_dbinsecurepw'], $lnx_PRT_options['prt_phpbb_db'], $lnx_PRT_options['prt_phpbb_dbinsecurehost']);
		
	} else {
		
		# Secure Method
		$wpdb->select($lnx_PRT_options['prt_phpbb_db']);
		
	}
	
	# Run The query - SQL Querey restructuring by Number3NL
	
	if (is_array($lnx_PRT_options['prt_phpbb_exclued'])) {
		$counter = 0;
		$countermax = count($lnx_PRT_options['prt_phpbb_exclued']) -1;
		# Construct Excluded Query
		$EXCLUDED_FORUM = "AND ";
		foreach ($lnx_PRT_options['prt_phpbb_exclued'] as $EXCLUDED) {
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
	$sql_query = "SELECT * FROM $lnx_PRT_options[prt_phpbb_tt] WHERE TOPIC_APPROVED = 1 $EXCLUDED_FORUM $EXCLUDED_FORUM ORDER BY";
	
	if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") {
		$sql_query .= " topic_last_post_time"; // Sort by Post Date/Time
	} else {
		$sql_query .= " topic_time"; // Sort by Topic Date/Time
	} 
	
	$sql_query .= " DESC LIMIT $LIMIT";
	
	# Execute SQL Query
	if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") {
		$results = $phpbbdb->get_results($sql_query);
	} else {
		$results = $wpdb->get_results($sql_query);
	}
	
	# Build the recent (active) topics now
	if ($results){
		
		echo '<ul class="prt_ul" >';	
		
		# Loop away baby !
		foreach ($results as $topic)
		{
			
			echo '<li class="prt_li" >';
			echo "<a ";
			
			if ($lnx_PRT_options['prt_phpbb_newwin'] == "1") { echo "target=\"_blank\""; } // Enable open in new window feature.
			
			if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") {
				echo " href='" . $lnx_PRT_options['prt_phpbb_url'] . "/viewtopic.php?p=$topic->topic_last_post_id#p$topic->topic_last_post_id'";	
			} else {
				echo " href='" . $lnx_PRT_options['prt_phpbb_url'] . "/viewtopic.php?t=$topic->topic_id'"; 
			}
			if ($lnx_PRT_options['prt_phpbb_body_as_tooltip'] == "1") { // Body tooltips are enabled <- Feature by Number3NL
				
				$sql_query = "SELECT * FROM $lnx_PRT_options[prt_phpbb_pt] WHERE "; 
				
				if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") { 
					$sql_query .= "post_id=" . $topic->topic_last_post_id;
				} else {
					$sql_query .= "topic_id=" . $topic->topic_id;
				}
				$sql_query .= " LIMIT 1";

				# Run Query
				if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") {
					$post= $phpbbdb->get_row($sql_query);
				} else {
					$post = $wpdb->get_row($sql_query);
				}
				
	        	$post->post_text = preg_replace("(\[.+?\])is",'',$post->post_text); // strip BBcodes from post
				$post->post_text = strip_tags($post->post_text); // Strip HTML / PHP Tags from post.
				$post->post_text = substr($post->post_text,0,$lnx_PRT_options[prt_phpbb_tooltipsize])."..."; //limit the quote from the body to $prt_phpbb_tooltipsize chars
	        	
				echo " title='" . $post->post_text . "' ";

			}
			echo ">";
			
			if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") {
				echo "$topic->topic_last_post_subject";
			} else {
				echo "$topic->topic_title";
			}
			echo "</a>";
			
			if ($lnx_PRT_options['prt_phpbb_date'] != "") {
				
				$offset = 3600 * get_option('gmt_offset');
				echo "<br />\n";
				
				if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") { 
					$phpbb_time = $topic->topic_last_post_time + $offset;
				} else {
					$phpbb_time = $topic->topic_time + $offset;
				}
				
				echo "<small><i>" . mysql2date("$lnx_PRT_options[prt_phpbb_date]", $phpbb_time) . "</i></small>\n";
			}
			
			echo "</li>";
		}
		
		echo "</ul>";
		
	} else {
		echo "<h2> phpBB Error - $lnx_PRT_options[prt_phpbb_tt] </h2>"; // No Results!
	}
	
	if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] != "1") {
		# Connect back to wordpress :-)
		$wpdb->select(DB_NAME);
	}
	
	?>