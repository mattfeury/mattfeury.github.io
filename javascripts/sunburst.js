/*
 * Sunburst drawer. This uses a canvas HTML5 element.
 */
NUM_BEAMS = 10;
VERTEX_X = 0;
VERTEX_Y = 0;
sprites = new Array(NUM_BEAMS/2);
MAGIC_ANGLE = 20;
LENGTH = 20;
MAX_ANGLE = 20;
MAX_LENGTH = 2400;
ANIM_INTERVAL = null;
BINARY_INTERVAL = null;
BINARY_LENGTH = 2000;
BINARY_STRING = new Array(BINARY_LENGTH);
SUNBURST_COLOUR = "rgba(200,200,200,0.25)";

/*
 * These are all function used to manipulate "beams" and "sprites."
 * A sprite is a single sunburst that is made up of 2 beams.
 */
function Beam(x,y,length,relX) {
  this.x = x;
  this.y = y;
  this.length = length;
  this.relX = relX; //angle relative to x axis, in degrees

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
  var beams = new Array(NUM_BEAMS),
      relX = 180 - (Math.atan(VERTEX_Y/VERTEX_X) * 180/Math.PI),
      x = (LENGTH * Math.cos(relX * Math.PI/180)) + VERTEX_X,
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
 
  var relX = prev.relX - MAGIC_ANGLE,
      x = (prev.length * Math.cos(relX * Math.PI/180)) + VERTEX_X,
      y = -1 * (prev.length * Math.sin(relX * Math.PI/180)) + VERTEX_Y,
      length = prev.length;

  return new Beam(x,y,length,relX);
}

function drawBeam(ctx, num)
{
   ctx.fillStyle = SUNBURST_COLOUR;   
   ctx.beginPath();
   ctx.moveTo(VERTEX_X, VERTEX_Y);
   ctx.lineTo(beams[num-1].x, beams[num-1].y);
   ctx.lineTo(beams[num].x, beams[num].y);
   ctx.lineTo(VERTEX_X, VERTEX_Y);
   ctx.closePath();
   ctx.fill();
}

function drawSprite(ctx, sprite)
{
   ctx.fillStyle = SUNBURST_COLOUR;
   
   ctx.beginPath();
   ctx.moveTo(VERTEX_X, VERTEX_Y);
   ctx.lineTo(sprite.beams[0].x, sprite.beams[0].y);
   ctx.lineTo(sprite.beams[1].x, sprite.beams[1].y);
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
 
  for(i = 0; i < 10; i++)
  {
    var start = i*charsPerLine;
    ctx.font = "bold "+(26-(i*2))+"px courier"; 
    ctx.fillStyle = "rgba(229,229,229,"+(1.0-(i/10))+")";
    ctx.fillText(binary.substring(start,start+charsPerLine), 0, 20 + (i*20)); 
  }

}

/*
 * DOM READY. set everything up and animate all that goodness.
 */
$(function() {
  // draw();
  var canvas = document.getElementById("beams");
 // try { G_vmlCanvasManager.initElement(canvas); } catch(err) {}
  var ctx = canvas.getContext("2d");
  
  //initial settings
  resetCanvasSize(ctx);
  makeSprites();

  //have beams grow initially
  ANIM_INTERVAL = setInterval(function() {
      if(MAGIC_ANGLE > MAX_ANGLE || LENGTH > MAX_LENGTH) {
        clearInterval(ANIM_INTERVAL);
        return;
      }

      LENGTH += 20;
      clearCanvas(ctx);
      makeSprites();

      for(i in sprites)
        drawSprite(ctx,sprites[i]);
      
  },30);

  //binary backdrop. it changes randomly
  for(i = 0; i < BINARY_LENGTH; i++)
    BINARY_STRING[i] = Math.floor(Math.random()*2);

  var canvas2 = document.getElementById("binary");
 // try { G_vmlCanvasManager.initElement(canvas2); } catch(err) {}
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
   
  //handle resize
  $(window).resize(function() {
    //clear previous
    clearCanvas(ctx);
    clearCanvas(ctx2);
    resetCanvasSize(ctx);
    resetCanvasSize(ctx2);
    
    //remake to scale with window and redraw
    makeSprites();
    for(i in sprites)
      drawSprite(ctx,sprites[i]);

    writeBinary(ctx2);
  });
   
});
