/*
 * Lastfm support. This will get my most recently played tracks and fetch cover art for their albums.
 */
ALBUMS = new Array();
function addAlbumImage(uri, img)
{
  ALBUMS.push(img);
  var $li = $('<li />').addClass('album');//.css('width','0px');
  $li.append($('<a target="_blank" href="'+uri+'"><img src="'+img+'" /></a>'));
  $('#albums').append($li);
}

// pass in the 'created_at' string returned from twitter //
// stamp arrives formatted as Tue Apr 07 22:52:51 +0000 2009 //
// stolen politely from: http://www.quietless.com/kitchen/format-twitter-created_at-date-with-javascript/
function parseTwitterDate(stamp)
{		
// convert to local string and remove seconds and year //		
	var date = new Date(Date.parse(stamp)).toLocaleString().substr(0, 16);
	return date.substr(0, 11);
}

function addTweet(tweet) {
  var $li = $('<li />').addClass('tweet');
  $li.append(
      $('<span/>')
        .text(tweet.text)
        .append(
          $('<span/>')
            .addClass('date')
            .text(parseTwitterDate(tweet.created_at))
          )
      );
  $('#tweets').append($li);
}

$(function() {

  //lastfm goodness
  $('.album').live('mouseover', function() { $('.album').not($(this)).stop().animate({ opacity: 0.3 },200); });
  $('.album').live('mouseleave', function() { $('.album').not($(this)).stop().animate({ opacity: 1.0 },200); });

  $.getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=mattfeury&limit=60&api_key=625d2096602985b4fed48ac23d89932d&format=json&callback=?',function(data, status, xhr) {
    $.each(data.recenttracks.track, function(i, item) {
      if ($.inArray(item.image[1]['#text'],ALBUMS)==-1 && item.image[1]['#text']!="") {
        addAlbumImage(item.url,item.image[1]['#text']);
        if (ALBUMS.length > 7) return false;
      }
    }); 
  });

  //twitter goodness
  $.getJSON('https://api.twitter.com/status/user_timeline/soundandfeury.json?callback=?',function(data, status, xhr) {
    $.each(data, function(i, item) {
      addTweet(item);
      if (i >= 2)
        return false;
    }); 
  });

});
