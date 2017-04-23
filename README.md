# piGardenWeb
Web control panel to manage your piGarden (system irrigation with Raspberry Pi)

## Official documentation 
Documentation of piGarden and build system irrigation with Raspberry Pi can be found on the [www.lejubila.net/tag/pigarden/](http://www.lejubila.net/tag/pigarden/)

## License

This script is open-sourced software under GNU General Public License v3.0

## Installation

PiGardenWeb is an web application based on Laravel, Backpack and piGarden. To work on your Rasperry Pi, it needs php 5.5.9, nginx web server and other packages.

1) Installs the necessary packages on your terminal:
    ```bash
    sudo apt-get install nginx php5-fpm php5-cli php5-mcrypt php5-sqlite git
    ```

2) Configure php:
modify the file /etc/php5/fpm/php.ini, search and uncomment the line with cgi.fix_pathinfo and assigned the value zero:
    ```bash
    cgi.fix_pathinfo=0
    ```

3) Enable php modules:
    ```bash
    sudo php5enmod mcrypt
    sudo php5enmod sqlite3
    ```

4) Download piGardenWeb in your home: 
    ```bash
    cd
    git clone https://github.com/lejubila/piGardenWeb.git
    ```

5) Configure nginx with the configuration file present in piGardenWeb and personalize it if necessary:
    ```bash
    cd
    sudo cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.original
    sudo cp piGardenWeb/virtualhost/nginx/default /etc/nginx/sites-available/default
    ```

6) Configure piGardenWeb
    * Create configuration file .env 
        ```bash
        cd 
        cd piGardenWeb
        cp .env.example .env
        ```
    * Create sqlite and initialize database, generate application key, assign owner and permission
        ```bash
        touch database/piGarden.sqlite
        ./artisan key:generate
        ./artisan migrate
        sudo chown -R pi:www-data /home/pi/piGardenWeb/
        sudo chmod -R g+w storage database/piGarden.sqlite
        ```
        
    * Modify .env to your liking
    
7) Start nginx web server
    ```bash
    sudo service nginx restart
    ```
8) Install piGarden script and start socket_server (skip this point if you have already installed the pigarden on your Raspberry Pi):
    * Download and install piGarden script in your home, see [github.com/lejubila/piGarden](https://github.com/lejubila/piGarden)
    * Start piGarden socket server
        ```bash
        cd
        cd piGarden
        ./piGarden start_socket_server force
        ```
9) Remove piGarden crontab scheduling if already present (skip this point if you have NOT already installed the pigarden on your raspberry pi)

10) Open your browser on http://ip_address_of_your_raspberry_pi and register your user.

11) Sign in to piGardenWeb with the newly created user, and perform the initial setup from the menu "SETUP / Initial setup"

11) Now you can disable open registration by editing the .env file and setting REGISTRATION_OPEN with the value "false".
    You can also change the language of the interface (LOCALE = en / en) and smtp parameters for sending email notifications to reset the user password.
