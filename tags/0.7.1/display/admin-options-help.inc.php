<p><strong>phpbb_recent_topics</strong> is a plugin which will allow you to display recent phpbb posts and topics in your sidebar, post content and anywhere you can call a function.
</p>
<p>This software is provided free of charge, support is provided by the WordPress comminity <a href="http://wordpress.org/tags/phpbb-recent-topics">in this forum</a> and you can <a href="http://wordpress.org/tags/phpbb-recent-topics?forum_id=10#postform">use this form to ask questions and get support</a>. <br />
If you are a bit of a wizard, you can use the WordPress trac for feature request,  <a href="http://plugins.trac.wordpress.org/newticket?component=phpbb-recent-topics&owner=linickx"><strong>Open a ticket here for patch sumission and bug reports.</strong></a>. <br />
Remember to show your love to WordPress plugin developers by <a href="http://www.linickx.com/donate">dontaing to the author</a>.
</p>
<p>
<strong>How does this plugin work?</strong> <br />
To display your phpbb content this plugin must make a mysql (database) connection  from WordPress to the phpbb database, therefore it is important that you understand this and configure it correctly; failling to configure the database connection is the most common issue users have!
</p>
<p>
<strong>What are all these options then?</strong> <br />
Below is a list descibing what each option does, good luck and may the force be with you!
</p>
<ul>
<li><strong>phpbb MySQL Database Name:</strong> This is the name of your phpbb database. In the config.php of your phpbb installation this is what you have filled in for $dbname</li>
<li><strong>Enable Insecure Database Connection:</strong> Enabling this is not advisable, but is necessary for some users. The best option is to GRANT access to the mysql wordpress user to access the phpbb mysql database, instructions on what to do are found in <a href="http://wordpress.org/extend/plugins/phpbb-recent-topics/other_notes/">the readme</a>. If your WordPress and phpbb database are on separate servers then insecure connectivity is your only option.</li>
<li><strong>phpbb MySQL Database UserName:</strong> Only vailable with insecure connectivity. In the config.php of your phpbb installation this is what you have filled in for $dbuser</li>
<li><strong>phpbb MySQL Database Password:</strong> Only vailable with insecure connectivity. In the config.php of your phpbb installation this is what you have filled in for $dbpasswd</li>
<li><strong>phpbb MySQL Database Server:</strong> Only vailable with insecure connectivity. In the config.php of your phpbb installation this is what you have filled in for $dbhost</li>
<li><strong>phpbb Topics Table Name:</strong> This is the table in the phpbb database that lists all the topics. If you have change $table_prefix in the phpbb config.php from phpbb_ to something else then you need to change this, most people do not. </li>
<li><strong>phpbb Forums Table Name:</strong> This is the table in the phpbb database that lists all the forums. If you have change $table_prefix in the phpbb config.php from phpbb_ to something else then you need to change this, most people do not. </li>
<li><strong>phpbb Posts Table Name:</strong> This is the table in the phpbb database that lists all the posts. If you have change $table_prefix in the phpbb config.php from phpbb_ to something else then you need to change this, most people do not. </li>
<li><strong>phpbb forum URL:</strong> This is the link to your forum such as www.domain.com/phpbb3.</li>
<li><strong>Number of Topics to show:</strong> This is the number of items to show.</li>
<li><strong>Date and Time Formmating:</strong> This is tweaks the output of the date and time, more infomation can be found <a href="http://codex.wordpress.org/Formatting_Date_and_Time">in codex here</a>, make this blank if you want to suppress the date and time.</li>
<li><strong>Sort Results by Post Date:</strong> By default the topic list is sorted by the creation date of the subject, tick this box to sort by the date of the most recent post in a subject.</li>
<li><strong>Enable Tooltip:</strong> This option enables a fancy tooltip showing the first post.</li>
<li><strong>Tooltip Size:</strong> Only available if the tooltip is enabled, you can tweak how long the tooltip should be.</li>
<li><strong>Excluded Forums:</strong> Tick boxes to exclude forums from the output.</li>
<li><strong>Open link in new window:</strong> This will cause the links to open new windows when clicked..</li>
</ul>
<p>There is no fancy javasript on this page (<em>yet</em>) you will need to click SAVE OPTIONS each time you make a change.</p>
<p>
<strong>If all else fails, check <a href="http://plugins.trac.wordpress.org/browser/phpbb-recent-topics/trunk/readme.txt">the latest README</a>.</strong>
</p>




