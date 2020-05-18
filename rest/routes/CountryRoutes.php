<?php
Flight::route('GET /admin/countries', function(){
  Flight::json(Flight::country_manager()->get_all());
});

Flight::route('POST /admin/countries', function(){
  Flight::json(Flight::country_manager()->add(Flight::request()->data->getData()));
});
?>
