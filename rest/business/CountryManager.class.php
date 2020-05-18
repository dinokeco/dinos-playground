<?php
require_once 'dao/CountryDao.class.php';

class CountryManager {

  private $country_dao;

  public function __construct(){
    $this->country_dao = new CountryDao();
  }

  public function get_all(){
    $countries = $this->country_dao->get_all();
    foreach ($countries as $index => $country) {
      // call API to get population
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"https://data.opendatasoft.com/api/records/1.0/search/?dataset=world-population%40kapsarc&facet=year&facet=country_name&refine.country_name=".$country['name']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = json_decode(curl_exec($ch), TRUE);
      curl_close ($ch);

      $population = 0;
      $year = 0;
      if ($server_output){
        foreach ($server_output['records'] as $record) {
          if ($record['fields']['year'] > $year){
            $year = $record['fields']['year'];
            $population = $record['fields']['value'];
          }
        }
      }

      $countries[$index]['population'] = $population;
      if ($population == 0){
          $countries[$index]['inf_rate'] = 0;
      }else{
          $countries[$index]['inf_rate'] = round(($country['total'] / $population) * 100, 2);
      }

    }
    return $countries;
  }

  public function add($country){
    return $this->country_dao->add($country);
  }
}

?>
