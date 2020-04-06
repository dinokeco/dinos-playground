<?php
require_once 'BaseDao.class.php';

class CountryDao extends BaseDao{

  public function __construct(){
    parent::__construct('countries');
  }

}
?>
