<?php
function getDb() {
  $dsn = 'mysql:dbname=cdp; host=%; charset=utf8';
  $usr = 'cdp';
  $passwd = 'Tokissme?';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  return $db;
}