<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/DB.php');
include('classes/API.php');

if (isset($_GET['ytid'])) {
  if(DB::query('SELECT ytid FROM ytvideo WHERE ytid=:ytid', array(':ytid'=>$_GET['ytid']))){
    $apiPublicKey = API::publicKey();
    $ytsnippetURL = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $_GET['ytid'] . '&key=' . $apiPublicKey;
    $snippetResponse = file_get_contents($ytsnippetURL);
    $snippetJson = json_decode($snippetResponse);
    $videoTitle = $snippetJson->items[0]->snippet->title;
    echo '<title>'.$videoTitle.'</title>';
    echo "<div align='center'><iframe width='1280' height='720' src='https://www.youtube.com/embed/".$_GET['ytid']."' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
    echo '<div align="center"><h1>'.$videoTitle.'</h1></div>';
  } else{
    echo '<title>redirecting...</title>';
    header("Refresh:1; url=https://www.replytu.be/");
    echo "redirecting...video not found in database";
  }
}else{
  echo '<title>redirecting...</title>';
  header("Refresh:1; url=https://www.replytu.be/list");
  echo "redirecting...";
}

?>
