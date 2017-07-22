# Famous Stylists Hair Salon

#### Simple app allowing the user to view, add, edit, and delete stores, add brands, and add brands to individual stores at a fictitious shoe distribution company.

#### By Nicole Freed

## Description

Simple app allowing the user to view, add, edit, and delete stores, add brands, and add brands to individual stores at a fictitious shoe distribution company. The app also displays a list of brands for a given store when the store name is clicked.

## Prerequisite Installations

* PHP
https://www.learnhowtoprogram.com/php/getting-started-with-php/installing-php
* Composer
    * (Mac) https://www.learnhowtoprogram.com/php/getting-started-with-php/installing-composer-and-configuration-for-mac
    * (Windows)
    https://www.learnhowtoprogram.com/php/getting-started-with-php/installing-composer-and-configuration-for-windows

## Setup/Installation Requirements
* Clone the project directory from Terminal using `git clone https://github.com/gitasong/address-book-twig.git`.
* Unzip the project directory.
* In Terminal, navigate to the main project directory and install the necessary dependencies (Silex and Twig) using `composer install`.
* In Terminal, navigate to the web folder inside the main project directory and start your PHP server using `php -S localhost:8000`.
* Type `localhost:8000` in your browser URL window to start the app.
* To view and edit the database:
    * Open MAMP. Click on `Preferences > Ports` tab and set the Apache port to 8888 and the MySQL port to 8889.
    * In MAMP, click `Open WebStart page`. The MAMP WebStart page will open in your browser.
    * Click on the `Tools` dropdown menu at the top of the WebStart page and choose `phpMyAdmin`.
    * Once phpMyAdmin opens in your web browser, click the `Import` tab > `Browse` button and navigate to the `shoe_store.sql` file in the project directory. Click `Go` to load the file.
* MySQL commands to recreate the `shoe_store` database:
    * `CREATE DATABASE shoe_store`
    * `USE shoe_store`
    * `CREATE TABLE stores (id serial PRIMARY KEY, store_name VARCHAR (30));`
    * `CREATE TABLE brands (id serial PRIMARY KEY, store_name VARCHAR (30), price FLOAT (10,2));`
    * `CREATE TABLE brands_stores (store_id INT, brand_id INT, id serial PRIMARY KEY);`

## Known Bugs

No known bugs.

## Support and contact details

You can contact me at gitasong@github.io.

## Technologies Used

* PHP 5.6
* HTML 5
* Silex 1.1
* Twig 1.0
* Composer
* MAMP 4.1.1
* Apache server
* PHPUnit 4.5.x (for testing)
* MySQL 5.6.35
* phpMyAdmin

### License

This app is licensed under the MIT license.

Copyright (c) 2016 Nicole Freed
