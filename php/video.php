<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(./classes/DB.php);

$ytid = "";


if (isset($_GET['ytid'])) {
  $ytid = $_GET['ytid'];
  if(DB::query('SELECT ytid FROM ytvideo WHERE ytid=:ytid', array(':ytid'=>$ytid))){
  echo "<div align='center'><iframe width='1280' height='720' src='https://www.youtube.com/embed/".$_GET['ytid']."' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
} else{
  echo "video not found";
}
}

?>
