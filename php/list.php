<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/DB.php');
include('classes/API.php');
include('classes/COLOR.php');

$apiPublicKey = API::publicKey();

if (isset($_GET['channel']) && $_GET['channel'] != NULL) { // if there is a query and it is valid, list videos for the queried channel.
    $ytsnippetItem = 'https://www.googleapis.com/youtube/v3/channels?part=id&fields=items/id&id=' . $_GET['channel'] . '&key=' . $apiPublicKey;
    $snippetItemResponse = file_get_contents($ytsnippetItem);
    $snippetItemJson = json_decode($snippetItemResponse, true);
    if ($snippetItemJson != NULL){
        $ytsnippetImgURL = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id=' . $_GET['channel'] . '&fields=items%2Fsnippet%2Fthumbnails&key=' . $apiPublicKey;
        $snippetResponse = file_get_contents($ytsnippetImgURL);
        $snippetJson = json_decode($snippetResponse);
        $channelAvi = $snippetJson->items[0]->snippet->thumbnails->default->url;

        $ytsnippetTitle = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items/snippet/title&id=' . $_GET['channel'] . '&key=' . $apiPublicKey;
        $snippetTitleResponse = file_get_contents($ytsnippetTitle);
        $snippetTitleJson = json_decode($snippetTitleResponse);
        $channelPageTitle = $snippetTitleJson->items[0]->snippet->title;

        $subcount ="13.4M";

        echo '<title>'.$channelPageTitle.' - ReplyTube</title>';
        echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
        echo"<br>"."<br>"."<br>"."<br>"."<br>";
        echo '<div align="left">';
            echo '<div style="display:inline-block;"><img src="'.$channelAvi.'" style="border-radius: 50%;margin: 0px 24px 0px 0px;" width="80" height="80"/></div>';
            echo '<div style="display:inline-block;position:relative;top:-2.7em;width:0px;line-height:40px;"><h4 style="margin:auto;color:white;font-family: Roboto, Arial, sans-serif;font-size:1.8rem;font-weight:400;">'.$channelPageTitle.'</h4></div>';
            echo '<div style="display:inline-block;position:relative;top:-1.1em;width:140;"><h4 style="margin: 0px 0px 0px 0px;;color:#aaaaaa;font-family: Roboto, Arial, sans-serif;font-size:1rem;font-weight:400;">'.$subcount.' subscribers</h4></div>';
        echo '</div>';
        echo '</body>';
        } else{
            echo '<title>ReplyTube | List</title>';
            echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
            header("Refresh:1; url=https://www.replytu.be/list");
            echo '<h4 style="margin-top: 0;margin-bottom: 0;position:relative;color:white;font-family: Roboto, Arial, sans-serif;">redirecting...This is not a valid channel</h4>';
            echo '</body>';
        }
}else{
        if(isset($_GET['channel']) && $_GET['channel'] == NULL){ // if the query is empty return error and redirect to list all videos
            echo '<title>ReplyTube | List</title>';
            echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
            header("Refresh:1; url=https://www.replytu.be/list");
            echo '<h4 style="margin-top: 0;margin-bottom: 0;position:relative;color:white;font-family: Roboto, Arial, sans-serif;">redirecting...This is not a valid channel</h4>';
            echo '</body>';
        }else{//if there is no query, list all the videos in the database
            $myvideo = "1";
            $ytid = DB::query('SELECT ytid FROM ytvideo WHERE retrieve=:retrieve ORDER BY id DESC', array(':retrieve'=>$myvideo));
    
            echo '<title>ReplyTube | List</title>';
            echo '<body style="margin-top: 0;margin-bottom: 0;background-color:#181818;">';
            echo '<div align="center">';
            foreach($ytid as $video){ // get all the videos in the database, display their thumbnail, and link to the video watch page.
                $ytsnippetURL = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video[0] . '&key=' . $apiPublicKey;
                $snippetResponse = file_get_contents($ytsnippetURL);
                $snippetJson = json_decode($snippetResponse);
                $videoTitle = $snippetJson->items[0]->snippet->title;
                $videoChannelTitle = $snippetJson->items[0]->snippet->channelTitle;
                $videoChannelId = $snippetJson->items[0]->snippet->channelId;    
                $backgroundColor = selectColor::random_color();
                echo '<div style="width:500px;display:inline-block;background-color:#'.$backgroundColor.';margin-left:10px;margin-right:10px;margin-top:10px;margin-bottom:10px;">';
                echo '<h4 style="margin-top: 0;margin-bottom: 0;position:relative;text-align:center;background-color:rgba(0, 0, 0, 0.75);color:white;font-family: Roboto, Arial, sans-serif;"><a href="https://www.replytu.be/list?channel='.$videoChannelId.'" style="text-decoration: none;color:inherit;margin-top: 0;margin-bottom: 0;">'.$videoChannelTitle.'</a>  : '.$videoTitle.'</h4>'; // a tag style removed border: 1px solid white;
                echo '<a href="https://www.replytu.be/video.php?ytid='.$video[0].'"><img src="https://i3.ytimg.com/vi/'.$video[0].'/maxresdefault.jpg" height="240" width="426"></a>'."<br>"."<br>";
                echo '</div>';
                
            }
            echo '</div>';
            echo '</body>';
        }
}

?>
