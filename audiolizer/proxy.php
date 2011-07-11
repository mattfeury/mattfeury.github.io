<?php
//defaults
$url = "http://farm2.static.flickr.com/1289/4696900767_fe94e03b42_z.jpg";
if(isset($_GET['url']) && $_GET['url'] != "")
  $url = $_GET['url'];

//The cURL stuff...
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$picture = curl_exec($ch);
curl_close($ch);

//Display the image in the browser
header('Content-type: image/jpeg');
echo $picture;
?>