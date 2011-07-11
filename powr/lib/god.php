<?
error_reporting(E_ALL & ~E_WARNING);

session_start();

//globals
$ROOT = "/powr/";
$LIB = $ROOT."lib/";
$AJAX_LIB = $LIB."ajax/";
//$HOME = $ROOT."profile.php";

foreach (glob("lib/model/*.php") as $filename)
{
    require_once $filename;
}


//functions
function goRoot() { header('Location: '.$GLOBALS['ROOT']); exit; }

// from MySQL to UNIX timestamp. I did not write this. credit: http://www.vision.to/convert-mysql-date-to-unix-timestamp.php
function convert_datetime($str) 
{
list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);
return mktime($hour, $minute, $second, $month, $day, $year);
}

//this is very dangerous. this stuff should be placed below the publicly viewable directory. but since this on tech's server, it is quite difficult
$dbhost = 'mysql.mattfeury.com';
$dbuser = 'powr_user';
$dbpass = 'powr420';
$dbname = 'powr';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);

?>
