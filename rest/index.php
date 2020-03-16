<?php
require('../vendor/autoload.php');

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/abc123', function(){
    echo 'hello world!';
});

Flight::start();
?>
