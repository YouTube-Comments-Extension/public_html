document.addEventListener('DOMContentLoaded', function() {
    var checkPageButton = document.getElementById('checkPage');
    checkPageButton.addEventListener('click', function() {
  
        chrome.tabs.query({active: true, lastFocusedWindow: true}, tabs => {
            let tabUrl = tabs[0].url;
            console.log(tabUrl);
        });
    }, false);
  }, false);