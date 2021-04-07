<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
<div id="registrant">
<ul >
    <form action="search.php" method="post">
       <input type="text" name="name" placeholder="Name" value="<?php if(isset($_SESSION['user']['name']))
        {echo $_SESSION['user']['name'];};?>"><br> 
        <input type="password" placeholder="Password" name="password" ><br>
        <!-- <input type="submit" value="Login"> -->
        <input type="image" id="btn1" src="img/btn1.png" alt="Login">
</ul>
</div>
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