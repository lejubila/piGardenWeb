## 0.4.2 - 15/07/2018
 - Added parameter PIGARDEN_TIMEOUT_DASHBOARD_STATUS in .env for customize time of polling refresh ajax dashboard and zone
 - Fix to call ajax refresh display when piGardenWeb is placed in a subdirectory of document route 

## 0.4.1 - 11/04/2018
 - Added configuration file for nginx with php7
 - Added instruction for instal on raspbian 9 stretch (nginx + php7)
 - Fix favicon 76x76 url
 - Add .env parameter APP_HTTPS_FORCE for automaticaly force all assets url to https

## 0.4.0 - 12/10/2017
 - Added tool bar in dashboard with buttons for stop all zones, disable all scheduling, reboot and shutdown system
 - Optimize on dashboards and home viewing zones with delayed startup
 - Required piGarden 0.5.x to work

## 0.3.3 - 01/08/2017
 - Added city view in weather conditions

## 0.3.2 - 31/07/2017
 - Add more irrigation time in delayed startup zones (1, 3, 5, 7 minutes)

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

