<?php 
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
    
    <title><?php echo $feed_name; ?></title>

    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>

    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

    <?php foreach($packages as $week => $packages_of_week): ?>
        <item>

			<title>New packages week <?php echo substr($week, -2); ?>, <?php echo substr($week, 0, 4); ?></title>
		  	<link><?php echo site_url('links/index/sort/newest'); ?></link>
		  	<guid><?php echo site_url('links/index/sort/newest'); ?></guid>

		  	<description><![CDATA[ In total there are <?php echo sizeof($packages_of_week); ?> new or updated packages this week: <?php foreach($packages_of_week as $i => $new_package) {
				  	echo $new_package['name'];
				  	if($i < sizeof($packages_of_week)-1) {
					  	echo ', ';
				  	} else {
					  	echo '.';
				  	}
			  	} ?>]]></description>
      		<pubDate><?php echo date('r', strtotime('week ' . substr($week, -2) . ' year ' . substr($week, 0, 4))); ?></pubDate>
        </item>

        
    <?php endforeach; ?>
    
    </channel></rss>