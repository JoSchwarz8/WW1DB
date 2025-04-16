/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
document.getElementById("loginForm").addEventListener("submit", async function(event) {
    event.preventDefault(); // Prevents the form from refreshing the page

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const response = await fetch("/login", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ username, password })
    });

    const message = await response.text();

    if (message.includes("Lockdown mode activated")) {
        // Redirects to the correct lockdown page
        window.location.href = "lockdown.html";  
    } else {
        // Displays an error message in the correct element
        document.getElementById("errorMessage").innerText = "Invalid login credentials";
    }
});
