<?php

# Where am I ?
$location = get_option('siteurl') . '/wp-admin/admin.php?page=phpbb-recent-topics/display/admin-options.php';

# Setup our phpbb Settings.
add_option('prt_phpbb_db', __('', 'prt'));
add_option('prt_phpbb_tt', __('phpbb_topics', 'prt'));
add_option('prt_phpbb_url', __('', 'prt'));
add_option('prt_phpbb_limit', __('5', 'prt'));
add_option('prt_phpbb_date', __('d/M/y - g:i a', 'prt'));

# If we've been submitted, then save :-)
if ('process' == $_POST['stage'])
{
	update_option('prt_phpbb_db', $_POST['prt_phpbb_db']);
	update_option('prt_phpbb_tt', $_POST['prt_phpbb_tt']);
	update_option('prt_phpbb_url', $_POST['prt_phpbb_url']);
	update_option('prt_phpbb_limit', $_POST['prt_phpbb_limit']);
	update_option('prt_phpbb_date', $_POST['prt_phpbb_date']);
}

# When loading the form, fill in our old values....

$prt_phpbb_db = stripslashes(get_option('prt_phpbb_db'));
$prt_phpbb_tt = stripslashes(get_option('prt_phpbb_tt'));
$prt_phpbb_url = stripslashes(get_option('prt_phpbb_url'));
$prt_phpbb_limit = stripslashes(get_option('prt_phpbb_limit'));
$prt_phpbb_date = stripslashes(get_option('prt_phpbb_date'));

if (current_user_can('level_10')) {

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
  </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'prt') ?> &raquo;" />
    </p>
  </form>
</div>

<?php

} else {

?>

<div class="wrap">
  <h2><?php _e('phpBB Recent Topics') ?></h2>

<p>Sorry you do not have access to this page</p>

</div>

<?php
}
?>
