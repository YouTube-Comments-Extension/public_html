document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
   link.addEventListener('click', function () {
     AddUrl();
    });

    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        var url = tabs[0].url
        var youtubeRegExp = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/;
        var match = url.match( youtubeRegExp );
        if( match && match[ 1 ].length == 11 ) {
          url = match[ 1 ];
          var vidUrl = "https://replytu.be/video.php?ytid=" + url;
          window.open(vidUrl, '_blank');
          //document.getElementById("demo").innerHTML = url;
        }
      });
    }
  });