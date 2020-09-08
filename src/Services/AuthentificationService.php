<?php

namespace App\Services;

class AuthentificationService
{
  public function checkUsername()
  {
    if ($_SERVER['HTTP_API_USER_NAME'] === 'admin'){
      return true;
    } else {
      header('HTTP/1.1 403 incorrect user');
      echo 'Incorrect user';
      return false;
    }
  }
}