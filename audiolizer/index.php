<?
	//global
	$relative_path = "http://www.mattfeury.com/audiolizer";


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Audiolizer 1.0</title>
        <link rel="stylesheet" href="styles.css" TYPE="text/css" />
        <link href=' http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
        <script type="text/javascript">
        	var color;
        	
        	$('document').ready(function(){
       			$('#url_submit').click(function(){
       				document.audiolizerapp.stop();
       				window.location = "<?= $_SERVER[’SCRIPT_NAME’] ?>?url="+$('#url').val();
        		});
       			
       			$('#stopapp').click(function(){
        			document.audiolizerapp.stop();
        		});
        		
        		$(window).unload(function() {
        			document.audiolizerapp.stop();
        		});
        		
        		/*$('applet[name=audiolizerapp]').ready(function() {
        			setTimeout("color = setInterval(updateColor,1000);",4000);
        		});*/
        	});
        	
        	function updateColor()
        	{
        		var c = document.audiolizerapp.getAvgColor();
        		if(c==null)
        			return;
       			
       			clearInterval(color);
       			$('#header').css('background-color',c);
      			//alert(c);
        	}
        	
        	
        </script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20461357-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </head>
    <body>
    <a href="https://github.com/mattfeury/Audiolizer"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png" alt="Fork me on GitHub"></a>

    <div id="container">
    	<div id="header">
        	
        	<img src="logo_small.png" class="logo" />
        	<div id="examples">
        		<h2>or choose an example >>></h2>
        		<a href="?url=<?= $relative_path ?>/whale.jpg"><img src="<?= $relative_path ?>/whale.jpg" /></a>
        		<a href="?url=http://farm2.static.flickr.com/1289/4696900767_fe94e03b42_z.jpg"><img src="http://farm2.static.flickr.com/1289/4696900767_fe94e03b42_t.jpg" /></a>
        		<a href="?url=<?= $relative_path ?>/dexter.jpg"><img src="<?= $relative_path ?>/dexter.jpg" /></a>
        		<a href="?url=<?= $relative_path ?>/duane.jpg"><img src="<?= $relative_path ?>/duane.jpg" /></a>
        	</div>
        	<div id="search">
        		<h2>enter a url >>></h2>
        		<input id="url" type="text" placeholder="enter url to image here" />
        		<button id="url_submit">audiolize</button>
        	</div>
        </div>
        
        <div class="clear"></div>
        <div id="about">
        	<button id="stopapp">stop playback</button>
        	<div class="text">
        		<p>Audiolizer is a concept brought to life by Henry Dooley & Matt Feury. The idea is to input an image and then generate a musical improvisation
        		that matches qualities of the image. No melody will ever be repeated. It was created as a project for Georgia Tech's CS 4475: Computational Photography. Special thanks to Irfan Essa for the wisdom, <a href="http://www.mikehirth.com">Mike Hirth</a> for the web space, and owners of the above sample images for not suing us. We know the law on fair use.</p>
        		<p>
        			Audiolizer is currently a work in progress. Click on a portion of the image to regenerate the improviser based on that portion. Use the controls on 
        			the left to change the volume, tempo, or riff length. Changing riff length or using the corresponding buttons will generate a new riff.
        		</p>
        	</div>
        	<div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div style="width:1000;height:600;background-color:gray;display:block;">
        <applet code="Audiolizer.class" 
            width=1000 
            height=600
            name=audiolizerapp
            ARCHIVE="jsyn_pure.jar"
            codebase="."
            alt="Your browser understands the &lt;APPLET&gt; tag but isn't running the applet, for some reason."
         >
        <PARAM name="url" value="<?= $relative_path."/proxy.php?url=".$_GET["url"] ?>">
        <PARAM name="java_arguments" value="-d32">
            Your browser is ignoring the &lt;APPLET&gt; tag!      
        </applet>
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
