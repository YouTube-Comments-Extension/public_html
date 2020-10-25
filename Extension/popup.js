document.addEventListener('DOMContentLoaded', function () {
    var link = document.getElementById('btn');
    // onClick's logic below:
    link.addEventListener('click', function () {
      AddUrl();
    });
  
  
    function AddUrl() {
      chrome.tabs.query({ currentWindow: true, active: true }, function (tabs) {
        alert(tabs[0].url)
        // document.getElementById('Current_url').value = tabs[0].url;
        console.log(tabs[0].url, tabs[0].title, tabs[0].incognito, tabs, this.bookmark_title);
      });
    }
  });