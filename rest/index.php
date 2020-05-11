<?php
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/CountryDao.class.php');
require_once('dao/UserDao.class.php');

use \Firebase\JWT\JWT;

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
  $token = @$headers['X-Covid-User'];

  if ($token){
    try {
        $user = JWT::decode($token, Config::JWT_SECRET, array('HS256'));
        if ($user){
          Flight::json(Flight::country_dao()->get_all());
        }else{
          Flight::halt(403, "Unauthorized User - Token Sucks");
        }
    } catch (\Exception $e) {
      Flight::halt(403, "Unauthorized User - Token Sucks");
    }
  }else{
    Flight::halt(403, "Unauthorized User");
  }
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
      //Flight::json($db_user); wrong
      $token_user = [
        'id' => $db_user['id'],
        'email' => $db_user['email'],
        'is_admin' => $db_user['is_admin']
      ];
      $jwt = JWT::encode($token_user, Config::JWT_SECRET);
      Flight::json(['id' => $db_user['id'],'token' => $jwt]);
    }else{
      Flight::halt(404, 'Password Incorrect');
    }
  }else{
    Flight::halt(404, 'User not found');
  }

});

Flight::start();
?>
