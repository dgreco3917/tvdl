<?

require_once( __DIR__ . '/../bootstrap.php');


$q = new Queue();
$q->setFeeds( Config::get('rss_feeds') );
print_r( $q->downloadAvailable() );

