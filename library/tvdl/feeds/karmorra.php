<?

class Karmorra_Feed {

	public function __construct ( $show_name ) {
		try {
			$show_id = $this->getShowId($show_name);
			if ( $show_id ) {
				$this->feed = new Zend_Feed_Rss("http://showrss.karmorra.info/feeds/$show_id.rss");
			}
		}
		catch (Exception $e) {
			print "Could not access Karmorra Feed\n";
		}
	}
	public function getFeed () {
		return $this->feed;
	}
	public function getName() {
		return "Showrss.karmorra.info RSS Feed";
	}
	public function getItems() {
		$items = array();
		if ( ! $this->feed ) {
			return array();
		}
		foreach ( $this->feed as $item ) {
			$i = new Karmorra_Item($item);
			array_push($items, $i);
		}
		return $items;
	}

	public function getShowId ( $show_name ) {
		$shows = $this->getShowList();
		return $shows[ strtoupper($show_name) ];
	}
	
	private function getShowList () {
		/* @TODO - add some caching of the show list from karmorra */
		$html = new simple_html_dom();
		$html->load( file_get_contents("http://showrss.karmorra.info/?cs=browse") );
		$select_list = $html->find('select#browse_show', 0)->childNodes();
		$show_list = array();
		foreach ( $select_list as $f ) {
			$show_list[ strtoupper($f->innertext) ] = $f->value;			
		}
		return $show_list;
	}
}


class Karmorra_Item extends Feed_Item {

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
	/*
	<strong>New standard torrent for 2 Broke Girls:</strong> 
	<strong>2 Broke Girls</strong> 1x14. Torrent link: 
	<a href="http://showrss.karmorra.info/r/0cc362575cef82582112489efa748c25.torrent">http://showrss.karmorra.info/r/0cc362575cef82582112489efa748c25.torrent</a>
	*/	
		$isFormatGood = preg_match( '/\<strong\>(.*)\<\/strong\>\s*\<strong\>(.*)\<\/strong\>\s*(\d+)[x\.](\d+)(.*)/', $this->feed_item->description, $matches );
		if ( ! $isFormatGood ) {
			throw new Exception("Description field contents have changed. Please check showrss.karmorra.info");
		}
		$this->show_name = $matches[2];
		$this->season = (int) $matches[3];
		$this->episode_number = (int) $matches[4];
	}
	
}



