
<!DOCTYPE html>
<html>
<head>
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form action="http://localhost/php_apps/cdp/register/account_out.php" method="post">
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

