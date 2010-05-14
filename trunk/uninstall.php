<?php
	
	// Uninstall
	// Reference: http://jacobsantos.com/2008/general/wordpress-27-plugin-uninstall-methods/
	
	if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
	
	// Delete All WordPress Options
	
	delete_option('prt_phpbb_db');
	delete_option('prt_phpbb_tt');
	delete_option('prt_phpbb_url');
	delete_option('prt_phpbb_limit');
	delete_option('prt_phpbb_date');
	delete_option('prt_phpbb_exclued');
	delete_option('prt_phpbb_ft');
	delete_option('prt_phpbb_newwin');
	delete_option('prt_phpbb_dbinsecureon');
	delete_option('prt_phpbb_dbinsecureuid');
	delete_option('prt_phpbb_dbinsecurepw');
	delete_option('prt_phpbb_dbinsecurehost');
	delete_option('prt_phpbb_pt');
	delete_option('prt_phpbb_latest_topic');
	delete_option('prt_phpbb_body_as_tooltip');
	delete_option('prt_phpbb_tooltipsize');
	
	// Done, all clean.
	
	?>