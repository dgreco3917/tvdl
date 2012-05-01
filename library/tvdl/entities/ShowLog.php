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
		$this->setShowName($data['show_name']);
		$this->setSeason($data['season']);
		$this->setEpisode($data['episode']);
		$this->setAirDate($data['air_date']);
		$this->setDownloadDate($data['download_date']);
		$this->setId($data['id']);
		$this->bean = R::dispense('showlog');
	}
	
	public function setId ( $s ) { $this->id=$s; return $this; }
	public function setShowName ( $s ) { $this->show_name=$s; return $this; }
	public function setSeason ( $s ) { $this->season=$s; return $this; }
	public function setEpisode ( $s ) { $this->episode=$s; return $this; }
	public function setAirDate ( $s ) { $this->air_date=$s; return $this; }
	public function setDownloadDate ( $s ) { $this->download_date=$s; return $this; }

	public function getBean () {
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
	
	public static function retrieve ($search_options=array()) {
		$where_data = array();
		$where = " 1 ";
		if ( $search_options['show_name'] ) {
			$where .= " AND show_name=? ";
			$where_data[] = $search_options['show_name'];
		}
		return R::find('showlog', $where, $where_data );
	}

}

