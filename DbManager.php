<?php
function getDb() {
  $dsn = 'mysql:dbname=cdp;  charset=utf8';
  $usr = 'root';
  $passwd = 'Tokissme?';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  return $db;
}