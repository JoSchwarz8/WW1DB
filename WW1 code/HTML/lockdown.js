// lockdown.js

// Enable fullscreen
function enableFullScreen() {
    const elem = document.documentElement;
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
  }
  
  // Disable right-click
  document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
  });
  
  // Block dangerous key combos
  document.addEventListener('keydown', function (e) {
    const blockedKeys = ['F5', 'F11', 'F12', 'Escape', 'Tab', 'Meta', 'Control'];
    const comboBlocks = (e.ctrlKey || e.metaKey || e.altKey);
  
    if (blockedKeys.includes(e.key) || comboBlocks) {
      e.preventDefault();
      console.log("Blocked key:", e.key);
    }
  });
  
  // Detect window blur (user switching tabs or apps)
  window.onblur = function () {
    alert("Lockdown mode: Please stay on this screen.");
    window.location.href = "logout.php"; // Or redirect to login screen
  };
  
  // Auto-initiate lockdown
  window.onload = function () {
    enableFullScreen();
  };
  