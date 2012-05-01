<?

class DB { 
    
    private static $pdoInstance; 
    
    private function __construct() {} 
    private function __clone() {} 
    
    /* 
     * Returns DB instance or create initial connection 
     */ 
    public static function getInstance () { 
		if(!self::$pdoInstance) { 
			self::$pdoInstance = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']); 
			self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		} 
        
		return self::$pdoInstance; 
    
    }
    
    /* 
     * Pass any static calls to this class onto the singleton PDO instance 
     */ 
    final public static function __callStatic( $method, $arguments ) {
        $pdoInstance = self::getInstance(); 
        return call_user_func_array(array($pdoInstance, $method), $arguments );
    }
    
} 