<?php
function verifyUser($s,$db){
  if(!isset($s['name']) || !isset($s['password'])){
    header("refresh:4; ../cdp/login.php");
     echo 'Invalid access. Redirect to login page in 4 seconds.';
     exit;
  }
    $userName=$s['name'];
    $userPass=$s['password'];

    $sql=$db->prepare('SELECT * FROM user where name=:name');
    $sql->bindvalue(':name',$userName,PDO::PARAM_STR);
    $sql->execute();
    $result=$sql->fetch(PDO::FETCH_ASSOC);
  
    //ユーザー登録がされていないか、パスワードが間違っている場合はログアウト
    if(!$result || !password_verify($userPass, $result['password'])){
      unset($_SESSION['user']['password']);
     /*  $_SESSION['user']['name']=$_POST['name']; */
/*    
      $_SESSION['user']['password']=$_POST['password']; */
      
     header("refresh:4; ../cdp/login.php");
     echo 'Fail. Redirect in 4 seconds.';
      exit;
    }else{
      return $result;
    }


}
    ?> 