document.addEventListener('DOMContentLoaded', function () {
  var link = document.getElementById('btn');

  //Display Button Message
  chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
    var str = tabs[0].url
    if(str === "https://replytu.be/" || "https://replytu.be/index"){ //On ReplyTube homepage
      document.getElementById("btn").innerHTML = "Thanks for downloading!";
      return;
    }
    if(str.startsWith("https://replytu.be/video.php") || str.startsWith("https://replytu.be/video?ytid=")){ //On ReplyTube Video
        document.getElementById("btn").innerHTML = "Take me back to YouTube";
    }
    else{ //On YouTube Video
        document.getElementById("btn").innerHTML = "Take me to ReplyTube!";
    }
  });

  //OnClick Event Function
  link.addEventListener('click', function () {
    AddUrl();
  });
  
  //Chrome Cookies
  chrome.cookies.set({"name":"AddVideo","url":"https://replytu.be/" ,"value":"Dummy Data", expirationDate: (new Date().getTime()/1000) + 30},function (cookie){
    console.log(JSON.stringify(cookie));
    console.log(chrome.extension.lastError);
    console.log(chrome.runtime.lastError);
});

  //OnClick Event Actions (Button Click)
  function AddUrl() {
    chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
      var str = tabs[0].url
      if(str === "https://replytu.be/" || "https://replytu.be/index"){ //On ReplyTube homepage
        window.open("https://www.youtube.com/watch?v=dQw4w9WgXcQ", '_blank'); //Rick Roll
      }
      else if(str.startsWith("https://replytu.be/video.php?ytid=")){ //On ReplyTube Video
        var res = str.slice(34,45);
        var newUrl = "https://www.youtube.com/watch?v=" + res;
        window.open(newUrl, '_blank');
      }
      else if(str.startsWith("https://replytu.be/video?ytid=")){ //On ReplyTube Video List
        var res = str.slice(30,41);
        var newUrl = "https://www.youtube.com/watch?v=" + res;
        window.close();
        window.open(newUrl, '_blank');
      }
      else if(str.startsWith("https://www.youtube.com/watch?v=")){ //On YouTube Video
        var res = str.slice(32,43);
        var newUrl = "https://replytu.be/video.php?ytid=" + res;
        window.open(newUrl, '_blank');
      }
      else{
        document.getElementById("demo").innerHTML = "Invalid URL"; //On any other URL
      }
    });
  }
});