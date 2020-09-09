<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
class AuthentificationService
{

  public function checkUsername()
  {
    if (!array_key_exists('HTTP_API_USER_NAME', $_SERVER) || $_SERVER['HTTP_API_USER_NAME'] != 'admin'){
        return new Response("403. Incorrect user", Response::HTTP_FORBIDDEN);
    }
  }
}