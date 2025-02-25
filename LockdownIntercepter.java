/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.example.lockdownfeature.demo;

/**
 *
 * @author farha
 */
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.*;
import jakarta.servlet.http.HttpSession;
import org.springframework.web.servlet.ModelAndView;

@RestController
@RequestMapping("/api")
@SpringBootApplication
public class LockdownIntercepter {
    
    
    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws Exception{
        HttpSession session = request.getSession(false);
        if (session != null && Boolean.TRUE.equals(session.getAttribute("lockdown"))) {
            String uriRequest = request.getRequestURI();
            
            
            // enabling access solely to /api/checkLockdown and login page
            if (!uriRequest.equals("/api/checkLockdown") && !uriRequest.equals("/api/login")) {
                response.sendRedirect("/lockdownPage.html"); // Redirecting to the lockdown page section
                return false;
            }
        }
        return true; // if lockdown is not active then allow request
    }

   private void enforceLockdown(){
	try {
	    // forcing the kiosk mode in Chrome(already triggered in LockdownController)
	    Runtime.getRuntime().exec("cmd /c start chrome --kiosk http://localhost:8080");

            // Kill restricted applications like Firefox, Task Manager, Explorer, etc.
            Runtime.getRuntime().exec("taskkill /F /IM firefox.exe"); 
            Runtime.getRuntime().exec("taskkill /F /IM taskmgr.exe"); 
            Runtime.getRuntime().exec("taskkill /F /IM explorer.exe"); 

            // Prevent Task Manager from reopening
            Runtime.getRuntime().exec("reg add HKCU\\Software\\Microsoft\\Window\\CurrentVersion\\Policies\\System /v DisableTaskMgr /t REG_DWORD /d 1 /f");
	} catch(Exception e) {
	    e.printStackTrace();
	}
  }
    
    
 
    public void postHandle(HttpServletRequest request, HttpServletResponse response, Object handler, ModelAndView modelandView) throws Exception{
        // theres no need to edit the response once handling is completed
        
    }
    
    
    public void afterCompletion(HttpServletRequest request, HttpServletResponse response, Object jandler, Exception ex) throws Exception {
        // adding more cleanup is not needed. 
    }
    
    
}
