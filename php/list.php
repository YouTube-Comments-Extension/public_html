<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/DB.php');
include('classes/API.php');
include('classes/COLOR.php');

$myvideo = "1";
$ytid = DB::query('SELECT ytid FROM ytvideo WHERE retrieve=:retrieve ORDER BY id DESC', array(':retrieve'=>$myvideo));

echo '<title>ReplyTube | List</title>';
echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
echo '<div align="center">';
foreach($ytid as $video){ // get all the videos in the database, display their thumbnail, and link to the video watch page.

    $apiPublicKey = API::publicKey();
    $ytsnippetURL = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video[0] . '&key=' . $apiPublicKey;
    $snippetResponse = file_get_contents($ytsnippetURL);
    $snippetJson = json_decode($snippetResponse);
    $videoTitle = $snippetJson->items[0]->snippet->title;    
    $backgroundColor = selectColor::random_color();
    echo '<div style="width:500px;display:inline-block;background-color:#'.$backgroundColor.';">';
    echo '<h4 style="display:table;margin-top: 0;margin-bottom: 0;position:relative;text-align:center;background-color:rgba(255, 255, 255, 0.5);">'.$videoTitle.'</h4>';
    echo '<a href="https://www.replytu.be/video.php?ytid='.$video[0].'"><img src="https://i3.ytimg.com/vi/'.$video[0].'/maxresdefault.jpg" height="240" width="426"></a>'."<br>"."<br>";
    echo '</div>';
    
}
echo '</div>';
echo '</body>';

?>
