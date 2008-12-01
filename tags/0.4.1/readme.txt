=== Plugin Name ===
Contributors: Nick Bettison - LINICKX
Donate link: http://www.linickx.com/index.php?content=donate
Tags: phpBB, forum, topics, sidebar
Requires at least: 2.0.9
Tested up to: 2.5
Stable tag: 0.4.1

This plugin grabs your recent phpBB forum topics for you to display in wordpress.

== Description ==

Do you have a phpBB forum, do you want to drag your blog readers into your forum ? Then this plugin might just help, you can include somewhere in wordpress a list of recent phpbb threads (topics) in a page, a post, and even in your theme - so your sidebar for example !

== Installation ==

1. unzip phpbb_recent_topics.zip in your `/wp-content/plugins/` directory. (You'll have a new directory, with this plugin in `/wp-content/plugins/phpbb_recent_topics`)

1. Activate the plugin through the 'Plugins' menu in WordPress

1. Configure the plugin, you need to tell wordpress about phpbb, this is done in the wordpress menu 'Settings' -> 'phpBB Recent Topics'

	The following Settings are required:

		* The name of your phpBB database (e.g phpbb)
		* The name of the table where topics are held (the default is phpbb_topics )
		* The full url of your forum for links (e.g. http://www.mydomain.com/forum)
		* The number of topics to show. (If left blank you get 5)
		* The Date Formatting, i.e. "d/M/y - g:i a" similar to the WordPress "General Settings"

1. Hit 'Update Options"
1. 	To output the list of topics in a page or post... 

		* create a new page/post, type `{phpbb_recent_topics}` , hit 'Publish' or 'Create new page'
	To output the list of topics in your theme sidebar using the widget…
		* click “design” in the dashboard
		* click “widgets”
		* next to phpBB Recent Topics click “add”
		* click "save changes"
	To output the list of topics in your theme sidebar...

		* edit sidebar.php and inside `<div id="sidebar">` type...

		`<?php
	        if (function_exists('phpbb_topics')) {
				phpbb_topics();
			} 
		?>`

== Frequently Asked Questions ==

= Is phpBB3 Supported ?=
Yes.

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

= Why is the date config under settings not in the widget configuration? =
The date settings effect both the template tag and the widget

== Screenshots ==

1. The Admin interface, where you set up the magic !

== A bit about Database configuration. ==
If wordpress & phpBB share a DB already then set $PHPBBDB to DB_NAME and everything will be fine, else you.re going to need to GRANT the wordpress user read access to phpBB.

== How to GRANT wordpress read only access to phpBB ? ==
If you don.t know it already you need to find your wordpress mysql user id, it.ll be in wp-config.php

`define('DB_USER', 'wp_user');     // Your MySQL username`

and you should have already found your phpbb database & table for the above.
You need to type the following syntax into your mysql database

`GRANT SELECT ON phpbb_database.phpbb_topics TO wp_user@localhost;`

this can be achieved by logging into phpmyadmin as your phpbb user, selecting SQL and pasting the correct GRANT into the text box.
