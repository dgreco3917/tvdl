<?

$rss_feeds = array(
	'EZRss_Feed',
	'Karmorra_Feed'
);

$db_path = "db/";

// if per-show torrent directories are not setup, use fallback_torrent_dir
$fallback_torrent_dir = "torrents/";
@mkdir($fallback_torrent_dir, 0755, true);
