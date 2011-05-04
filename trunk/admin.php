<?php
	
	// plug us into the admin dashboard...
	
	add_action('admin_init', 'lnx_PRT_add_admin_init' );
	add_action('admin_menu', 'lnx_PRT_add_admin_options');
	add_action('contextual_help', 'lnx_PRT_help', 10, 3);
	
	function lnx_PRT_add_admin_options() {
		
		global $lnx_PRT_admin_hook;
		
		$lnx_PRT_admin_hook = add_options_page('phpBB Recent Topics Options', 'phpBB Recent Topics', 'manage_options' , 'phpbb-recent-topics' , 'lnx_PRT_display_admin_options' );
	}
	
	function lnx_PRT_display_admin_options(){
		
		global $wpdb, $lnx_PRT_options;
		
		require_once(WP_PLUGIN_DIR . '/phpbb-recent-topics/display/admin-options.php' );
		
	}
	
	function lnx_PRT_add_admin_init() {
		
		register_setting( 'lnx_PRT_options', 'lnx_PRT_options', 'lnx_PRT_validate_options' );
		
	}
	
	function lnx_PRT_help($contextual_help, $screen_id, $screen) {
			
		global $lnx_PRT_admin_hook;
		
		if ($screen_id == $lnx_PRT_admin_hook) {
			
			$contextual_help = file_get_contents(WP_PLUGIN_DIR . '/phpbb-recent-topics/display/admin-options-help.inc.php'); // the help html
		}
		
		return $contextual_help;
	}


	function lnx_PRT_validate_options($input) { // Validate options...
		
		# on the 2do list... /// improve this, wp_filter_nohtml_kses is a good start no?
		
		#$input['prt_phpbb_db'] = "";
		
			$input['prt_phpbb_db'] =  wp_filter_nohtml_kses($input['prt_phpbb_db']);
		
		#$input['prt_phpbb_tt'] = "phpbb_topics";
		
			$input['prt_phpbb_tt'] =  wp_filter_nohtml_kses($input['prt_phpbb_tt']);
		
		#$input['prt_phpbb_ft'] = "phpbb_forums";
		
			$input['prt_phpbb_ft'] =  wp_filter_nohtml_kses($input['prt_phpbb_ft']);
		
		#$input['prt_phpbb_pt'] = "phpbb_posts";
		
			$input['prt_phpbb_pt'] =  wp_filter_nohtml_kses($input['prt_phpbb_pt']);
		
		#$input['prt_phpbb_url'] = "";
		
			$input['prt_phpbb_url'] =  wp_filter_nohtml_kses($input['prt_phpbb_url']);
		
		# $input['prt_phpbb_limit']
		
			if (is_null($input['prt_phpbb_limit'])) { 
				
				$input['prt_phpbb_limit'] = $lnx_PRT_options['prt_phpbb_limit'];
				
				if (is_null($LIMIT)) {
					$input['prt_phpbb_limit'] = 5;
				}
			}
			
			if (!is_numeric($input['prt_phpbb_limit'])) {
				
				$input['prt_phpbb_limit'] = 5;
				
			}
		
			settype($input['prt_phpbb_limit'], "integer"); // No fractions jokers
			$input['prt_phpbb_limit'] = abs($input['prt_phpbb_limit']); //and no negative limits 
			
		#$input['prt_phpbb_date'] = "d/M/y - g:i a";
		
			$input['prt_phpbb_date'] =  wp_filter_nohtml_kses($input['prt_phpbb_date']);
		
		#$input['prt_phpbb_exclued'] = array(0);
		
			if (!is_array($input['prt_phpbb_exclued'])) {
				$input['prt_phpbb_exclued'] = array(0);
			}
		
		#$input['prt_phpbb_newwin'] = "0";
			
			$input['prt_phpbb_newwin'] = ( $input['prt_phpbb_newwin'] == 1 ? 1 : 0 );
		
		#$input['prt_phpbb_latest_topic'] = "0";
			
			$input['prt_phpbb_latest_topic'] = ( $input['prt_phpbb_latest_topic'] == 1 ? 1 : 0 );
		
		#$input['prt_phpbb_body_as_tooltip'] = "0";
			
			$input['prt_phpbb_body_as_tooltip'] = ( $input['prt_phpbb_body_as_tooltip'] == 1 ? 1 : 0 );
		
		# $input['prt_phpbb_tooltipsize']
		
			if (!is_numeric($input['prt_phpbb_tooltipsize'])) {
				
				$input['prt_phpbb_tooltipsize'] = 512;
				
			}
		
			settype($input['prt_phpbb_tooltipsize'], "integer");
			$input['prt_phpbb_tooltipsize'] = abs($input['prt_phpbb_tooltipsize']); //prevent negative tooltipsizes 
			
		#$input['prt_phpbb_dbinsecureon'] = "0";
		
			$input['prt_phpbb_dbinsecureon'] = ( $input['prt_phpbb_dbinsecureon'] == 1 ? 1 : 0 );
		
		#$input['prt_phpbb_dbinsecureuid'] = "phpbbuser";
		
			$input['prt_phpbb_dbinsecureuid'] =  wp_filter_nohtml_kses($input['prt_phpbb_dbinsecureuid']);
		
		#$input['prt_phpbb_dbinsecurepw'] = "phpbbpass";
			
			$input['prt_phpbb_dbinsecurepw'] =  wp_filter_nohtml_kses($input['prt_phpbb_dbinsecurepw']);
		
		#$input['prt_phpbb_dbinsecurehost'] = "localhost";
		
			$input['prt_phpbb_dbinsecurehost'] =  wp_filter_nohtml_kses($input['prt_phpbb_dbinsecurehost']);
		
		
		return $input;
	}
?>