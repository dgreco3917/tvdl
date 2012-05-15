<?

require_once('bootstrap.php');

touch("db/tvshows.sdb");
$dbh = new PDO("sqlite:db/tvshows.sdb");
$dbh->exec("
CREATE TABLE IF NOT EXISTS
showlog (
	show_name varchar(120),
	season smallint,
	episode smallint,
	air_date datetime,
	download_date datetime
)
");
$dbh->exec("delete from showlog");

$dbh->exec("
CREATE TABLE IF NOT EXISTS showqueue (
	id integer,
	name varchar(255),
	active smallint default 1
	/*
	torrent_path varchar(255),
	start_with_season integer,
	start_with_episode integer,
	download_quality,
	additional_search_params
	*/
)");

$dbh->exec("delete from showqueue");

$dbh->exec("INSERT INTO showqueue (id, name) VALUES (1, 'Girls')");
$dbh->exec("INSERT INTO showqueue (id, name) VALUES (2, 'Game of Thrones')");
$dbh->exec("INSERT INTO showqueue (id, name) VALUES (3, 'The Killing')");
$dbh->exec("INSERT INTO showqueue (id, name) VALUES (4, 'Breaking Bad')");
