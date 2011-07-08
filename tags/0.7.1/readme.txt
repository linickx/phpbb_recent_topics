=== Plugin Name ===
Contributors: linickx
Donate link: http://www.linickx.com/donate
Tags: phpBB, forum, topics, sidebar, posts
Requires at least: 2.0.9
Tested up to: 3.2
Stable tag: 0.7.1

This plugin grabs your recent phpBB forum topics for you to display in wordpress.

== Description ==

Do you have a phpBB forum, do you want to drag your blog readers into your forum ? Then this plugin might just help, you can include somewhere in wordpress a list of recent phpbb threads (topics) in a page, a post, and even in your theme - so your sidebar for example !

== Installation ==

1. Setup your Database Connection, see Other Notes

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

= Is phpBB3 Supported ? =
Yes.

= Can I output 10 Topics in my Page, and 3 Topics in my Sidebar ? =

Yes ! In the Wordpress menu 'Options' -> 'phpBB Recent Topics', set 'The number of topics to show' to 10, and then in your sidebar include...

	`<?php
	    if (function_exists('phpbb_topics')) {
			phpbb_topics(3);
		} 
	?>`

= Can I exclude a certain forum from the list ? =

Yes, use the new 0.5.x feature in the admin settings

= Why do I get - Sorry you do not have access to this page? =

You're not an Administrator

= Why is the date config under settings not in the widget configuration? =

The date settings effect both the template tag and the widget

= What is Insecure MySQL Connectivity ? =

Some people cannot GRANT priveliges from one DB to another; insecure connectivity allows you to store the phpbb database credentials within the WordPress database.

= Why is Insecure MySQL Connectivity Insecure? =

The phpbb database credentials are stored in the WordPress database in CLEAR TEXT, this is bad, as anyone with access to the WP DB can get full access to phpbb. Another reason is that usually the credentials given to the phpbb application are FULL access, we only need to read the database, so it's much better to restrict access.

= Can I connect to a phpbb databse on a different server? =

Yes, use the Insecure Connectivity method, and change the host to the IP address of the server


== Screenshots ==

1. The Admin interface, where you set up the magic !

== Changelog ==

= 0.7.1 =
* Last minute date fix!

= 0.7 =
* WordPress 3.1.4 Testing
* CSS Styleable output
* Plugin Options Modernisation
** Collapse multiple options into an array
** Implement register settings to close  http://plugins.trac.wordpress.org/ticket/1217
** Implement upgrade.php to migrate all variable to new array form
* Resolved: Missing argument 1 for phpbb_topics()
* Code clean-up (Lots of changes)
* Timezone/Off-Set fix (Reads +/- hours from WordPress Settings)
* Localisation of date/time fix (http://plugins.trac.wordpress.org/ticket/1173)
* Callback functionality
* Contextual Help in the admin dashboard


= 0.6 =
* Code by Number3NL
** PHPBB Recent Posts
** 1st Draft - Tool Tip Feature
** SQL Query Re-Write / Improvement
* Code Clean Up - Variables
* Tool Tip Feature Improvement
** Custom Size
** Strip Tags :) 
* Uninstall compatability
* Admin UI Improvements

= 0.5.3 =
* Minor Bug Fix for Error Msg: Invalid argument supplied on line 144

= 0.5.2 =
* 0.4.2 patch for WP 2.8.x Added to 0.5.x Branch
* New Insecure Connectivity option added
* Admin Settings page has CSS that matches WP 2.7/2.8 rather than 2.5 :)
* Only Approved posts allowed - creditz Ashish http://www.microstrategy101.com/

= 0.5.1 =
* Option for link to forum to be opened in new window added.

= 0.5 =
* New Exclude Forums functionality added

= 0.4.2 =
* Fixed for WordPress 2.8.x

= 0.4.1 =
* Widget fixed

= 0.4 =
* Plugin Tested with WP2.5 & PHPBB3
* Quashed the install bug where by phpbb-recent-topics was confused with phpbb_recent_topics
* Sidebar widget implemented
* Editable Time & Date support added

= 0.3 =
* Admin Interface Added

= 0.2 =
* Internal Release, changed display method to fix compatability issue with other plugins

= 0.1 =
* First Release :)

== Upgrade Notice ==

This upgrade is optional.

== A bit about Database configuration. ==
If wordpress & phpBB share a DB already then set $PHPBBDB to DB_NAME and everything will be fine, else you.re going to need to GRANT the wordpress user read access to phpBB. (If you really need to, you can store the phpbb databse credential in the plugin using the "Insecure" connectivity method.)

== How to GRANT wordpress read only access to phpBB ? ==
If you don.t know it already you need to find your wordpress mysql user id, it.ll be in wp-config.php

`define('DB_USER', 'wp_user');     // Your MySQL username`

and you should have already found your phpbb database & table for the above.
You need to type the following syntax into your mysql database

`GRANT SELECT ON phpbb_database.phpbb_topics TO wp_user@localhost;`

AND

`GRANT SELECT ON phpbb_database.phpbb_forums TO wp_user@localhost;`

AND

`GRANT SELECT ON phpbb_database.phpbb_posts TO wp_user@localhost;`

this can be achieved by logging into phpmyadmin as your phpbb user, selecting SQL and pasting the correct GRANT into the text box.

== How to use the Insecure Database Connectivity Method ==

From the phpbb_recent_topics admin / settings page, tick the .Enable Insecure Database Connection. box, and submit, when the page re-freshes you.ll have some more boxes to populate, from your phpbb config.php fill in

`
$dbuser = phpbb MySQL Database UserName
$dbpasswd = phpbb MySQL Database Password
$dbhost = phpbb MySQL Server
`

Click update, and you should be connected!

== The Callback function ==

To allow users to customize what is / can be displayed a callback function `phpbb_topics_callback` has been implemented.

In ticket 1216 (http://plugins.trac.wordpress.org/ticket/1216) phil suggested that the forum name should be displayed within the topic list; the following code is an example use of the new callback function and should be added to your themes functions.php


`
function phpbb_topics_callback($phpbbdb, $wpdb, $lnx_PRT_options, $topic) {

        // GET FORUM WHICH POST IS IN - Phil Ewels, 26/09/2010
        $sql_query = "SELECT * FROM $lnx_PRT_options[prt_phpbb_ft] WHERE forum_id=" . $topic->forum_id. " LIMIT 1";

        # Run Query
        if ($lnx_PRT_options['prt_phpbb_dbinsecureon'] == "1") {
                $forum = $phpbbdb->get_row($sql_query);
        } else {
                $forum = $wpdb->get_row($sql_query);
        }

        echo "<br /><small>" . $forum->forum_name . " </small>";

}
`

The following variables can be used within your callback function:
* $wpdb 
** If using Secure Connectivity this is a connection to your PHPBB Database
** If using Insecure Connectivity this is the standard WordPress Database
* $phpbbdb
** If using Secure Connectivity this will be NULL
** If using Insecure Connectivity this is a connection to your PHPBB Database
* $lnx_PRT_options
** An array of the phpbb-recent-topics settings
* $topic
** The current topic, with associated attributes.
