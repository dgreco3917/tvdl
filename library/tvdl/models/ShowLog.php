<?

class ShowLog {

	private $bean;

	private $id;	
	private $show_name;
	private $season;
	private $episode;
	private $air_date;
	private $download_date;
	
	public function __construct ( $data=array() ) {
		if ( $data['id'] ) {
			$this->setId( $data['id'] );
			$this->load();
		}
		else {
			$this->setShowName($data['show_name']);
	 		$this->setSeason($data['season']);
			$this->setEpisode($data['episode']);
			$this->setAirDate($data['air_date']);
			$this->setDownloadDate($data['download_date']);
			$this->bean = $this->getBean();
		}
	}
	
	private function load ( ) {
		$this->bean = R::load('showlog', $this->id);
		if ( ! $this->bean ) {
			throw new Exception("Could not find showlog id=" . $this->id);
		}
		$this->setId( $this->bean->id );
		$this->setShowName( $this->bean->show_name );
		$this->setSeason( $this->bean->season );
		$this->setEpisode( $this->bean->episode );
		$this->setAirDate( $this->bean->air_date );
		$this->setDownloadDate( $this->bean->download_date );
	}
	
	public function setId ( $s ) { $this->id=$s; return $this; }
	public function getId () { return $this->id; }
	public function setShowName ( $s ) { $this->show_name=$s; return $this; }
	public function getShowName () { return $this->show_name; }
	public function setSeason ( $s ) { $this->season=$s; return $this; }
	public function getSeason () { return $this->season; }
	public function setEpisode ( $s ) { $this->episode=$s; return $this; }
	public function getEpisode () { return $this->episode; }
	public function setAirDate ( $s ) { $this->air_date=$s; return $this; }
	public function getAirDate () { return $this->air_date; }
	public function setDownloadDate ( $s ) { $this->download_date=$s; return $this; }
	public function getDownloadDate () { return $this->download_date; }

	private function getBean () {
		$this->bean = R::dispense('showlog');
		$this->bean->show_name = $this->show_name;
		$this->bean->season = $this->season;
		$this->bean->episode = $this->episode;
		$this->bean->air_date = $this->air_date;
		$this->bean->download_date = $this->download_date;
		return $this->bean;
	}	

	public function create () {
		if ( $this->id ) {
			return $this->update();
		}

		$bean = $this->getBean();
		R::store( $bean );
		$this->id = $bean->id;
		return $this->id;
	}

	public function update () {
		$bean = $this->getBean();
		$bean->id = $this->id;
		R::store( $bean );
	}
	
	public static function retrieve ($search_options=array(), $start_where='') {
		$where_data = array();
		if ( strlen(trim($start_where)) > 0 ) {
			$where = $start_where;
		}
		else {
			$where = " 1 ";
		}
		if ( $search_options['show_name'] ) {
			$where .= " AND show_name=? ";
			$where_data[] = $search_options['show_name'];
		}
		if ( $search_options['episode'] ) {
			$where .= " AND episode=? ";
			$where_data[] = $search_options['episode'];
		}
		if ( $search_options['season'] ) {
			$where .= " AND season=? ";
			$where_data[] = $search_options['season'];
		}
		/* @TODO - do this natively in redbean? */
		if ( $search_options['limit'] ) {
			$where .= " LIMIT " . $search_options['limit'];
		}
		/* @TODO - do this natively in redbean? */		
		if ( $search_options['offset'] ) {
			$where .= " OFFSET " . $search_options['offset'];
		}
		$showlogs = array();
		foreach ( R::find('showlog', $where, $where_data ) as $r ) {
			$showlogs[] = new ShowLog( array('id'=>$r->id) );
		}
		return $showlogs;
	}
	
	public static function retrieveDownloaded ($search_options=array()) {
		return ShowLog::retrieve($search_options, " download_date IS NOT NULL");		
	}
	
	public static function toArray ( ShowLog $s ) {
		return array( 		
			'id' => $s->getId(),
      		'show_name' => $s->getShowName(),
			'season' => $s->getSeason(),
			'episode' => $s->getEpisode(),
			'air_date' => $s->getAirDate(),
			'download_date' => $s->getDownloadDate()
		);
	}
}

