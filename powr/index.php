<? require_once "templates/head.php" ?>
<script type="text/javascript">
var PLAYLIST = <?= $playlistJson ?>
</script>
<script type="text/javascript" src="javascripts/powr.js"></script>
<style>
.thirsty #now-playing { display: none; }
.drinking #now-playing { display: block; }

#now-playing h3 {
  font-size: 20px;
  padding: 10px;
}
#now-playing div
{
  padding: 10px;
}
#now-playing div.band { font-weight: bold; padding-bottom: 0px;}
header h1 { display: inline; }
header span.beta { color: white; font-size: 12px; }
.clear { clear: both; }
#feedback {
  display: block;
  position: absolute;
  bottom: 10px;
  left: 10px;
}
#feedback a, #feedback span {
  font-weight: normal;
  font-family: Helvetica, Arial;
  color: #C2C2C2;
  font-size: 12px;
}
#feedback a { color: #f1f1f1; }
</style>
<? include_once "templates/header.php" ?>

<body class="thirsty"> 

<section id="feedback">
<div><a class="give-it" target="_blank" href="http://powrhr.uservoice.com">Give feedback / Submit a bug</a></div>
<!--<div><span>or <a href="mailto:%70%6F%77%72%40%6D%61%74%74%66%65%75%72%79%2E%63%6F%6D">send me electronic mail.</a></span></div>-->
</section>
<section id="controller">
<header>
  <h1>powr<span>hr</span></h1><span class="beta">beta</span>
</header>

<div id="ticker">
<div><span class="minutes">1</span>/60 drinks</div>
<div><span class="time">60</span> seconds</div>
</div>

<div id="clock">	
  <img id="face" src="images/clockface.png" />
  <div class="hand" id="drinks"><div class="head"></div></div> 
  <div class="hand" id="seconds"><div class="head"></div></div> 

</div> 

<section id="controls">
<button id="skip">Skip Video</button>

<div class="switcher">
  <button class="switch" id="stop">Stop the Powr</button>
  <button class="switch current" id="start">Start the Powr</button>
</div>
<section id="now-playing">
<h3>Now POWRing:</h3>
<div class="band"></div>
<div class="song">Start the powr</div>
</section>

</section>


</section>

<section id="video"> 
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
