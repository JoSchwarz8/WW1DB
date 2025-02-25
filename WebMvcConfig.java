/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.example.lockdownfeature.demo;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.servlet.config.annotation.CorsRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.ViewControllerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
/**
 *
 * @author farha
 */

public class WebMvcConfig implements WebMvcConfigurer{
    
    // Configuring the cross origin resource sharing(CORS)
    public void addingCorsMapping(CorsRegistry registry){
        registry.addMapping("/**") // Applying CORS settings to all endpoints
                .allowedOrigins("http://localhost:3000") // allowing requests from front end
                .allowedMethods("GET","POST","PUT","DELETE") // allowed HTTP methods
                .allowCredentials(true);
    }
    
    // Configuring static resource handling
    public void addingResourceHandlers(ResourceHandlerRegistry registry){
        registry.addResourceHandler("/static/**")
                .addResourceLocations("classpath:/static/");
    }
    
    // Configuring view controllers(optional)
    public void addingViewControllers(ViewControllerRegistry registry){
        registry.addViewController("/lockdown").setViewName("lockdown");
    }
    
    @GetMapping("/startKiosk")
    public void startKiosk(){
        try{
            Runtime.getRuntime().exec("cmd /c start/max chrome --kiosk http://localhost:8080");
        } catch(Exception e){
            e.printStackTrace();
        }
    }
}
