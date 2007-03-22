=== Plugin Name ===
Contributors: Nick Bettison - LINICKX
Donate link: http://www.linickx.com/index.php?content=donate
Tags: phpBB, forum, topics, sidebar
Requires at least: 2.0.9
Tested up to: 2.0.9
Stable tag: 0.3

This plugin grabs your recent phpBB forum topics for you to display in wordpress.

== Description ==

Do you have a phpBB forum, do you want to drag your blog readers into your forum ? Then this plugin might just help, you can include somewhere in wordpress a list of recent phpbb threads (topics) in a page, a post, and even in your theme - so your sidebar for example !

== Installation ==

1. unzip phpbb_recent_topics.zip in your `/wp-content/plugins/` directory. (You'll have a new directory, with this plugin in `/wp-content/plugins/phpbb_recent_topics`)

1. Activate the plugin through the 'Plugins' menu in WordPress

1. Configure the plugin, you need to tell wordpress about phpbb, this is done in the wordpress menu 'Options' -> 'phpBB Recent Topics'

	The following Settings are required:

		* The name of your phpBB database (e.g phpbb)
		* The name of the table where topics are held (the default is phpbb_topics )
		* The full url of your forum for links (e.g. http://www.mydomain.com/forum)
		* The number of topics to show. (If left blank you get 5)

1. Hit 'Update Options"
1. 	To output the list of topics in a page or post... 

		* create a new page/post, type `{phpbb_recent_topics}` , hit 'Publish' or 'Create new page'
	To output the list of topics in your theme sidebar...

		* edit sidebar.php and inside `<div id="sidebar">` type...

		`<?php
	        if (function_exists('phpbb_topics')) {
				phpbb_topics();
			} 
		?>`

== Frequently Asked Questions ==

= Can I output 10 Topics in my Page, and 3 Topics in my Sidebar ? =

Yes ! In the Wordpress menu 'Options' -> 'phpBB Recent Topics', set 'The number of topics to show' to 10, and then in your sidebar include...

	`<?php
	    if (function_exists('phpbb_topics')) {
			phpbb_topics(3);
		} 
	?>`

= Can I exclude a certain forum from the list ? =

In this version, the only way to do that is to hack `/wp-content/plugins/phpbb_recent_topics/display/display.php`, change

	`$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE ORDER BY topic_time DESC LIMIT $LIMIT");`

to

	`$results = $wpdb->get_results("SELECT * FROM $TOPIC_TABLE WHERE forum_id != 1 ORDER BY topic_time DESC LIMIT $LIMIT");`
to exclude forum 1 from the list.
