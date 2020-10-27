<?php

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
