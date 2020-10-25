document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
    link.addEventListener('click', function () {
      AddUrl();
    });
  
  
    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        // document.getElementById('Current_url').value = tabs[0].url;
        var str = tabs[0].url
        var res = str.slice(32);
        //console.log(ytID);
        console.log(res);
      });
    }
  });