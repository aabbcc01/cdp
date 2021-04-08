<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

<div id="entrance">
        <img src="img/cape-banner.jpg"  class="entrance">
        <div id="registrant">

            <form action="search.php" method="post">
            
                    <input type="text" name="name" placeholder="Name" value="<?php if(isset($_SESSION['user']['name']))
                    {echo $_SESSION['user']['name'];};?>">
                    <input type="password" placeholder="Password" name="password" >
                    <input type="image" id="btn1" src="img/btn1.png" alt="Login">
            </form>
            <div class="claer"></div>

        </div>
        
        <p class="text">We focus investors, companies and cities <br>
           &nbsp on taking urgent action to build a truly <br>
            sustainable economy by measuring and <br>
            understanding their environmental impact
        </p>
       
</div>



</body>
</html>