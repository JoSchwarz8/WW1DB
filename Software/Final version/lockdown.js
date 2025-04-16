/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

async function checkLockdownStatus() {
    const response = await fetch("/checkLockdown");
    const isLockdownActive = await response.json();
    
    if (!isLockdownActive) {
        window.location.href = "/index.html"; // Redirect to normal page if lockdown is disabled
    }
    
    
    // Run the check every 5 seconds
    setInterval(checkLockdownStatus, 5000);
}