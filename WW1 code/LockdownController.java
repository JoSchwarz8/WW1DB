/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.example.lockdownfeature.demo;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.*;
import jakarta.servlet.http.HttpSession;

@RestController
@RequestMapping("/api")
@SpringBootApplication
/**
 *
 * @author farha
 */
public class LockdownController {
    
        // Creating a dummy method for login authentication(someone else in the group has already been assigned this task
        @PostMapping("/login")
	public String loginPart(@RequestParam String username, @RequestParam String password, HttpSession session){
            if(userAuthentication(username, password)){
                lockdownTrigger(session);
                return "Login Successful. Lockdown Mode initialised";
            } else {
                return "Error: Invalid username or password.";
            }
        }
        
        
        // Another dummy method which simulates user authentication(replacing with logic)
        private boolean userAuthentication(String username, String password){
            return "admin".equals(username) && "password123".equals(password); // example condition set
        }
        
        
        // method to trigger the lockdown(setting session attribute)
        private void lockdownTrigger(HttpSession session){
            session.setAttribute("lockdown", true); // The session will get marked as lockdown
            
            // forcing the full screen mode
            try {
                Runtime.getRuntime().exec("cmd/c start/max chrome --kiosk http://localhost:8080");
            } catch (Exception e){
                e.printStackTrace();
            }
        }
        
        
        // method to see if lockdown is active 
        public boolean checkIfLockdownIsActive(HttpSession session){
            Boolean lockdown = (Boolean) session.getAttribute("lockdown");
            return lockdown != null && lockdown;
        }

}
