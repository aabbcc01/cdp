<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css">
    <script src="js/visible_c2.js"></script> 
    <script src="js/ajax_industry.js"></script> 
</head>

<?php

/*
if($_SERVER["REQUEST_METHOD"] != "POST"){
	// ブラウザからHTMLページを要求された場合
	$no_login_url = "index.php";

		echo 'Oops! invalid access is detected!  ';
	    //header("Location: {$no_login_url}");
	    exit;
} */
//require './header.php'; 
require_once './DbManager.php';
require_once './Encode.php';
?>
<body>
<?php

    $db=getDb();
    $userName=strval(e($_POST['name']));
    $userPass=strval(e($_REQUEST['password']));
    //$sql=$db->prepare('SELECT * FROM users WHERE name=:name and password=:password');
    $sql=$db->prepare('SELECT * FROM user where name=:name and password=:password');
    
    $sql->bindvalue(':name',$userName,PDO::PARAM_STR);
    
    $sql->bindValue(':password',$userPass,PDO::PARAM_STR);
   
    $sql->execute();

if(!$result=$sql->fetch(PDO::FETCH_ASSOC)){
  header('Location:http://localhost/php_apps/cdp3/login.html'); //ログイン画面にリダイレクト
    exit;}
    ?> 

<div class ="ph_style2">
<img src="img/2-1.png"  class="ph2">
    <table frame="void">
     
        <tr><td><p>Search</p></td></tr>
       
           <!-- <form action="./search-output.php" method="post"> -->
        <form>

        <tr>
          <td>
          Year <span><select name="year">  
                  <option value=""></option>
                  <option value="2020">2020</option>
                  <option value="2019">2019</option>
              </span>
          </td>
        </tr>

        <tr class="multiple">
        <td>
              Industry : <br>
              <label><input type="checkbox" name="industry" value="auto mobile"/>Auto mobile</label>
              <label><input type="checkbox" name="industry" value="chemical"/>Chemical</label>
              <label><input type="checkbox" name="industry" value="construction"/>Construction</label>
              <label><input type="checkbox" name="industry" value="energy"/>Energy</label>
              <label><input type="checkbox" name="industry" value="food/drink"/>Food/Drink</label>
             
            </td>
       </tr>
       
       <tr><td>  Company:<div id="comp_list"></div> </td></tr>
       
       <tr class="multiple">
           <td > Chapter<span><select name="chapter"  multiple>
              <option value=""></option>
              <option value="1">C0. Introduction</option>
              <option value="2">C1. Governance</option>
              <option value="3">C2. Risks and opportunities</option>
              <option value="16">C2.3a</option>
              <option value="17">C2.4a</option>
              <option value="4">C3. Business Strategy</option>
              <option value="5">C4. Targets and performance</option>
              <option value="6">C5. Emissions methodology</option>
              <option value="7">C6. Emissions data</option>
              <option value="8">C7. Emissions breakdowns</option>
              <option value="9">C8. Energy</option>
              <option value="10">C9. Additional metrics</option>
              <option value="11">C10. Verification</option>
              <option value="12">C11. Carbon pricing</option>
              <option value="13">C12. Engagement</option>
              <option value="14">C14. Signoff</option>
              <option value="15">C15. Signoff</option>
           </select>
          </td>
      </tr> 

      <tr>
        <td>
          <a href="#" id="visible_C2_href" ><font color="#FFFFFF">Specialized for C2.(Risk and Opp)</font></a>
        </td>
      </tr>  
      <tr class="cdp_c2">
         <td>
        Value Chain<span><select name="value_chain">  
            <option value=""></option>
            <option value="Upstream">Upstream</option>
            <option value="Direct operations">Direct operations</option>
            <option value="Downstream">Downstream</option>
            <option value="Please select">Please select</option>
        </select>
        </span>
        </td>
        </tr>

        <tr class="cdp_c2">
          <td>Draw chart<span><select name="value_chain">  
          <option value=""></option>
            <option value="company">Company</option>
            <option value="value_chain">Value chain</option>
            </select>
          </td>
        </tr>

      <!-- <tr>
        <td>
          <a href="http://localhost/php_apps/cdp3/specialized.php">Sepecialized for C2.(Risk and Opp)</a>
        </td>
      </tr> -->

       <tr>
          <td style="white-space : nowrap;" ><input type="submit" value="Search" id="search_btn" class="btn" >
            <!-- <span style="margin-left: 270px; font-size:15px;"> Draw Charts</span>
            <input type="checkbox" name="charts" class="cbox_chart"> -->
          </td>
        </tr> 
        
    </table>
   
    </form>
    
</div>


</body>
</html>