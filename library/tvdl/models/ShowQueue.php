<?

class ShowQueue {

	private $bean;

	private $id;	
	private $show_name;
	private $season;
	private $episode;
	private $air_date;
	private $download_date;
	
	public function __construct ( $data=array() ) {
		$this->setShowName($data['show_name']);
		$this->setId($data['id']);
		if ( $this->id ) {
			$this->load();
		}
		else {
			$this->bean = R::dispense('showqueue');
		}
	}
	
	private function load ( ) {
		$this->bean = R::load('showqueue', $this->id);
		if ( ! $this->bean->id ) {
			throw new Exception("Could not find ShowQueue with ID: {$this->id}");
		}
		$this->setId( $this->bean->id );
		$this->setShowName( $this->bean->show_name );
	}
	
	public function setId ( $s ) { $this->id=$s; return $this; }
	public function getId () { return $this->id; }
	public function setShowName ( $s ) { $this->show_name=$s; return $this; }
	public function getShowName () { return $this->show_name; }

	public function getBean () {
		$this->bean = R::dispense('showqueue');
		$this->bean->show_name = $this->show_name;
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
		
		$showqueues = array();
		foreach ( R::find('showqueue', $where, $where_data ) as $r ) {
			$showqueues[] = new ShowQueue( array('id'=>$r->id) );
		}

		return $showqueues;
	}
	
}
