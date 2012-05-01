<?

include('setup/config.php');

require('library/tvdl/Link.php');
require('library/tvdl/Feed_Item.php');
require('library/tvdl/feeds/ezrss.php');
require('library/tvdl/feeds/karmorra.php');
require('library/tvdl/entities/ShowLog.php');

require_once('Zend/Feed/Rss.php');
require_once('library/misc/simple_html_dom.php');



require('library/redbean/rb.php');
R::setup( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'] );

