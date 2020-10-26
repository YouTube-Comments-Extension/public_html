<?php

if(){ // the video exists
  if(){ // the video isn't in the database
    // make a query and add the ytid to the database
    // redirect to the video page with the ytid
  } else {
    echo "This video is already in the database"; // if the video is in the database link to it
  }
} else{
  echo "This video does not exist"; // if the video does not exist, link them to youtube home page
}


?>
