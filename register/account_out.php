
<?php
require_once '../DbManager.php';
require_once '../Encode.php';
require_once '../Function/verifyUser.php';

$db=getDb();

if(isset($_POST['name'])){
    $sql = $db->prepare('SELECT name,password FROM user WHERE name=:name');
    $sql->bindValue(':name',e($_POST['name']));
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
   
    if($result){
    print '"'.$_POST['name'].'" has been already used ';
   /*  foreach($resul){
        if(password_verify($_POST['pass'], $value['password'])){
            echo 'found ','<br>';
            break;
        }
    } */
    }else{

        try{
       
            
        $sql = $db->prepare('INSERT INTO user (name,password,per_key) VALUES (:name,:password,:per_key)');
    
        if(isset($_POST['name'])){
            $sql->bindValue(':name',e($_POST['name']));
        }
        if($_POST['pass']){
            $sql->bindValue(':password',password_hash($_POST['pass'], PASSWORD_DEFAULT));
        }
        if($_POST['key']){
            $sql->bindValue(':per_key',$_POST['key']);
        }
        $sql->execute();
        echo 'Successfully registered';
    
        }catch(Exception $e){
        echo 'fail : reason -> ',$e->getMessage();
        }
    }


}


?>


