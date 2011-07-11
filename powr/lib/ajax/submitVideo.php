<?
  require_once '../god.php';
foreach (glob("../model/*.php") as $filename)
{
    require_once $filename;
}
  
  if($_SERVER['REQUEST_METHOD'] != 'POST')
    goRoot();

  header('Content-type: application/json');

  $yId = urldecode($_POST['id']);
  $band = urldecode($_POST['band']);
  $song = urldecode($_POST['song']);

  $song = new Song(false, $yId, $band, $song);
  $success = $song->insert();

  if($success)
    die('{"success": 1}');
  else
    die('{"success": 0}');
    
  mysql_free_result($result);




?>
