<?php
    session_start();
    require_once '../DbManager.php';
    require_once '../Encode.php';
    require_once '../Function/verifyUser.php';
    verifyUser($_SESSION['user'],getDb());
?>

<!DOCTYPE html>
<html>
<head>
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form action="http://localhost/php_apps/test/cdp3/register/account_out.php" method="post">
        <p> ユーザー名とパスワードが共に既に登録されているものと一致するものは不可</p>
        <p>
            <label>Name：</label>
            <input type="text" name="name">
        </p>

        <p>
            <label>Password：</label>
            <input type="text" name="pass">
        </p>
        <p>
            <label>permission key：</label>
            <input type="text" name="key">
        </p>

        <input type="submit" name="submit" value="登録する">
    </form>

</body>
</html>

