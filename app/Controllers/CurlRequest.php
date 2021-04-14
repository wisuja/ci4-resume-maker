<?php

namespace App\Controllers;

trait CurlRequest {
  public function getRequest($url, $headers = []) 
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    
    curl_close($ch);

    return $result;
  }

  public function postRequest($url, $parameters = [], $headers = []) 
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_HEADER, $headers);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
  }
}