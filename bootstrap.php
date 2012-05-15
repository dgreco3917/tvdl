<?

require('library/tvdl/Config.php');
include('setup/config.php');

require('library/tvdl/Link.php');
require('library/tvdl/Feed_Item.php');
require('library/tvdl/feeds/ezrss.php');
require('library/tvdl/feeds/karmorra.php');
require('library/tvdl/models/ShowLog.php');
require('library/tvdl/models/ShowQueue.php');
require('library/tvdl/services/Queue.php');
require('library/tvdl/services/Log.php');


require_once('Zend/Feed/Rss.php');
require_once('library/misc/simple_html_dom.php');



require('library/redbean/rb.php');
R::setup( Config::get('DB_DSN'), Config::get('DB_USER'), Config::get('DB_PASSWORD') );

