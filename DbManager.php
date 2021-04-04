<?php
function getDb() {
  $dsn = 'mysql:dbname=cdp; host=ip-10-0-1-12.ap-northeast-1.compute.internal; charset=utf8';
  $usr = 'root';
  $passwd = 'Tokissme?';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  return $db;
}