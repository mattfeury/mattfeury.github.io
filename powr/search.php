<? require_once "templates/head.php" ?>
<style>
#results img { width: 100%; }
#results li { margin-bottom: 10px; }
#stop-video
{
  display: block;
  position: absolute;
  bottom: 10px;
  right: 10px;
  width: 15%;
}

section.pane
{
  float: left;
  display: block;
  width: 23%;
  padding: 1%;
}
section.pane.video { width: 50%; padding: 0; }
section.pane button, section.pane input
{
  width: 95%;
  height: 50px;
  font-size: 1.4em;
  padding-left: 4%;
  margin-bottom: 10px;
}
section.pane button
{
  width: 100%;
  padding: 0;
  border: 1px solid black;
}

#results-holder 
{ 
  display: block !important;
  position: absolute;
  top: 200px;
  bottom: 10px;
  margin-top: 5px;
  width: 24%;
}
#results-holder > div { display: inline; }
#results-holder ul 
{
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 10px;
  overflow: auto;
  overflow-x: hidden;
  padding-right: 5px;
}

.pane ::-webkit-scrollbar-track-piece
{
/*background-color: #111;*/
}
.pane ::-webkit-scrollbar-thumb {
background-color: ##C2C2C2;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-o-border-radius: 5px;
-ms-border-radius: 5px;
-khtml-border-radius: 5px;
border-radius: 5px;
-moz-box-shadow: #C2C2C2 0 0 5px 1px inset;
-webkit-box-shadow: #C2C2C2 0 0 5px 1px inset;
-o-box-shadow: #C2C2C2 0 0 5px 1px inset;
box-shadow: #C2C2C2 0 0 5px 1px inset;
}
.pane ::-webkit-scrollbar {
width: 9px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-o-border-radius: 5px;
-ms-border-radius: 5px;
-khtml-border-radius: 5px;
border-radius: 5px;
}

</style>
<script type="text/javascript">
var ERROR;
function clearResults()
{
  $('ul#results li').remove();
}
function addResult(result)
{
  var $ul = $('ul#results');

  var media = result.media$group.media$thumbnail;

  var $li = 
    $('<li />')
      .append(
        $('<a />')
          .attr('id',result.id.$t)
          .addClass('result')
          .append(
            $('<span />').text(result.title.$t))
          .append(
            $('<img />').attr('src', media[0].url))
          );

  $ul.append($li);

}

function resetForm(newId) 
{
  $('#youtube-id').val(newId || '');
  $('#youtube-band').val('');
  $('#youtube-song').val('');

}
function onPlayerError(errorCode) {
  //alert("An error occured: " + errorCode);
  ERROR = true;
  if(errorCode == 150 || errorCode == 101)
    alert("Video not embeddable");
  else
    alert("there was an error.");

  
}


$(function() {

  $('#results .result').live('click',function() {
    ERROR = false;
    //$('body').addClass('playing');
    var yId = $(this).attr('id').split('/');
    yId = yId[yId.length - 1];
    loadNewVideo(yId, 0);

    resetForm(yId);
    
  });

  $('#stop-video').click(stop);

  $('#video-loader').submit(function(e) {

    var yId = $(this).find('#video-id').val();
    
    $.ajax({
      url: "http://gdata.youtube.com/feeds/api/videos",
      type: "GET",
      data: "alt=json&q="+encodeURI(yId)+"&format=5",
      dataType: "jsonp",
      success: function(data) {
        clearResults();
        for(var i in data.feed.entry) {
          addResult(data.feed.entry[i]);
        }
        $('ul#results').scrollTop(0);
      },
      error: function(error) {
        alert("there was an error. take a shot. "+error);
      }

        
    });

    e.preventDefault();
    return false;
  });

  $('#submit-video').click(function() {
    var id = $('#youtube-id').val();
    var band = $('#youtube-band').val();
    var song = $('#youtube-song').val();

    if(id.trim() == "" || band.trim() == "" || song.trim() == "") {
      alert("fill in all fields");
      return false;
    }


    
    $.ajax({
      url: "<?= $AJAX_LIB ?>submitVideo.php",
      type: "POST",
      data: "id="+id+"&band="+encodeURI(band)+"&song="+encodeURI(song),
      success: function(data) {
        resetForm();
        $('.shim.drink').show();
        setTimeout(function() { $('.shim.drink').fadeOut('slow'); }, 1500);        
      },
      error: function(error) {
        alert("there was an error. take a shot anyway. "+error);
      }
        
    });

  });

});
</script>
<? include_once "templates/header.php" ?>

<body> 

<section class="pane">
<header>
  <h1>powr<span>hr</span></h1>
</header>
<form id="video-loader">
<input type="text" id="video-id" placeholder="Search query" />
<button type="submit" id="show-video">Search</button>
</form>
<div id="results-holder">
<div>
<ul id="results">
</ul>
</div>
</div>
</section>
<section class="pane video">


<div id="ytapiplayer" class="video-holder next"></div>
    <script type="text/javascript"> 
      // <![CDATA[
 
      // allowScriptAccess must be set to allow the Javascript from one 
      // domain to access the swf on the youtube domain
      var params = { allowScriptAccess: "always", bgcolor: "#cccccc", wmode: "opaque" };
      // this sets the id of the object or embed tag to 'myytplayer'.
      // You then use this id to access the swf and make calls to the player's API
      var atts = { id: "myytplayer" };
      swfobject.embedSWF("http://www.youtube.com/apiplayer?enablejsapi=1&playerapiid=ytplayer", 
                         "ytapiplayer", "100%", "100%", "8", null, null, params, atts);
      //]]>
    </script> 
</section>
<section class="pane submitter">
<h3>submit</h3>
<input type="text" id="youtube-id" placeholder="Youtube ID" />
<input type="text" id="youtube-band" placeholder="Band Name" />
<input type="text" id="youtube-song" placeholder="Song Name" />
<button id="submit-video">Submit</button>
<button id="stop-video">Stop Playback</button>

</section>

<div class="drink shim">
  <div class="dialog">
    <h1>Drraaaank</h1>
  </div>
</div>
<script type="text/javascript">
var clicky = { log: function(){ return; }, goal: function(){ return; }};
var clicky_site_id = 66387991;
(function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  s.src = ( document.location.protocol == 'https:' ? 'https://static.getclicky.com/js' : 'http://static.getclicky.com/js' );
  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
})();
</script>
<script type="text/javascript">
(function(d,n){
var e =d.createElement(n),s=d.getElementsByTagName(n)[0];e.async=true;
e.src="//speedo.no.de/client.js#{'account':'3765134608921'}";
s.parentNode.insertBefore( e, s );
})(document,"script");
</script>
</body> 
</html>
