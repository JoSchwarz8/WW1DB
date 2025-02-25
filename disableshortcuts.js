/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

document.addEventListener("keydown", function(event) {
    // blocking common shortcuts
    if (event.ctrlKey || event.metaKey || event.altKey) {
        event.preventDefault();
    }
    
    // blocking F11 (Fullscreen toggle)
    if (event.key == "F11") {
        event.preventDefault();
    }
    
    // Block developer tools (F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U)
    if (
        event.key === "F12" || 
        (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J")) ||
        (event.ctrlKey && event.key == "U")
    ) {
        event.preventDefault();
    }
});
