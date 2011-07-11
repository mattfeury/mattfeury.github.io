//var VIDEOS = ["jqYMRcnLU0o","jkBAUqp6NKg","2R6S5CJWlco","a6VatNuR_Uk","FGBhQbmPwH8","yfySK7CLEEg","Ns-h8_CSRfI","7h1Ob3fvGII","t0LIBCw8syA","HcwX2TnsTPE","7EbrMAZbFpo","BoMdkyeZOqE","ob-EoFKAl6w","EnhL2aLXPf8","o-7DDHmWWqk","PvamJU_coUw","MGQjyGT1-mc","HwgNMrs-i80","afeAUndotas","vgIT9Mrvddw","MQvZ4N1RfS8","1uYWYWPc9HU","OLyq0xlAa-Y","gEILFf2XSrM","TPhnOKmhbBw","zHAUiCyabIQ","jiSBAykx9vA","uZL91Uv5e8g","cMFWFhTFohk","cMFWFhTFohk","tjecYugTbIQ","A_XiXv9Y210","OQZmrdwK7YM","OQZmrdwK7YM","ZvSgLHWR16o","HeaHW-rUsUQ","7CEqVTWo4EI","rVxTsXRjNTw","KhrteSZXFzM","q1hZVDLkJDc","oP_ChuxYg8o","rw6oWkCojpw","HVt-DZdkOzw","kwagsh--L4s","51V1VMkuyx0","zN9x6zckn18","YMPF6lpM0XM","cIWMWCcpO_Y","UpgkG4TIyvE","YhLRxui7vXU","RMo9989MsDo","Ry6dBOsiwAQ","kbAISMzd7vA","Zw5ztuhEat4","sT3_jTmL2i0","Pf-ONpLXzGs","9_4_By9NJOc","qutcmPmYUpg","_40L98nzvmM", "zo5iPll7TII","BssBdDRJx_w","7ge5BoOOhCo","6zJcdCEpfDw","iQ4TeC4cVcg"];
var CURSOR = 0;
var TICKER; //javascript interval
var SHOT_INTERVAL = 60;
var COUNTER = SHOT_INTERVAL;
var DRINKS = 1;

/*
   POWR HR FUNCTIONS. 
   we'll offload these to their own file soon enough.
*/
$(function() {
  //DOM ready
  $('button#stop').click(stopPowr);
  $('button#start').click(startPowr);
  $('button#skip').click(playNextVideo);

  //switcher thingy
  $('.switcher .switch').click(function() {
    var $this = $(this);
    if(! $this.hasClass('current'))
      return;

    $(this).siblings('.switch').addClass('current');
    $(this).removeClass('current');
  });

  

});

var SKIPS = [];
function onPlayerError(errorCode) {
  //alert("An error occured: " + errorCode);
  if(errorCode == 150 || errorCode == 101) {
    //SKIPS.push(VIDEOS[CURSOR-1]);
    console.log("skipt:" + PLAYLIST[CURSOR-1]);
    playNextVideo();

  }
}

function incrementCursor() {
  CURSOR = (CURSOR+1) % PLAYLIST.length;  
}
function playNextVideo() {
  var song = PLAYLIST[CURSOR];
  incrementCursor();
  
  console.log(song.youtubeId);
  loadNewVideo(song.youtubeId,45 + (((Math.floor(Math.random()*2) == 1) ? -1 : 1) *-1 * Math.floor(Math.random()*11)));
  setVolume(100);

  var $np = $('#now-playing');
  $np
    .find('.band')
      .text(song.band)
    .end()
    .find('.song')
      .text(song.song)
    .end();

  
  
}
function drinkAlert() {
  $('.shim.drink').show();
  setTimeout(function() { $('.shim.drink').fadeOut('slow'); }, 1500);
}
function tick() {
  COUNTER = (COUNTER - 1 <= 0) ? SHOT_INTERVAL : COUNTER - 1;
  $('#ticker span.time').text(COUNTER);

  //tick tock
  var sdegree = (SHOT_INTERVAL - COUNTER) * 6;
  var srotate = "rotate(" + sdegree + "deg)";  
  $("#seconds").css({"-moz-transform" : srotate, "-webkit-transform" : srotate});
  
  var mdegree = DRINKS * 6;
  var mrotate = "rotate(" + mdegree + "deg)";
  $("#drinks").css({"-moz-transform" : mrotate, "-webkit-transform" : mrotate});      

  if(COUNTER==SHOT_INTERVAL) { //DRINK!
    DRINKS++;
    $('#ticker .minutes').text(DRINKS); //drink counter
    
    drinkAlert(); 

    if(DRINKS < 61)
      playNextVideo(); //change video
    else {
      stopPowr();
      alert("You are drunk as hell. Think you have another hr in you? -A product of DR Incorporated.");  
      location.reload(true);    
    }
  }
}
function stopPowr() {
  $('body').removeClass('drinking').addClass('thirsty');
  clearInterval(TICKER);
  stop();
}
function startPowr() {
  $('body').removeClass('thirsty').addClass('drinking');
  var state = getPlayerState();
  if(state==2 || state==5)
    play();
  else {
    drinkAlert();
    playNextVideo();
  }

  TICKER = setInterval(tick,1000);
}

    


