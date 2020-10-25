document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
    link.addEventListener('click', function () {
      AddUrl();
    });
  
  
    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        // document.getElementById('Current_url').value = tabs[0].url;
        let tabUrl = tabs[0].url
        //var ytID = str.split("https://www.youtube.com/watch?v=");
        //console.log(ytID);
        console.log(tabUrl);
      });
    }
  });