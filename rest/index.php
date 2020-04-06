<?php
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/CountryDao.class.php');

Flight::register('country_dao', 'CountryDao');

Flight::route('/', function(){
    echo 'hello world!';
});


// FRONTEND
// jQuery - Procedural coding
// ajax call with backend

// BACKEND
// Presentation - Rest API
// BussinessLogic Layer - Controller/ Managers / Agents etc...
// DAO - Data Access Object - PHP Code for managing data - talking to MYSQL
// DATABASE - MYSQL

Flight::route('GET /countries', function(){
  Flight::json(Flight::country_dao()->get_all());
});

Flight::route('POST /countries', function(){
  Flight::json(Flight::country_dao()->add(Flight::request()->data->getData()));
});

Flight::start();
?>
