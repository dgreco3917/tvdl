<?

require_once('bootstrap.php');

$l = new Log();
$logs = $l->getList( array('offset'=>$_REQUEST['posStart'], 'limit'=>$_REQUEST['count']) );

$xml = '<?xml version="1.0" ?>';
$xml .= "<rows total_count='" . count($logs) . "' pos='" . ($_REQUEST['posStart'] ? $_REQUEST['posStart'] : 0) . "'>";
foreach ( $logs as $log ) {
	$xml .= "<row id='" . $log['id'] . "'>\n";
	$xml .= "	<cell>" . $log['show_name'] . "</cell>\n";
	$xml .= "	<cell>" . $log['season'] . "</cell>\n";
	$xml .= "	<cell>" . $log['episode'] . "</cell>\n";	
	$xml .= "	<cell>" . $log['air_date'] . "</cell>\n";	
	$xml .= "	<cell>" . $log['download_date'] . "</cell>\n";	
	$xml .= "</row>";	
}
$xml .= "</rows>";



header("Content-type:text/xml");
print $xml;