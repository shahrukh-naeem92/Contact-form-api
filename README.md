Contact Form Api
===========

Api for receiving contact form information and save it in database after validation.

Built With
-------------------

Php

Symfony

Mysql

Phpunit

Coding Standards
----------------

Psr-2 for coding guidelines.

psr-4 for auto loading.

Getting Started
---------------
These instructions will get you a copy of the project up and running on your local machine.


Prerequisites
-------------

Php 7.x

Mysql 5.x

Composer

Installing
----------

Follow these steps to setup the project localy

1) Clone or download this repo in your local machines.
2) Go to project root directory and run composer install from command line.
3) Adjust database credentials in app/config/parameters.yml file accordingly.
4) Run all migrations by running php bin/console doctrine:migrations:migrate from command line. This step will set up the database schema automatically.
5) Do appropriate web server configuration for landing the request to web/app.php or web/app_dev.php depending on the environment (production or development).

After these steps project will be up and running.

Usage
-----

Send a http post request to http(s)://yourdomain.com/inquiry with following two parameters in request body

1) email - a valid email address
2) message - a message less than 1000 characters.

Your message will be persisted to the database if it passes the validations.

Running the tests
-----------------

All the test cases reside in the tests directory on the root. For running all the test 
go to the project directory and run ./vendor/bin/simple-phpunit from command line.

Code Documentation
------------------

You can read the coding documentation here https://docs.google.com/document/d/1cl7RNM4QuZdfLRMtSbvVapu82m3-eC24o76nwqM70VM/edit?usp=sharing
                                    
                                    
                                    
