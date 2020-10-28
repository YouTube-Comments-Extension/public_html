<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/DB.php');
include('classes/API.php');

if(isset($_COOKIE['AddVideo'])){
  setcookie("AddVideo", '' , time() - 30);
  if(isset($_GET['ytid'])){
  $apiPublicKey = API::publicKey();
  $ytidURL = 'https://www.googleapis.com/youtube/v3/videos?part=id&id=' . $_GET['ytid'] . '&key=' . $apiPublicKey;
  $idResponse = file_get_contents($ytidURL);
  $idJson = json_decode($idResponse, true);
    if (sizeof($idJson['items'])) {
      $ytstatsURL = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id=' . $_GET['ytid'] . '&key=' . $apiPublicKey;
      $statsResponse = file_get_contents($ytstatsURL);
      $statsJson = json_decode($statsResponse);
      $statsObject = $statsJson->items[0]->statistics;
      if(!(property_exists($statsObject, 'commentCount'))){
        if(!DB::query('SELECT ytid FROM ytvideo WHERE ytid=:ytid', array(':ytid'=>$_GET['ytid']))){
          DB::query('INSERT INTO ytvideo VALUES (\'0\', :ytid, \'1\')', array(':ytid'=>$_GET['ytid']));
          header("Refresh:0; url=https://www.replytu.be/video.php?ytid=".$_GET['ytid']."");
          echo 'adding to the database';// video exists
        }else{
          header("Refresh:0; url=https://www.replytu.be/video.php?ytid=".$_GET['ytid']."");
          echo 'This video is already in the database';
        }
      }else{
        echo 'comments are enabled on this video';
      }
    }else{
      echo 'This video does not exist';
    } 
  }else {
    echo 'This is not a valid URL';// video does not exist
  }
} else{
  echo "Add our extension first";
}
// if(){ // ytid is set
//   if(){ // the video exists
//     if(){ // if the video has comments disabled
//       if(){ // the video isn't in the database
//         // make a query and add the ytid to the database
//         // redirect to the video page with the ytid
//       } else {
//         echo "This video is already in the database"; // if the video is in the database link to it
//       }
//     } else{
//       echo "This video does not have comments disabled"; // if the video does not exist, link them to youtube home page
//     }
//   }
// }


?>
