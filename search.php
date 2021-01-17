<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css">
    <script src="js/visible_c2.js"></script> 
    <script src="js/ajax_industry.js"></script> 
    <script src="js/search_btn.js"></script>
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
       
        <form action="./test_result.php" method="POST">

        <tr>
          <td>
            Year: <label><input type="checkbox" name="year[]" value="2020"/>2020</label>
                  <label><input type="checkbox" name="year[]" value="2019"/>2019</label>
          </td>
        </tr>

        <tr>
            <td>
              Industry : <br>
              <label><input type="checkbox" name="industry[]" id="ind_1" value="auto mobile"/>Auto mobile</label>
              <label><input type="checkbox" name="industry[]" id="ind_2"value="chemical"/>Chemical</label>
              <label><input type="checkbox" name="industry[]" id="ind_3" value="construction"/>Construction</label>
              <label><input type="checkbox" name="industry[]" id="ind_4" value="energy"/>Energy</label>
              <label><input type="checkbox" name="industry[]" id="ind_5" value="food/drink"/>Food/Drink</label>
            </td>
       </tr>
       
       
       <tr><td>  Company:<div id="comp_list"></div> </td></tr> 
      
       <tr>
        <td>
          <a href="#" id="chapter_href" ><font color="#FFFFFF">Chapter</font></a>
        </td>
      </tr>  
       <tr class="chapter">
          <td>
              Chapter : <br>
              <label><input type="checkbox" name="chapter[]" value="1"/>C0. Introduction</label>
              <label><input type="checkbox" name="chapter[]" value="2"/>C1. Governance</label>
              <label><input type="checkbox" name="chapter[]" value="3"/>C2. Risks and opportunities</label>
              <label><input type="checkbox" name="chapter[]" value="4"/>C2.3a</label>
              <label><input type="checkbox" name="chapter[]" value="5"/>C2.4a</label>
              <label><input type="checkbox" name="chapter[]" value="6"/>C3. Business Strategy</label>
              <label><input type="checkbox" name="chapter[]" value="7"/>C4. Targets and performance</label>
              <label><input type="checkbox" name="chapter[]" value="8"/>C5. Emissions methodology</label>
              <label><input type="checkbox" name="chapter[]" value="9"/>C6. Emissions data</label>
              <label><input type="checkbox" name="chapter[]" value="10"/>C7. Emissions breakdowns</label>
              <label><input type="checkbox" name="chapter[]" value="11"/>C8. Energy</label>
              <label><input type="checkbox" name="chapter[]" value="12"/>C9. Additional metrics</label>
              <label><input type="checkbox" name="chapter[]" value="13"/>C10. Verification</label>
              <label><input type="checkbox" name="chapter[]" value="14"/>C11. Carbon pricing</label>
              <label><input type="checkbox" name="chapter[]" value="15"/>C12. Engagement</label>
              <label><input type="checkbox" name="chapter[]" value="16"/>C14. Signoff</label>
              <label><input type="checkbox" name="chapter[]" value="17"/>C15. Signoff</label>
          </td>
      </tr> 

      <tr>
        <td>
          <a href="#" id="c2_href" ><font color="#FFFFFF">Specialized for C2.(Risk and Opp)</font></a>
        </td>
      </tr>  

      <tr class="cdp_c2">
         <td>
        Value Chain : <br>
            <label><input type="checkbox" name="value_chain[]" value="Upstream"/>Upstream</label>
            <label><input type="checkbox" name="value_chain[]" value="Direct operations"/>Direct operations</label>
            <label><input type="checkbox" name="value_chain[]" value="Downstream"/>Downstream</label>
        </td>
        </tr>

        <tr class="cdp_c2">
          <td>Draw chart<span><select name="chart">  
          <option value=""></option>
            <option value="by_company">Company</option>
            <option value="by_value_chain">Value chain</option>
            </select>
          </td>
        </tr> 


        <tr>
          <td style="white-space : nowrap;" ><input type="submit" value="Search" id="search_btn" class="btn" >
          </td>
        </tr> 
        
    </table>
   
    </form>
    
</div>


</body>
</html>