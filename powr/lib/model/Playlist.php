<?
class Playlist
{
  var $songs = array();

  function __construct($size = false) {
    $query = "SELECT * FROM songs WHERE works = 1 ORDER BY rand()";
    $songsTotal = Songs::findAll($query, $size);

    shuffle($songsTotal);
    foreach($songsTotal as $song)
    {
      if(! array_key_exists($song->band, $this->songs))
        $this->songs[$song->band] = $song;
    }

    $this->randomize();

  }

  function randomize() {
    shuffle($this->songs);
  }

  function toJson() {
    return json_encode($this->songs);
  }


}


?>
