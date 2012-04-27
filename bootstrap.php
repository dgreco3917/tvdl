<?

include('setup/config.php');

$dbh = new PDO("sqlite:$db_path/tvshows.sdb");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require('library/tvdl/Link.php');
require('library/tvdl/Feed_Item.php');
require('library/tvdl/feeds/ezrss.php');
require('library/tvdl/feeds/karmorra.php');
require_once('Zend/Feed/Rss.php');
require_once('library/misc/simple_html_dom.php');




