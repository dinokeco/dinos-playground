<?php
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/CountryDao.class.php');
require_once('dao/UserDao.class.php');

Flight::register('country_dao', 'CountryDao');
Flight::register('user_dao', 'UserDao');

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
  $headers = getallheaders();
  $user_id = $headers['X-Covid-User'];
  Flight::json(Flight::country_dao()->get_all());
});

Flight::route('POST /countries', function(){
  Flight::json(Flight::country_dao()->add(Flight::request()->data->getData()));
});

Flight::route('POST /user', function(){
  $user = Flight::request()->data->getData();
  Flight::user_dao()->add($user);
});
// check username and password
Flight::route('POST /login', function(){
  $user = Flight::request()->data->getData();

  $db_user = Flight::user_dao()->get_user_by_email($user['email']);

  if ($db_user){
    if ($db_user['password'] == $user['password']){
      Flight::json($db_user);
    }else{
      Flight::halt(404, 'Password Incorrect');
    }
  }else{
    Flight::halt(404, 'User not found');
  }

});

Flight::start();
?>
