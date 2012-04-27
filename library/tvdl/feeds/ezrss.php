<?
class EZRss_Feed {

	public function __construct ( $show_name ) {
		try {
			$this->feed = new Zend_Feed_Rss("http://www.ezrss.it/search/index.php?show_name=" . urlencode($show_name). "&date=&quality=&release_group=&mode=rss");
		}
		catch (Exception $e) {
			print "Could not access EZRss Feed\n";
		}
	}
	public function getFeed () {
		return $this->feed;
	}
	public function getName() {
		return "EZTV RSS Feed";
	}
	public function getItems() {
		$items = array();
		if ( ! $this->feed ) {
			return null;
		}
		foreach ( $this->feed as $item ) {
			$ez = new EZRss_Item($item);
			array_push($items, $ez);
		}
		return $items;
	}
}


class EZRss_Item extends Feed_Item {

/*
        GOT ITEM:
                title=The Daily Show 2012-04-25 [HDTV - FQM]
                link=http://torrent.zoink.it/The.Daily.Show.2012.04.25.(HDTV-FQM)[VTV].torrent
                date=Wed, 25 Apr 2012 22:15:23 -0500
                description=Show Name: The Daily Show; Episode Title: N/A; Episode Date: 2012-04-25
                category=TV Show / The Daily Show
                comments=http://eztv.it/forum/discuss/34931/
        GOT ITEM:
                title=South Park 16x7 [HDTV - COMPULSION]
                link=http://torrent.zoink.it/South.Park.S16E07.HDTV.x264-COMPULSiON.[eztv].torrent
                date=Wed, 25 Apr 2012 21:56:39 -0500
                description=Show Name: South Park; Episode Title: N/A; Season: 16; Episode: 7
                category=TV Show / South Park
                comments=http://eztv.it/forum/discuss/34930/
*/

	public function __construct ( $feed_item=null ) {
		if ( $feed_item ) {
			$this->setFeedItem($feed_item);
		}
	}
	
	public function setFeedItem ( $feed_item ) {
		$this->feed_item = $feed_item;
	}

	public function getShowName ( ) {
		$this->parseDescription();
		return $this->show_name;
	}
	public function getEpisodeTitle () {
		$this->parseDescription();
		return $this->episode_title;
	}
	public function getSeason () {
		$this->parseDescription();
		return $this->season;
	}
	public function getEpisodeNumber () {
		$this->parseDescription();
		return $this->episode_number;
	}
	public function getEpisodeDate () {
		$this->parseDescription();
		return $this->episode_date;
	}
	public function getLink () {
		return new Link($this->feed_item->link);
	}		

	private function parseDescription () {
		$keypairs = explode(';', $this->feed_item->description);
		foreach ( $keypairs as $keypair ) {
			$keyvalue = explode(':', $keypair);
			switch ( trim($keyvalue[0]) ) {
				case 'Show Name':
					$this->show_name = trim($keyvalue[1]);
					break;
				case 'Episode Title':
					$this->episode_title = trim($keyvalue[1]);
					break;
				case 'Season':
					$this->season = trim($keyvalue[1]);
					break;
				case 'Episode':
					$this->episode_number = trim($keyvalue[1]);
					break;
				case 'Episode Date':
					$this->episode_date = trim($keyvalue[1]);
					break;
			}
		}
	}
	
}



