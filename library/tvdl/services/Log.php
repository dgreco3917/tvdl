<?

class Log {
	public function __construct ( ) {
	}
	
	public function getList ( $filters=array() ) {
		$log = array();
		foreach ( ShowLog::retrieve($filters) as $show_log ) {
			$log[] = ShowLog::toArray( $show_log );
		}
		
		return $log;
	}
	
}