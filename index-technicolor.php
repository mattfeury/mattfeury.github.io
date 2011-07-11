<? include "templates/head.php" ?>
<script>
NUM_BEAMS = 10;
VERTEX_X = 0;
VERTEX_Y = 0;
//beams = new Array(NUM_BEAMS);
sprites = new Array(NUM_BEAMS/2);
colors = ["rgba(194,181,164,0.15)","rgba(212,190,147,0.15)","rgba(225,226,218,0.7)","rgba(205,210,180,0.3)","rgba(183,157,127,0.15)"];
MAGIC_ANGLE = 20;
LENGTH = 20;
MAX_ANGLE = 20;
MAX_LENGTH = 2400;
ANIM_INTERVAL = null;
BINARY_INTERVAL = null;
BINARY_LENGTH = 2000;
BINARY_STRING = new Array(BINARY_LENGTH);//"101010";

function Beam(x,y,length,relX) {
  this.x = x;
  this.y = y;
  this.length = length;
  this.relX = relX; //in degrees

 // this.getX = function() { return this.x; };
  // this.getY = function() {
  this.recalculateCoords = function() { 
    this.x = (MAX_LENGTH * Math.cos(this.relX * Math.PI/180)) + VERTEX_X;
    this.y = -1 * (MAX_LENGTH * Math.sin(this.relX * Math.PI/180)) + VERTEX_Y;
  }; 
}

function Sprite(beams) {
  this.beams = beams;

}

function makeBeams() {
  //initial goes to zero
  //var length = Math.sqrt(Math.pow(VERTEX_X,2) + Math.pow(VERTEX_Y,2));
  var beams = new Array(NUM_BEAMS);
  var relX = 180 - (Math.atan(VERTEX_Y/VERTEX_X) * 180/Math.PI);
  x = (LENGTH * Math.cos(relX * Math.PI/180)) + VERTEX_X;
  y = -1 * (LENGTH * Math.sin(relX * Math.PI/180)) + VERTEX_Y;
  
  beams[0] = new Beam(x,y,LENGTH, relX);

  for(i = 1; i < NUM_BEAMS; i++)
    beams[i] = makeBeam(i,beams[i-1]);

  return beams;
}

function makeSprites() {
  var beams = makeBeams();
  for(i = 0; i < beams.length; i += 2) {
    var slice = beams.slice(i,i+2);
    sprites[i/2] = new Sprite(slice);
  }
}

function makeBeam(num,prev) {
  //the previous beam should be set
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

function drawSprite(ctx, sprite, color)
{
   ctx.fillStyle = color; //"rgba(157,152,50,0.25)";
   
   ctx.beginPath();
   ctx.moveTo(VERTEX_X, VERTEX_Y);
   ctx.lineTo(sprite.beams[0].x, sprite.beams[0].y);
   ctx.lineTo(sprite.beams[1].x, sprite.beams[1].y);
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

function writeBinary(ctx) {
  var binary = BINARY_STRING.join("");
  var charsPerLine = Math.floor(window.innerWidth / 8);
  //console.log(charsPerLine);
 
  for(i = 0; i < 10; i++)
  {
    var start = i*charsPerLine;
    ctx.font = "bold "+(26-(i*2))+"px courier"; 
    ctx.fillStyle = "rgba(243,230,214,"+(1.0-(i/10))+")";
    ctx.fillText(binary.substring(start,start+charsPerLine), 0, 20 + (i*20)); 
  }

}

function randomNightclub() {
  console.log("nighttime");
  var sprite = sprites[Math.floor(Math.random()*sprites.length)];

  //this is crappy.
/*  for(i = 5; i > -5; i--)
    if(i%1==0)
    {
      for(i in sprite.beams) {
     //   console.log(sprite);
        sprite.beams[i].relX += 2 * ((i>0) ? 1 : -1);
        sprite.beams[i].recalculateCoords();
      }
}*/


  
//  setTimeout(randomNightclub,Math.floor(Math.random()*4000)+2000);
}  

$(function() {
  // draw();
  var canvas = document.getElementById("beams");
  var ctx = canvas.getContext("2d");

  //initial settings
//  MAGIC_ANGLE = 1;
  resetCanvasSize(ctx);
  //makeBeams();
  makeSprites();

  ANIM_INTERVAL = setInterval(function() {
      if(MAGIC_ANGLE > MAX_ANGLE || LENGTH > MAX_LENGTH) {
        clearInterval(ANIM_INTERVAL);
        return;
      }
      //console.log(MAGIC_ANGLE);
      //MAGIC_ANGLE += .3;
      LENGTH += 20;
      clearCanvas(ctx);
      //makeBeams();    
      makeSprites();
      //drawBeams(ctx);
      for(i in sprites)
        drawSprite(ctx,sprites[i],colors[i % colors.length]);
      
  },30);

  //binary?
  for(i = 0; i < BINARY_LENGTH; i++)
    BINARY_STRING[i] = Math.floor(Math.random()*2);

  var canvas2 = document.getElementById("binary");
  var ctx2 = canvas2.getContext("2d");
  ctx2.canvas.width  = window.innerWidth;
  ctx2.canvas.height = window.innerHeight;
  writeBinary(ctx2);

  BINARY_INTERVAL = setInterval(function() {
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length / 12)] ^=  1;
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length / 8)] ^=  1;
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length / 6)] ^=  1;
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length)] ^=  1;
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length)] ^=  1;
    BINARY_STRING[Math.floor(Math.random()*BINARY_STRING.length)] ^=  1;
    clearCanvas(ctx2);
    writeBinary(ctx2);    
  }, 200);


  //nightclub mode?
//  setTimeout(randomNightclub,Math.floor(Math.random()*4000)+2000);

   
  //handle resize
  $(window).resize(function() {
    //clear
    clearCanvas(ctx);
    clearCanvas(ctx2);
    resetCanvasSize(ctx);
    resetCanvasSize(ctx2);
    
    //remake to scale with window and redraw
   // makeBeams();
    makeSprites();
    //drawBeams(ctx);
    for(i in sprites)
      drawSprite(ctx,sprites[i],colors[i % colors.length]);

    writeBinary(ctx2);
  });
   
});
</script>
<script>
ALBUMS = new Array();
function addAlbumImage(uri, img)
{
  ALBUMS.push(img);
  var $li = $('<li />').addClass('album');//.css('width','0px');
  $li.append($('<a target="_blank" href="'+uri+'"><img src="'+img+'" /></a>'));
  $('#albums').append($li);
  //$li.animate({'width': '64px'});

}

$(function() {

  $('.album').live('mouseover', function() { $('.album').not($(this)).stop().animate({ opacity: 0.3 },200); });
  $('.album').live('mouseleave', function() { $('.album').not($(this)).stop().animate({ opacity: 1.0 },200); });



$.getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=mattfeury&limit=30&api_key=625d2096602985b4fed48ac23d89932d&format=json&callback=?',function(data, status, xhr) {
  $.each(data.recenttracks.track, function(i, item) {
    //console.log(item);
    //$.getJSON('http://ws.audioscrobbler.com/2.0/?method=album.getInfo&mbid='+item.mbid+'&api_key=625d2096602985b4fed48ac23d89932d&format=json&callback=?',function(data2, status, xhr) {
      if($.inArray(item.image[1]['#text'],ALBUMS)==-1 && item.image[1]['#text']!="")
        addAlbumImage(item.url,item.image[1]['#text']);

    //});
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
li.album img { width: 64px; border: 0px; }

canvas
{
  z-index: -2;
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
}
#binary { z-index: -1; }
body { background-color: #f3e6d6 !important }
</style>
<? include "templates/header.php" ?>
<canvas id="binary"></canvas>  
<canvas id="beams"></canvas>  
<img src="images/corner-trans2.png" id="bgFill" />	
<nav>
<h3>mattfeury.com</h3>
I am under construction. Why are you here?
<p></p>
<h4>Projects:</h4>
<ul id="projects">
  <li><a href="/audiolizer/index.php" rel="external">Audiolizer</a><div class="details">(co-creator)</div></li>
  <li><a target="_blank" href="http://www.music.gatech.edu/" rel="external">Georgia Tech School of Music</a><div class="details">(lead designer, lead developer)</div></li>
  <li><a target="_blank" rel="external" href="http://www.openstudy.com/">OpenStudy</a><div class="details">(junior developer)</div></li>
  
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
<div style="text-align: center; padding: 10px;">
<img src="12-oz.gif" />
<h3>Sup?</h3>
</div>				
		</section>
		<section class="pane third">
      <h2><a href="http://www.last.fm/user/mattfeury" target="_blank">last.fm</a>:</h2>
      <div class="base">
      <ul id="albums"></ul>

      </div>
		</section>
	
<? include "templates/footer.php" ?>
