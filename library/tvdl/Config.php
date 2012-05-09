<?

require('Zend/Registry.php');

/* abstract use of Zend_Registry */
class Config {
	public static function get ( $key ) {
		return Zend_Registry::get($key);
	}
	
	public static function set ( $key, $value ) {
		return Zend_Registry::set($key, $value);
	}
	
	
}