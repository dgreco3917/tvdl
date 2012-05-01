<?

require_once('bootstrap.php');

$s = new ShowLog();
$s->setShowName('Girls');
$s->setId(2);
$s->create();

$s = new ShowLog();
$s->setShowName('Game of Thrones');
$s->create();

$s = ShowLog::retrieve( array('show_name' => 'Game of Thrones') );
print_r($s);
