<?php
	
	# Where am I ?
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=phpbb-recent-topics/display/admin-options.php';
	
	# Setup our phpbb Settings.
	add_option('prt_phpbb_db', __('', 'prt'));
	add_option('prt_phpbb_tt', __('phpbb_topics', 'prt'));
	add_option('prt_phpbb_url', __('', 'prt'));
	add_option('prt_phpbb_limit', __('5', 'prt'));
	add_option('prt_phpbb_date', __('d/M/y - g:i a', 'prt'));
	add_option('prt_phpbb_exclued',array(0));
	add_option('prt_phpbb_ft', __('phpbb_forums', 'prt'));
	add_option('prt_phpbb_newwin', __('0', 'prt'));
	add_option('prt_phpbb_dbinsecureon', __('0', 'prt'));
	add_option('prt_phpbb_dbinsecureuid', __('phpbbuser', 'prt'));
	add_option('prt_phpbb_dbinsecurepw', __('phpbbpass', 'prt'));
	add_option('prt_phpbb_dbinsecurehost', __('localhost', 'prt'));
	add_option('prt_phpbb_pt', __('phpbb_posts', 'prt'));
	add_option('prt_phpbb_latest_topic', __('0', 'prt'));
	
	# If we've been submitted, then save :-)
	if ('process' == $_POST['stage'])
	{
		update_option('prt_phpbb_db', $_POST['prt_phpbb_db']);
		update_option('prt_phpbb_tt', $_POST['prt_phpbb_tt']);
		update_option('prt_phpbb_ft', $_POST['prt_phpbb_ft']);
		update_option('prt_phpbb_pt', $_POST['prt_phpbb_pt']);
		update_option('prt_phpbb_url', $_POST['prt_phpbb_url']);
		update_option('prt_phpbb_limit', $_POST['prt_phpbb_limit']);
		update_option('prt_phpbb_date', $_POST['prt_phpbb_date']);
        update_option('prt_phpbb_exclued', $_POST['prt_phpbb_exclued']);
		update_option('prt_phpbb_newwin', $_POST['prt_phpbb_newwin']);
		update_option('prt_phpbb_latest_topic', $_POST['prt_phpbb_latest_topic']);
		update_option('prt_phpbb_dbinsecureon', $_POST['prt_phpbb_dbinsecureon']);
		update_option('prt_phpbb_dbinsecureuid', $_POST['prt_phpbb_dbinsecureuid']);
		update_option('prt_phpbb_dbinsecurepw', $_POST['prt_phpbb_dbinsecurepw']);
		update_option('prt_phpbb_dbinsecurehost', $_POST['prt_phpbb_dbinsecurehost']);
	}
	
	# When loading the form, fill in our old values....
	
	$prt_phpbb_db = stripslashes(get_option('prt_phpbb_db'));
	$prt_phpbb_tt = stripslashes(get_option('prt_phpbb_tt'));
	$prt_phpbb_ft = stripslashes(get_option('prt_phpbb_ft'));
	$prt_phpbb_pt = stripslashes(get_option('prt_phpbb_pt'));
	$prt_phpbb_url = stripslashes(get_option('prt_phpbb_url'));
	$prt_phpbb_limit = stripslashes(get_option('prt_phpbb_limit'));
	$prt_phpbb_date = stripslashes(get_option('prt_phpbb_date'));
	$prt_phpbb_exclued = get_option('prt_phpbb_exclued');
	$prt_phpbb_newwin = stripslashes(get_option('prt_phpbb_newwin'));
	$prt_phpbb_latest_topic = stripslashes(get_option('prt_phpbb_latest_topic'));
	$prt_phpbb_dbinsecureon = stripslashes(get_option('prt_phpbb_dbinsecureon'));
	$prt_phpbb_dbinsecureuid = stripslashes(get_option('prt_phpbb_dbinsecureuid'));
	$prt_phpbb_dbinsecurepw = stripslashes(get_option('prt_phpbb_dbinsecurepw'));
	$prt_phpbb_dbinsecurehost = stripslashes(get_option('prt_phpbb_dbinsecurehost'));
	
	# Only Allow Admins Access
	if (current_user_can('level_10')) {
		
		# How do we connect to phpbb?
		if ($prt_phpbb_dbinsecureon != "1") {
			
			# COnnect to phpBB and get a list of forums
			$wpdb->select($prt_phpbb_db);
			
			# Run The query
        	$results = $wpdb->get_results("SELECT forum_id,forum_name FROM $prt_phpbb_ft");
			
        	# Connect back to wordpress :-)
        	$wpdb->select(DB_NAME);
			
		} else {
			# Make new DB Connection
			$phpbbdb = new wpdb($prt_phpbb_dbinsecureuid, $prt_phpbb_dbinsecurepw, $prt_phpbb_db, $prt_phpbb_dbinsecurehos);
			# Run The query
        	$results = $phpbbdb->get_results("SELECT forum_id,forum_name FROM $prt_phpbb_ft");
		}
		
		# Now print the admin form!
	?>
<div class="wrap">
<h2><?php _e('phpBB Recent Topics') ?></h2>
<form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
<input type="hidden" name="stage" value="process" />
<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database Name') ?></th>
<td><input name="prt_phpbb_db" id="prt_phpbb_db" class="regular-text" value="<?php echo $prt_phpbb_db; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Enable Insecure Database Connection') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="prt_phpbb_dbinsecureon" value="1" <?php if ($prt_phpbb_dbinsecureon == "1") { echo "checked"; } ?>/><span class="description"> Only do this if you really have too! Please see README for more details</span></td></tr></table>
</td>
</tr>
<?php if ($prt_phpbb_dbinsecureon == "1") { ?>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database UserName') ?></th>
<td><input name="prt_phpbb_dbinsecureuid" id="prt_phpbb_dbinsecureuid" class="regular-text" value="<?php echo $prt_phpbb_dbinsecureuid; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Database Password') ?></th>
<td><input name="prt_phpbb_dbinsecurepw" id="prt_phpbb_dbinsecurepw" class="regular-text" value="<?php echo $prt_phpbb_dbinsecurepw; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb MySQL Server') ?></th>
<td><input name="prt_phpbb_dbinsecurehost" id="prt_phpbb_dbinsecurehost" class="regular-text" value="<?php echo $prt_phpbb_dbinsecurehost; ?>" />
</td>
</tr>

<?php } ?>
<tr valign="top">
<th scope="row"><?php _e('phpbb Topics Table Name') ?></th>
<td><input name="prt_phpbb_tt" id="prt_phpbb_tt" class="regular-text" value="<?php echo $prt_phpbb_tt; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb Forums Table Name') ?></th>
<td><input name="prt_phpbb_ft" id="prt_phpbb_ft" class="regular-text" value="<?php echo $prt_phpbb_ft; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb Posts Table Name') ?></th>
<td><input name="prt_phpbb_pt" id="prt_phpbb_pt" class="regular-text" value="<?php echo $prt_phpbb_pt; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('phpbb forum URL') ?></th>
<td><input name="prt_phpbb_url" id="prt_phpbb_url" class="regular-text" value="<?php echo $prt_phpbb_url; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Number of Topics to show') ?></th>
<td><input name="prt_phpbb_limit" id="prt_phpbb_limit" class="regular-text" value="<?php echo $prt_phpbb_limit; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Date and Time Formmating') ?></th>
<td><input name="prt_phpbb_date" id="prt_phpbb_date" class="regular-text" value="<?php echo $prt_phpbb_date; ?>" />
<span class="description"> See <a href="http://codex.wordpress.org/Formatting_Date_and_Time">WP Codex Documentation on date formatting</a></span></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Sort Results by Post Date') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="prt_phpbb_latest_topic" value="1" <?php if ($prt_phpbb_latest_topic == "1") { echo "checked"; } ?>/></td></tr></table>
<span class="description">By default results are isorted by the Date of Topic <em>creation</em>, this will sort topics by <em>freshness</em>.</span></td>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Enable Tooltip') ?></th>
<td>
<table><tr><td>Enable</td><td><input type="checkbox" name="prt_phpbb_body_as_tooltip" value="1" <?php if ($prt_phpbb_body_as_tooltip == "1") { echo "checked"; } ?>/></td></tr></table>
<span class="description"> The post content will be shown as a tooltip over the link.</span></td>
</td>
</tr>
<?php
	if ($results){
	?>
<tr valign="top">
<th scope="row"><?php _e('Excluded Forums') ?></th>
<td><table><?php foreach ($results as $forum) {
	?><tr><td><?php echo $forum->forum_name;?></td><td><input type="checkbox" name="prt_phpbb_exclued[]" value="<?php echo $forum->forum_id;?>" <?php
		if (is_array($prt_phpbb_exclued)) {
			foreach ($prt_phpbb_exclued as $excluded) {
				# Switch on Check Boxes!
				if ($excluded == $forum->forum_id) {
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
<table><tr><td>Enable</td><td><input type="checkbox" name="prt_phpbb_newwin" value="1" <?php if ($prt_phpbb_newwin == "1") { echo "checked"; } ?>/></td></tr></table>
</td>
</tr>

</table>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'prt') ?> &raquo;" />
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
<p><small><a href="http://www.linickx.com/archives/tag/phpbb_recent_topics/feed">Subcribe to this feed</a></small></p>

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