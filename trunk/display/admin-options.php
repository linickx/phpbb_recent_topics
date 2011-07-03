<?php
	
	# New install..
	
	if (!$lnx_PRT_options) {
		
		$lnx_PRT_options = array(); // Create options array....
		
		$lnx_PRT_options['prt_phpbb_db'] = "";
		$lnx_PRT_options['prt_phpbb_tt'] = "phpbb_topics";
		$lnx_PRT_options['prt_phpbb_ft'] = "phpbb_forums";
		$lnx_PRT_options['prt_phpbb_pt'] = "phpbb_posts";
		$lnx_PRT_options['prt_phpbb_url'] = "";
		$lnx_PRT_options['prt_phpbb_limit'] = "5";
		$lnx_PRT_options['prt_phpbb_date'] = "d/M/y - g:i a";
		$lnx_PRT_options['prt_phpbb_exclued'] = array(0);
		$lnx_PRT_options['prt_phpbb_newwin'] = "0";
		$lnx_PRT_options['prt_phpbb_latest_topic'] = "0";
		$lnx_PRT_options['prt_phpbb_body_as_tooltip'] = "0";
		$lnx_PRT_options['prt_phpbb_tooltipsize'] = "512";
		$lnx_PRT_options['prt_phpbb_dbinsecureon'] = "0";
		$lnx_PRT_options['prt_phpbb_dbinsecureuid'] = "phpbbuser";
		$lnx_PRT_options['prt_phpbb_dbinsecurepw'] = "phpbbpass";
		$lnx_PRT_options['prt_phpbb_dbinsecurehost'] = "localhost";
		
		update_option('lnx_PRT_options', $lnx_PRT_options); // Save new options array to db.
		
	}
	
	# Where am I ?
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=phpbb-recent-topics/display/admin-options.php';
	
	
	# Only Allow Admins Access
	if (current_user_can('level_10')) {
		
		# How do we connect to phpbb?
		if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] != "1") {
			
			# COnnect to phpBB and get a list of forums
			$wpdb->select($lnx_PRT_options['prt_phpbb_db']);
			
			# Run The query
			$tt_results = $wpdb->get_results("SELECT * FROM $lnx_PRT_options[prt_phpbb_tt] LIMIT 3"); // Topic Table Querey - check connectivity
        	$ft_results = $wpdb->get_results("SELECT forum_id,forum_name FROM $lnx_PRT_options[prt_phpbb_ft]"); // Forum Table Querey - for exclusions
			$pt_results = $wpdb->get_results("SELECT * FROM $lnx_PRT_options[prt_phpbb_pt] LIMIT 3"); // Posts Table Querey - to check recent posts functionaility
			
        	# Connect back to wordpress :-)
        	$wpdb->select(DB_NAME);
			
		} else {
			# Make new DB Connection
			$phpbbdb = new wpdb($lnx_PRT_options['prt_phpbb_dbinsecureuid'], $lnx_PRT_options['prt_phpbb_dbinsecurepw'], $lnx_PRT_options['prt_phpbb_db'], $prt_phpbb_dbinsecurehos);
			# Run The query
			$tt_results = $phpbbdb->get_results("SELECT * FROM $lnx_PRT_options[prt_phpbb_tt] LIMIT 3"); // As above
        	$ft_results = $phpbbdb->get_results("SELECT forum_id,forum_name FROM $lnx_PRT_options[prt_phpbb_ft]"); 
			$pt_results = $phpbbdb->get_results("SELECT * FROM $lnx_PRT_options[prt_phpbb_pt] LIMIT 3"); 
		}
		
		# Now print the admin form!
	?>
<div class="wrap">
<h2><?php _e('phpBB Recent Topics') ?></h2>
<?php
	if (!$tt_results) {
		echo "<div id='lnx_prt_warning' class='updated fade'><p><strong>".__('Database Error.')."</strong> ".sprintf(__('Connectivity to phpBB failed. See README for help'), "http://wordpress.org/extend/plugins/phpbb-recent-topics/")."</p></div>";
	}
	?>	
<form method="post" action="options.php">
<?php
	settings_fields('lnx_PRT_options');
	?>

<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database Name') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_db]" value="<?php echo $lnx_PRT_options['prt_phpbb_db']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Enable Insecure Database Connection') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="lnx_PRT_options[prt_phpbb_dbinsecureon]" value="1" <?php if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") { echo "checked"; } ?>/>
<?php
	if ($tt_results) {
	?>
<span class="description"><strong>Connectivity Established,</strong>
		<?php if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") {
			echo " you use this at your own risk.";
		} else {
			echo " this option is not required.";
		}	
		?>
</span>
<?php
	} else {
	?>
<span class="description"> Only do this if you really have too! Please see README for more details</span>
<?php
	}
	?>
</td></tr></table>
</td>
</tr>
<?php if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") { ?>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database UserName') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_dbinsecureuid]" value="<?php echo $lnx_PRT_options['prt_phpbb_dbinsecureuid']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database Password') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_dbinsecurepw]" value="<?php echo $lnx_PRT_options['prt_phpbb_dbinsecurepw']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Server') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_dbinsecurehost]" value="<?php echo $lnx_PRT_options['prt_phpbb_dbinsecurehost']; ?>" />
</td>
</tr>

<?php } ?>
<tr valign="top">
<th scope="row"><?php _e('phpbb Topics Table Name') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_tt]" value="<?php echo $lnx_PRT_options['prt_phpbb_tt']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb Forums Table Name') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_ft]" value="<?php echo $lnx_PRT_options['prt_phpbb_ft']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb Posts Table Name') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_pt]" value="<?php echo $lnx_PRT_options['prt_phpbb_pt']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb forum URL') ?></th>
<td><input class="regular-text" name="lnx_PRT_options[prt_phpbb_url]" value="<?php echo $lnx_PRT_options['prt_phpbb_url']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Number of Topics to show') ?></th>
<td><input name="lnx_PRT_options[prt_phpbb_limit]" value="<?php echo $lnx_PRT_options['prt_phpbb_limit']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Date and Time Formmating') ?></th>
<td><input name="lnx_PRT_options[prt_phpbb_date]" value="<?php echo $lnx_PRT_options['prt_phpbb_date']; ?>" />
<span class="description"> See <a href="http://codex.wordpress.org/Formatting_Date_and_Time">WP Codex Documentation on date formatting</a></span></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Sort Results by Post Date') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="lnx_PRT_options[prt_phpbb_latest_topic]" value="1" <?php if ($lnx_PRT_options['prt_phpbb_latest_topic'] == "1") { echo "checked"; } ?>/></td><td><span class="description">By default results are sorted by the Date of Topic <em>creation</em>, this will sort topics by <em>freshness</em>.</span></td></tr></table>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Enable Tooltip') ?></th>
<td>
<?php
	if ($pt_results) {
	?>
<table><tr><td>Enable</td><td><input type="checkbox" name="lnx_PRT_options[prt_phpbb_body_as_tooltip]" value="1" <?php if ($lnx_PRT_options['prt_phpbb_body_as_tooltip'] == "1") { echo "checked"; } ?>/></td><td><span class="description"> The post content will be shown as a tooltip over the hyperlink.</span></td></tr></table>
<?php
	} else {
	?>
	Please add new GRANT permissions <code>`GRANT SELECT ON phpbb_database.phpbb_posts TO wp_user@localhost;`</code> <br /><span class="description">See README for more details</span>
<?php
	}
	?>
</td>
</tr>
<?php
	if ($lnx_PRT_options['prt_phpbb_body_as_tooltip'] == "1") {
	?>
<tr valign="top">
<th scope="row"><?php _e('Tooltip Size') ?></th>
<td><input name="lnx_PRT_options[prt_phpbb_tooltipsize]" value="<?php echo $lnx_PRT_options['prt_phpbb_tooltipsize']; ?>" />
<span class="description"> How many characters show we show in the tooltip bubble? </span>
</td>
</tr>
<?php
	}
	?>
<?php
	if ($ft_results){
	?>
<tr valign="top">
<th scope="row"><?php _e('Excluded Forums') ?></th>
<td><table><?php foreach ($ft_results as $phpbbforum) {
	?><tr><td><?php echo $phpbbforum->forum_name;?></td><td><input type="checkbox" name="lnx_PRT_options[prt_phpbb_exclued][<?php echo $phpbbforum->forum_id;?>]" value="<?php echo $phpbbforum->forum_id;?>" <?php
		if (is_array($lnx_PRT_options['prt_phpbb_exclued'])) {
			foreach ($lnx_PRT_options['prt_phpbb_exclued'] as $excluded) {
				# Switch on Check Boxes!
				if ($excluded == $phpbbforum->forum_id) {
					echo "checked";
				}
			}
		} ?>/></td></tr><?php
			} ?></table>
</td>
</tr>

<?php
	} else {
	?>
<tr valign="top">
<th scope="row"><?php _e('Excluded Forums Not Enabled') ?></th>
<td>Please add new GRANT permissions <code>GRANT SELECT ON phpbb_database.phpbb_forums TO wp_user@localhost;</code> <br /><span class="description">See README for more details</span></td>
</tr>
<?php
	}
	
	?>

<tr valign="top">
<th scope="row"><?php _e('Open link in new window') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="lnx_PRT_options[prt_phpbb_newwin]" value="1" <?php if ($lnx_PRT_options['prt_phpbb_newwin'] == "1") { echo "checked"; } ?>/></td></tr></table>
</td>
</tr>

</table>
<p class="submit">
 <input type="submit" class="button-primary" value="<?php _e('Save Options') ?>" />
</p>
</form>
<hr />

<?php
	# Let's tell users about phpbb_recent_topics news!
	$lnx_feed = fetch_feed('http://www.linickx.com/archives/tag/phpbb_recent_topics/feed');
	?>
<h3>phpBB Recent Topics News</h3>
<ul>
<?php
	foreach ($lnx_feed->get_items() as $item){
		printf('<li><a href="%s">%s</a></li>',$item->get_permalink(), $item->get_title());
	}
	?>
</ul>
<p><small><a href="http://www.linickx.com/tag/phpbb_recent_topics/feed">Subcribe to this feed</a></small></p>

</div>
<?php
	
	# You're not an admin then
	} else {
		
	?>

<div class="wrap">
<h2><?php _e('phpBB Recent Topics') ?></h2>

<p>Sorry you do not have access to this page</p>

</div>

<?php
	}
	?>