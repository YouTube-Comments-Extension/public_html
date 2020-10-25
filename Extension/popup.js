document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
    link.addEventListener('click', function () {
      AddUrl();
    });
  
  
    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        var str = tabs[0].url
        if(str.startsWith("https://www.youtube.com/watch?v=")){
          var res = str.slice(32,43);
          document.getElementById("demo").innerHTML = res;
        }
        else{
          document.getElementById("demo").innerHTML = "no, you can't do that.";
        }
      });
    }
  });