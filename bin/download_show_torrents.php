<?

require_once( __DIR__ . '/../bootstrap.php');



/* @TODO - abstract this out to an ORM */
$insert_stmt = DB::getInstance()->prepare("INSERT INTO showlog (show_name, season, episode, air_date, download_date) VALUES ( :show_name, :season, :episode, :air_date, :download_date)");
$insert_stmt->bindParam(':show_name', $show_name, PDO::PARAM_STR);
$insert_stmt->bindParam(':season', $season, PDO::PARAM_INT);
$insert_stmt->bindParam(':episode', $episode, PDO::PARAM_INT);
$insert_stmt->bindParam(':air_date', $air_date, PDO::PARAM_STR);
$insert_stmt->bindParam(':download_date', $download_date, PDO::PARAM_STR);
$lookup_stmt = DB::getInstance()->prepare("
	SELECT count(*) as ALREADY_HAVE 
	FROM showlog
	WHERE
		( upper(show_name) = upper(:show_name) )
		AND
		( season = :season )
		AND
		( episode = :episode )
		AND
		download_date IS NOT NULL
");
$lookup_stmt->bindParam(':show_name', $show_name, PDO::PARAM_STR);
$lookup_stmt->bindParam(':season', $season, PDO::PARAM_INT);
$lookup_stmt->bindParam(':episode', $episode, PDO::PARAM_INT);


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
		
			$lookup_stmt->execute();
			$result = $lookup_stmt->fetch();
			if ( ! $result['ALREADY_HAVE'] && $item->getLink() ) {
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
					$insert_stmt->execute();
				}
			}
			else {
				print "Skipping, already have\n";
			}
		}
	}
}


