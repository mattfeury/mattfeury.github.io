<?

class Songs
{
  public static function findAll($query, $limit = false) {

    $songs = array();
    $query = ($limit) ? $query." LIMIT ".$limit : $query;
    $result = mysql_query($query);

    while($row = mysql_fetch_object($result, "Song", array(true)))
      $songs[] = $row;

    mysql_free_result($result);

    return $songs;
  }

  public static function find($query) {

    $result = mysql_query($query);
    $song = mysql_fetch_object($result, "Song", array(true));
    mysql_free_result($result);

    return $song;
  }
  


}

class Song
{
  var $key;
  var $band;
  var $song;
  var $youtubeId;
  var $works;

  function __construct($fromDb, $youtubeId = null, $band = null, $song = null) {
    if(! $fromDb) {
      $this->band = $band;
      $this->youtubeId = $youtubeId;
      $this->song = $song;
       
      //defaults
      $this->works = 1;
    }
  }

  function insert() {
    $query = sprintf("INSERT into songs (band, song, youtubeId) VALUES ('%s','%s','%s')",
      mysql_real_escape_string($this->band),
      mysql_real_escape_string($this->song),
      mysql_real_escape_string($this->youtubeId));
      
    $result = mysql_query($query);

    if(!$result)
      return false;
    
    if(mysql_num_rows($result)==0) {
//      $this->fromDb = true;
      return true;
    } else
      return false;

  }

  function getId() {
    return $this->youbtubeId;
  }
}


?>
