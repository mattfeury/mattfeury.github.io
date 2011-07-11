<? include "templates/head.php" ?>
<script>
NUM_BEAMS = 8;
VERTEX_X = 0;
VERTEX_Y = 0;
beams = new Array(NUM_BEAMS);
MAGIC_ANGLE = 20;
LENGTH = 20;
MAX_ANGLE = 20;
MAX_LENGTH = 2400;
ANIM_INTERVAL = null;


function Beam(x,y,length,relX) {
  this.x = x;
  this.y = y;
  this.length = length;
  this.relX = relX; //in degrees

 // this.getX = function() { return this.x; };
 // this.getY = function() { 
}

function makeBeams() {
  //initial goes to zero
  //var length = Math.sqrt(Math.pow(VERTEX_X,2) + Math.pow(VERTEX_Y,2));
  var relX = 180 - (Math.atan(VERTEX_Y/VERTEX_X) * 180/Math.PI);
  x = (LENGTH * Math.cos(relX * Math.PI/180)) + VERTEX_X;
  y = -1 * (LENGTH * Math.sin(relX * Math.PI/180)) + VERTEX_Y;
  
  beams[0] = new Beam(x,y,LENGTH, relX);

  for(i = 1; i < NUM_BEAMS; i++)
    beams[i] = makeBeam(i);
}

function makeBeam(num) {
  //the previous beam should be set
  var prev = beams[num-1];

  var x,y,length,relX;
 // x = prev.x + prev.length * Math.sin(MAGIC_ANGLE * Math.PI/180);
 // y = prev.y + (prev.y - prev.y * Math.cos(MAGIC_ANGLE * Math.PI/180));

  relX = prev.relX - MAGIC_ANGLE;  
  x = (prev.length * Math.cos(relX * Math.PI/180)) + VERTEX_X;
  y = -1 * (prev.length * Math.sin(relX * Math.PI/180)) + VERTEX_Y;
  length = prev.length;


  return new Beam(x,y,length,relX);
  
}

function drawBeam(ctx, num)
{
   ctx.fillStyle = "rgba(200,200,200,0.25)";
   
   ctx.beginPath();
   ctx.moveTo(VERTEX_X, VERTEX_Y);
   ctx.lineTo(beams[num-1].x, beams[num-1].y);
   ctx.lineTo(beams[num].x, beams[num].y);
   //ctx.arcTo(beams[num-1].x,beams[num-1].y,beams[num].x,beams[num].y,1);
   ctx.lineTo(VERTEX_X, VERTEX_Y);
   ctx.closePath();
   ctx.fill();

}

function drawBeams(ctx)
{
  for(i = 0; i < NUM_BEAMS; i++)
    if(i & 1) //send the right edge, color left
      drawBeam(ctx, i);
}

function resetCanvasSize(ctx)
{
  ctx.canvas.width  = window.innerWidth;
  ctx.canvas.height = window.innerHeight;
  VERTEX_X = 260;//window.innerWidth;
  VERTEX_Y = window.innerHeight - 300;
}

function clearCanvas(ctx) {
	ctx.clearRect(0,0,ctx.canvas.width,ctx.canvas.height);
	ctx.beginPath();
}


$(function() {
  // draw();
  var canvas = document.getElementById("canvas");
  var ctx = canvas.getContext("2d");

  //initial settings
//  MAGIC_ANGLE = 1;
  resetCanvasSize(ctx);
  makeBeams();

  ANIM_INTERVAL = setInterval(function() {
      if(MAGIC_ANGLE > MAX_ANGLE || LENGTH > MAX_LENGTH) {
        clearInterval(ANIM_INTERVAL);
        return;
      }
      console.log(MAGIC_ANGLE);
      //MAGIC_ANGLE += .3;
      LENGTH += 20;
      clearCanvas(ctx);
      makeBeams();    
      drawBeams(ctx);
  },30);

  //handle resize
  $(window).resize(function() {
    clearCanvas(ctx);
    resetCanvasSize(ctx);
    makeBeams();
    drawBeams(ctx);
  });
   
   
});
</script>
<script>
function addAlbumImage(uri, img)
{
  var $li = $('<li />').addClass('album');//.css('width','0px');
  $li.append($('<a target="_blank" href="'+uri+'"><img src="'+img+'" /></a>'));
  $('#albums').append($li);
  //$li.animate({'width': '64px'});

}

$(function() {

  $('.album').live('mouseover', function() { $('.album').not($(this)).stop().animate({ opacity: 0.3 },200); });
  $('.album').live('mouseleave', function() { $('.album').not($(this)).stop().animate({ opacity: 1.0 },200); });



$.getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getweeklyalbumchart&user=mattfeury&api_key=625d2096602985b4fed48ac23d89932d&format=json&callback=?',function(data, status, xhr) {
  $.each(data.weeklyalbumchart.album, function(i, item) {
    //console.log(item);
    $.getJSON('http://ws.audioscrobbler.com/2.0/?method=album.getInfo&mbid='+item.mbid+'&api_key=625d2096602985b4fed48ac23d89932d&format=json&callback=?',function(data2, status, xhr) {
      if(data2.album)
        addAlbumImage(data2.album.url,data2.album.image[1]['#text']);

    });
  }); 

});


});
</script>
<style>
a { text-decoration: none; font-weight: bold; }
a:hover { text-decoration: underline; }
a:visited { color: black; }

ul#albums { list-style: none; display: block; padding:0px}
li.album { float: left; margin: 0; padding: 0;}
li.album img { width: 100%; }

#canvas
{
  z-index: -1;
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
}
</style>
<? include "templates/header.php" ?>
<canvas id="canvas"></canvas>  
<img src="images/corner-trans2.png" id="bgFill" />	
<nav>
I am under construction. Why are you here?
<h4>Projects:</h4>
<ul id="projects">
  <li><a href="/audiolizer/index.php">Audiolizer</a><div class="details">(co-creator)</div></li>
  <li><a target="_blank" href="http://www.music.gatech.edu/">Georgia Tech School of Music</a><div class="details">(lead designer, lead developer)</div></li>
  <li><a target="_blank" href="http://www.openstudy.com/">OpenStudy</a><div class="details">(junior developer)</div></li>
  
</ul>
</nav>

    <section class="pane third" style="visibility: hidden;">
			<h2>Links</h2>
			<div class="base">
			  <p>
			     <strong>WOAHNOW</strong>, 
			  </p>
        
      </div>
		</section>
		<section class="pane third">
			<h2>two</h2>
						
		</section>
		<section class="pane third">
      <h2><a href="http://www.last.fm/user/mattfeury" target="_blank">last.fm</a>:</h2>
      <div class="base">
      <ul id="albums"></ul>

      </div>
		</section>
	
<? include "templates/footer.php" ?>
