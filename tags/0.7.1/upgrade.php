<?php
	
	/*
	 This script will upgrade our options from the legacy format to the new array
	 */
	
	if (get_option('prt_phpbb_db')) {
		
		// we have found old options, let's convert them!
		
		$lnx_PRT_options = array(); // Create options array....
		
		$lnx_PRT_options['prt_phpbb_db'] = stripslashes(get_option('prt_phpbb_db'));
		$lnx_PRT_options['prt_phpbb_tt'] = stripslashes(get_option('prt_phpbb_tt'));
		$lnx_PRT_options['prt_phpbb_ft'] = stripslashes(get_option('prt_phpbb_ft'));
		$lnx_PRT_options['prt_phpbb_pt'] = stripslashes(get_option('prt_phpbb_pt'));
		$lnx_PRT_options['prt_phpbb_url'] = stripslashes(get_option('prt_phpbb_url'));
		$lnx_PRT_options['prt_phpbb_limit'] = stripslashes(get_option('prt_phpbb_limit'));
		$lnx_PRT_options['prt_phpbb_date'] = stripslashes(get_option('prt_phpbb_date'));
		$lnx_PRT_options['prt_phpbb_exclued'] = get_option('prt_phpbb_exclued');
		$lnx_PRT_options['prt_phpbb_newwin'] = stripslashes(get_option('prt_phpbb_newwin'));
		$lnx_PRT_options['prt_phpbb_latest_topic'] = stripslashes(get_option('prt_phpbb_latest_topic'));
		$lnx_PRT_options['prt_phpbb_body_as_tooltip'] = stripslashes(get_option('prt_phpbb_body_as_tooltip'));
		$lnx_PRT_options['prt_phpbb_tooltipsize'] = stripslashes(get_option('prt_phpbb_tooltipsize'));
		$lnx_PRT_options['prt_phpbb_dbinsecureon'] = stripslashes(get_option('prt_phpbb_dbinsecureon'));
		$lnx_PRT_options['prt_phpbb_dbinsecureuid'] = stripslashes(get_option('prt_phpbb_dbinsecureuid'));
		$lnx_PRT_options['prt_phpbb_dbinsecurepw'] = stripslashes(get_option('prt_phpbb_dbinsecurepw'));
		$lnx_PRT_options['prt_phpbb_dbinsecurehost'] = stripslashes(get_option('prt_phpbb_dbinsecurehost'));
		
		update_option('lnx_PRT_options', $lnx_PRT_options); // Save new options array to db.
		
		delete_option('prt_phpbb_db'); // delete the old sh*t.
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
		
		}
		
	?>