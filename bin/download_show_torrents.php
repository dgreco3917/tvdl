<?

require_once( __DIR__ . '/../bootstrap.php');


/* @TODO - abstract this out to an ORM */
foreach ( DB::getInstance()->query("SELECT name FROM showqueue WHERE active=1") as $show_list ) {
	foreach ( $rss_feeds as $feed_class ) {
		$feed = new $feed_class( $show_list['name'] );
		print "checking feed - " . $feed->getName() . "\n";
		foreach ( $feed->getItems() as $item ) {
		
			# search over RSS is often not that good, lets make sure the show name matches
			if ( $show_list['name'] != $item->getShowName() ) {
				continue;
			}

			print $item->getShowName() . " S" . $item->getSeason() . " E" . $item->getEpisodeNumber() . "\n";
			$show_name = $item->getShowName();
			$season = $item->getSeason();
			$episode = $item->getEpisodeNumber();
		
			if ( ! count(ShowLog::retrieveDownloaded(array('show_name'=>$show_name, 'season'=>$season, 'epsiode'=>$episode))) 
				&& $item->getLink()
			) {
				print "Downloading torrent:\n";
				try {
					$f = $item->getLink()->saveToFile(null, $fallback_torrent_dir);
				}
				catch (Exception $e) {
					continue;
				}
				print "Data saved to $f\n";
				if ( @filesize($f) > 0 ) {
					$download_date = date('Y-m-d H:i:s');
					$s = new ShowLog();
					$s->setShowName($item->getShowName());
					$s->setEpisode($item->getEpisode());
					$s->setSeason($item->getSeason());
					$s->setDownloadDate( date() );
					$s->create();
				}
			}
			else {
				print "Skipping, already have\n";
			}
		}
	}
}


