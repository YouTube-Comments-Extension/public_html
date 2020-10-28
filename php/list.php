<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/DB.php');
include('classes/API.php');
include('classes/COLOR.php');

if (isset($_GET['channel']) && $_GET['channel'] != NULL) { // if there is a query and it is valid, list videos for the queried channel.
    echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
    echo $_GET['channel'];
    echo '</body>';
}else{
        if(isset($_GET['channel']) && $_GET['channel'] == NULL){ // if the query is empty return error and redirect to list all videos
            echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
            header("Refresh:1; url=https://www.replytu.be/list");
            echo 'This is not a valid channel';
            echo '</body>';
        }else{//if there is no query, list all the videos in the database
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
                $videoChannelTitle = $snippetJson->items[0]->snippet->channelTitle;
                $videoChannelId = $snippetJson->items[0]->snippet->channelId;    
                $backgroundColor = selectColor::random_color();
                echo '<div style="width:500px;display:inline-block;background-color:#'.$backgroundColor.';margin-left:10px;margin-right:10px;margin-top:10px;margin-bottom:10px;">';
                echo '<h4 style="margin-top: 0;margin-bottom: 0;position:relative;text-align:center;background-color:rgba(0, 0, 0, 0.75);color:white;font-family: Roboto, Arial, sans-serif;"><a href="https://www.youtube.com/channel/'.$videoChannelId.'" target="_blank" style="text-decoration: none;color:inherit;margin-top: 0;margin-bottom: 0;border: 1px solid white;">'.$videoChannelTitle.'</a>  : '.$videoTitle.'</h4>';
                echo '<a href="https://www.replytu.be/video.php?ytid='.$video[0].'"><img src="https://i3.ytimg.com/vi/'.$video[0].'/maxresdefault.jpg" height="240" width="426"></a>'."<br>"."<br>";
                echo '</div>';
                
            }
            echo '</div>';
            echo '</body>';
        }
}

?>
