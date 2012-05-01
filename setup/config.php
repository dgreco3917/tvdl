<?

$GLOBALS['BASEDIR'] = '/home/daveg/public_html/tvdl/';

$GLOBALS['rss_feeds'] = array(
	'EZRss_Feed',
	'Karmorra_Feed'
);

$GLOBALS['DB_DSN'] = "sqlite:" . $GLOBALS['BASEDIR'] . "db/tvshows.sdb";
$GLOBALS['DB_USER'] = "";
$GLOBALS['DB_PASSWORD'] = "";

// if per-show torrent directories are not setup, use fallback_torrent_dir
$fallback_torrent_dir = "torrents/";
@mkdir($fallback_torrent_dir, 0755, true);
