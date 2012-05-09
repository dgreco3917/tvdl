<?

class Queue {
	private $feeds;
	
	public function __construct ( $feeds=array() ) {
		if ( is_array($feeds) && count($feeds) ) {
			$this->setFeeds($feeds);	
		}
	}
	
	public function setFeeds ( $feeds=array() ) {
		if ( is_array($feeds) && count($feeds) ) {
			$this->feeds = $feeds;
		}
		else {
			throw new Exception("Please provide an array of feeds");
		}
	}
	
	public function listAvailable () {
		$available = array();
		foreach ( ShowQueue::retrieve() as $show_queue ) {
			print "SQ- " . $show_queue->getShowName() . "\n";
			foreach ( $this->feeds as $feed_class ) {
				$feed = new $feed_class( $show_queue->getShowName() );
				print "checking feed - " . $feed->getName() . "\n";
				foreach ( $feed->getItems() as $item ) {
		
					# search over RSS is often not that good, lets make sure the show name matches
					if ( $show_queue->getShowName() != $item->getShowName() ) {
						continue;
					}

					print $item->getShowName() . " S" . $item->getSeason() . " E" . $item->getEpisodeNumber() . "\n";
					if ( ! count(ShowLog::retrieveDownloaded(array('show_name'=>$item->getShowName(), 'season'=>$item->getSeason(), 'epsiode'=>$item->getEpisodeNumber()))) 
						&& $item->getLink()
					) {
						$available[] = $item;						
					}
				}
			}
		}
		
		return $available;
	}
	
	public function downloadAvailable () {
		$downloads = $this->listAvailable();
		$files = array();
		foreach ( $downloads as $item ) {		
			print "Downloading torrent:\n";
			try {
				$f = $item->getLink()->saveToFile(null, Config::get('fallback_torrent_dir'));
			}
			catch (Exception $e) {
				continue;
			}
			print "Data saved to $f\n";
			if ( @filesize($f) > 0 ) {
				$files[] = $f;
				$download_date = date('Y-m-d H:i:s');
				$s = new ShowLog();
				$s->setShowName($item->getShowName());
				$s->setEpisode($item->getEpisodeNumber());
				$s->setSeason($item->getSeason());
				$s->setDownloadDate( R::isoDateTime() );
				$s->create();
			}
		}
		
		return $files;		
	}	
}