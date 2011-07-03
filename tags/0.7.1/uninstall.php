<?php
	
	// Uninstall
	// Reference: http://jacobsantos.com/2008/general/wordpress-27-plugin-uninstall-methods/
	
	if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
	
	// Delete our WordPress Options
	
	delete_option('lnx_PRT_options');
	delete_option('prt_widget'); // 2do, add to array.
	
	// Done, all clean.
	
	?>