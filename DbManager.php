<?php
function getDb() {
  $dsn = 'mysql:dbname=cdp; host=ec2-13-112-38-193.ap-northeast-1.compute.amazonaws.com; charset=utf8';
  $usr = 'root';
  $passwd = 'Tokissme?';

    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  return $db;
}