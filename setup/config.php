<?

Config::set('BASEDIR', '/home/daveg/public_html/tvdl/');
Config::set('rss_feeds', array(
	'EZRss_Feed',
	'Karmorra_Feed'
));


Config::set('DB_DSN',  "sqlite:" . $GLOBALS['BASEDIR'] . "db/tvshows.sdb");
Config::set('DB_USER', "");
Config::set('DB_PASSWORD', "");

// if per-show torrent directories are not setup, use fallback_torrent_dir
Config::set('fallback_torrent_dir', Config::get('BASEDIR') . "torrents/");
@mkdir( Config::get('fallback_torrent_dir'), 0755, true);
