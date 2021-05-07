// Remove every element with class "decay" after 5 seconds
setTimeout(function() {
      Array.from(document.getElementsByClassName("decay")).forEach(element => element.remove());
}, 5000);