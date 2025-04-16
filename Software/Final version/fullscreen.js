/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function enterFullscreen(){
    const elem = document.documentElement; // Fullscreening the entire document
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if(elem.mozRequestFullScreen){ // Firefox
        elem.mozRequestFullScreen();
    } else if(elem.msRequestFulscreen){   // Chrome, Safari, Edge
        elem.msRequestFulscreen();
    } else if(elem.msRequestFulscreen){  // IE/Edge
        elem.msRequestFulscreen();
    }
}

// Prevents exiting fullscreen mode
document.addEventListener("fullscreenchange", () =>{
    if (!document.fullscreenElement) {
        enterFullscreen();
    }
});

// Calling the fullscreen mode on page load
window.onload = enterFullscreen;
