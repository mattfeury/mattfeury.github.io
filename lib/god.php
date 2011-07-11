<?
session_start();
$DOC_ROOT = str_replace("public_html","",$_SERVER['DOCUMENT_ROOT']);
$INCLUDE_PATH = $DOC_ROOT.'include/';

include $INCLUDE_PATH.'dbscripts/config.php';
include $INCLUDE_PATH.'dbscripts/opendb.php';

?>
