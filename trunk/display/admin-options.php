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

# If we've been submitted, then save :-)
if ('process' == $_POST['stage'])
{
	update_option('prt_phpbb_db', $_POST['prt_phpbb_db']);
	update_option('prt_phpbb_tt', $_POST['prt_phpbb_tt']);
	update_option('prt_phpbb_ft', $_POST['prt_phpbb_ft']);
	update_option('prt_phpbb_url', $_POST['prt_phpbb_url']);
	update_option('prt_phpbb_limit', $_POST['prt_phpbb_limit']);
	update_option('prt_phpbb_date', $_POST['prt_phpbb_date']);
        update_option('prt_phpbb_exclued', $_POST['prt_phpbb_exclued']);
}


# When loading the form, fill in our old values....

$prt_phpbb_db = stripslashes(get_option('prt_phpbb_db'));
$prt_phpbb_tt = stripslashes(get_option('prt_phpbb_tt'));
$prt_phpbb_ft = stripslashes(get_option('prt_phpbb_ft'));
$prt_phpbb_url = stripslashes(get_option('prt_phpbb_url'));
$prt_phpbb_limit = stripslashes(get_option('prt_phpbb_limit'));
$prt_phpbb_date = stripslashes(get_option('prt_phpbb_date'));
$prt_phpbb_exclued = get_option('prt_phpbb_exclued');

# COnnect to phpBB and get a list of forums
$wpdb->select($prt_phpbb_db);

	# Run The query
	$results = $wpdb->get_results("SELECT forum_id,forum_name FROM $prt_phpbb_ft");

# Now print the admin form!
?>
<div class="wrap">
  <h2><?php _e('phpBB Recent Topics') ?></h2>
  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
  <input type="hidden" name="stage" value="process" />
  <table width="100%" cellspacing="2" cellpadding="5" class="editform">
    <tr valign="top">
      <th scope="row"><?php _e('phpbb MySQL Database Name') ?></th>
      <td><input name="prt_phpbb_db" id="prt_phpbb_db" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_db; ?>" />
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('phpbb Topics Table Name') ?></th>
      <td><input name="prt_phpbb_tt" id="prt_phpbb_tt" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_tt; ?>" />
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('phpbb Forums Table Name') ?></th>
      <td><input name="prt_phpbb_ft" id="prt_phpbb_ft" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_ft; ?>" />
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('phpbb forum URL') ?></th>
      <td><input name="prt_phpbb_url" id="prt_phpbb_url" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_url; ?>" />
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('Number of Topics to show') ?></th>
      <td><input name="prt_phpbb_limit" id="prt_phpbb_limit" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_limit; ?>" />
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('Date Formmating') ?></th>
      <td><input name="prt_phpbb_date" id="prt_phpbb_date" style="width: 80%;" rows="1" wrap="virtual" cols="50" value="<?php echo $prt_phpbb_date; ?>" />
      </td>
    </tr>
<?php
	if ($results){
?>
    <tr valign="top">
      <th scope="row"><?php _e('Excluded Forums') ?></th>
      <td><table><?php foreach ($results as $forum) {
		?><tr><td><?php echo $forum->forum_name;?></td><td><input type="checkbox" name="prt_phpbb_exclued[]" value="<?php echo $forum->forum_id;?>" <?php 
	foreach ($prt_phpbb_exclued as $excluded) {
		# Switch on Check Boxes!
		if ($excluded == $forum->forum_id) {
			echo "checked";
		}
	} ?>/></td></tr><?php
	} ?></table>
      </td>
    </tr>

<?php
        }

?>
  </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'prt') ?> &raquo;" />
    </p>
  </form>
</div>
