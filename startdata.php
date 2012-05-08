<?

require_once('bootstrap.php');

$s = new ShowLog();
$s->setShowName('Girls');
$s->create();

$s = new ShowLog();
$s->setShowName('Game of Thrones');
$s->create();


$s = new ShowQueue();
$s->setShowName('Girls');
$s->create();

$s = new ShowQueue();
$s->setShowName('Game of Thrones');
$s->create();
