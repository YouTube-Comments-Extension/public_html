document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
   link.addEventListener('click', function () {
     AddUrl();
    });

    chrome.cookies.set({"name":"AddVideo","url":"https://replytu.be","value":"Dummy Data", expirationDate: (new Date().getTime()/1000) + 30},function (cookie){
      console.log(JSON.stringify(cookie));
      console.log(chrome.extension.lastError);
      console.log(chrome.runtime.lastError);
  });

    // chrome.cookies.set({ url: "https://replytu.be", name: "CookieVar", value: "123", expirationDate: (new Date().getTime()/1000) + 30 });

    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        var url = tabs[0].url
        var youtubeRegExp = /(?:[?&]vi?=|\/embed\/|\/\d\d?\/|\/vi?\/|https?:\/\/(?:www\.)?youtu\.be\/)([^&\n?#]+)/;
        var match = url.match( youtubeRegExp );
        if( match && match[ 1 ].length == 11 ) {
          url = match[ 1 ];
          var vidUrl = "https://replytu.be/addvideo.php?ytid=" + url;
          window.open(vidUrl, '_blank');
          //document.getElementById("demo").innerHTML = url;
        }
      });
    }
  });