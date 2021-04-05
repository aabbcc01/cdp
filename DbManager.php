<?php
function getDb() {
  $dsn = 'mysql:dbname=cdp;port=3306; host=13.112.39.220; charset=utf8';
  $usr = 'cdp';
  $passwd = 'Tokissme?';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  return $db;
}