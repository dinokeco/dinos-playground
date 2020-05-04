<?php
require_once 'BaseDao.class.php';

class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct('users');
  }

  public function get_user_by_email($email){
    $query = "SELECT * FROM users WHERE email=:email";
    return @($this->execute_query($query, ['email' => $email]))[0];
  }

}
?>
