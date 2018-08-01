<?
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
foreach($_GET as $k=>$v){$$k=$v;}
foreach($_POST as $k=>$v){$$k=$v;}



session_name('JOBSESID');
@session_start();

foreach($_SESSION as $k=>$v){$$k=$v;}

?>

