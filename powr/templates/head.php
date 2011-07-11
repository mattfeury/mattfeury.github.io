<? 
require_once 'lib/god.php';

$uri = explode("/", $_SERVER['PHP_SELF']);
$page = explode(".",$uri[count($uri)-1]);

include_once "lib/controllers/".$page[0].".php";

?>
<!DOCTYPE HTML> 
<html> 
<head> 
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>powrhr</title> 
 
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> 
 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
<script type='text/javascript' src='javascripts/swfobject.js'></script>
<script type='text/javascript' src='javascripts/youtube.api.js'></script>

<link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
<link href="stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
<link href="stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
<!--[if IE]>
    <link href="stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
<![endif]-->

