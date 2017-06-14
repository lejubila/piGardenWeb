## 0.3.1 - 14/06/2017
 - Add more irrigation time in delayed startup zones (10, 15, 20 minutes)

## 0.3.0 - 14/06/2017 - Security server socket connection and ability to disabled or enabled scheduled item
 - Added support for server socket credentials: define PIGARDEN_SOCKET_CLIENT_USER and PIGARDEN_SOCKET_CLIENT_PWD in your .env. Required piGarden v 4.0.0 or greeter.
 - Added the ability to disabled or enabled an exists open/close chedule 

## 0.2.0 - 07/05/2017 - Delayed startup
 - Added support for delayed startup of zones

## 0.1.1 - 28/04/2017 - Bugfix
 - Fix problem lowercase namespace "app" in edit.blade.php

## 0.1 - 23/04/2017 - First release
First release to piGardenWeb  
  
Include the following features:  
 - Dashboard for control solenoid and weather conditions
 - Scheduling open/close solenoid
 - Automate crontab configuration for:
   * piGarden initialization at boot of the system, 
   * start the socket server for communication between piGarden and piGardenWeb,
   * management the rain control from the sensor and on-line service

