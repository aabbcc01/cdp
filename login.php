<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <form action="search.php" method="post">
        ユーザー <input type="text" name="name" value="<?php if(isset($_SESSION['user']['name']))
        {echo $_SESSION['user']['name'];};?>"><br> 
        パスワード <input type="password" name="password" ><br>
        <input type="submit" value="ログイン">
    </form>

    <div class ="ph_style1">
        <img src="img/cape-banner.jpg"  class="ph1">
        <p>We focus investors, companies and cities <br>
            on taking urgent action to build a truly <br>
            sustainable economy by measuring and <br>
            understanding their environmental impact
        </p>
    </div>
</body>
</html>