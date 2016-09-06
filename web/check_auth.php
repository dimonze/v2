<?php

if ((!isset($_SERVER['PHP_AUTH_USER'])) || (!isset($_SERVER['PHP_AUTH_PW']))) {
  header('WWW-Authenticate: Basic realm="Private Stuff"');
  header('HTTP/1.0 401 Unauthorized');
  echo 'Authorization Required.';
  exit;
}
elseif ((isset($_SERVER['PHP_AUTH_USER'])) && (isset($_SERVER['PHP_AUTH_PW']))){
  if (($_SERVER['PHP_AUTH_USER'] != "2012admingarage") || ($_SERVER['PHP_AUTH_PW'] != "gwlN%yk-8O{H5qOZ")) {
    header('WWW-Authenticate: Basic realm="Private Stuff"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authorization Required.';
    exit;
  }
}
