<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

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

    <table  frame="void" id="interface">
     
        <tr><td><p>Search</p></td></tr>
       
        <form action="./branch.php" target="_blank" method="GET" id="form_1"> 
      
        <tr>
          <td>
            Year: <label><input type="checkbox" name="year[]" value="2020"/>2020</label>
                  <label><input type="checkbox" name="year[]" value="2019"/>2019</label>
          </td>
        </tr>

        <tr>
            <td>
              Industry : <br>
              <label><input type="checkbox" name="industry[]" id="ind_1" value="1"/>Auto mobile</label>
              <label><input type="checkbox" name="industry[]" id="ind_2"value="2"/>Chemical</label>
              <label><input type="checkbox" name="industry[]" id="ind_3" value="3"/>Construction</label>
              <label><input type="checkbox" name="industry[]" id="ind_4" value="4"/>Energy</label>
              <label><input type="checkbox" name="industry[]" id="ind_5" value="5"/>Food/Drink</label>
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
              <div>
              <label><input type="checkbox" name="chapter[]" value="1"/>C0. Introduction</label>
              <label><input type="checkbox" name="chapter[]" value="2"/>C1. Governance</label>
              <label><input type="checkbox" name="chapter[]" value="3"/>C2. Risks and opportunities</label>
              <label><input type="checkbox" name="chapter[]" value="5"/>C2.3a</label>
              <label><input type="checkbox" name="chapter[]" value="7"/>C2.4a</label>
              <label><input type="checkbox" name="chapter[]" value="10"/>C3. Business Strategy</label>
              <label><input type="checkbox" name="chapter[]" value="11"/>C4. Targets and performance</label>
              <label><input type="checkbox" name="chapter[]" value="12"/>C5. Emissions methodology</label>
              </div>
              <div>
              <label><input type="checkbox" name="chapter[]" value="13"/>C6. Emissions data</label>
              <label><input type="checkbox" name="chapter[]" value="14"/>C7. Emissions breakdowns</label>
              <label><input type="checkbox" name="chapter[]" value="151"/>C8. Energy</label>
              <label><input type="checkbox" name="chapter[]" value="16"/>C9. Additional metrics</label>
              <label><input type="checkbox" name="chapter[]" value="17"/>C10. Verification</label>
              <label><input type="checkbox" name="chapter[]" value="18"/>C11. Carbon pricing</label>
              <label><input type="checkbox" name="chapter[]" value="19"/>C12. Engagement</label>
              <label><input type="checkbox" name="chapter[]" value="20"/>C14. Signoff</label>
              <label><input type="checkbox" name="chapter[]" value="21"/>C15. Signoff</label>
              </div>
          </td>
      </tr> 
      <tr>
        <td>
          <a href="#" id="q_href" ><font color="#FFFFFF">Question</font></a>
        </td>
      </tr>  

      <tr class="question">
      <td> 
        <div>
        <label><input type="checkbox" name="question[]" value="1"/>(C1.2) Provide the highest management-level position(s) or committee(s) with responsibility for climate-related issues.</label>
        <label><input type="checkbox" name="question[]" value="2"/>(C2.2a) Which risk types are considered in your organization's climate-related risk assessments?</label>
        </div>
        <label><input type="checkbox" name="question[]" value="3"/>Value chain stage(s) covered</label>
        <div>
        <label><input type="checkbox" name="question[]" value="4"/>Identifier</label>
        <label><input type="checkbox" name="question[]" value="5"/>Where in the value chain does the risk driver occur?</label>
        <label><input type="checkbox" name="question[]" value="6"/>Risk type & Primary climate-related risk driver</label>
        <label><input type="checkbox" name="question[]" value="7"/>Primary potential financial impact</label>
        <label><input type="checkbox" name="question[]" value="8"/>Climate risk type mapped to traditional financial services industry risk classification</label>
        <label><input type="checkbox" name="question[]" value="9"/>Company-specific description</label>
        <label><input type="checkbox" name="question[]" value="10"/>Time horizon</label>
        <label><input type="checkbox" name="question[]" value="11"/>Likelihood</label>
        <label><input type="checkbox" name="question[]" value="12"/>Magnitude of impact</label>
        <label><input type="checkbox" name="question[]" value="13"/>Are you able to provide a potential financial impact figure?</label>
        <label><input type="checkbox" name="question[]" value="14"/>Potential financial impact figure (currency)</label>
        <label><input type="checkbox" name="question[]" value="15"/>Potential financial impact figure – minimum (currency)</label>
        <label><input type="checkbox" name="question[]" value="16"/>Potential financial impact figure – maximum (currency)</label>
        <label><input type="checkbox" name="question[]" value="17"/>Explanation of financial impact figure</label>
        <label><input type="checkbox" name="question[]" value="18"/>Cost of response to risk</label>
        <label><input type="checkbox" name="question[]" value="19"/>Description of response and explanation of cost calculation</label>
        <label><input type="checkbox" name="question[]" value="20"/>Where in the value chain does the opportunity occur?</label>
        </div>
        <div>
        <label><input type="checkbox" name="question[]" value="21"/>Opportunity type</label>
        <label><input type="checkbox" name="question[]" value="22"/>Primary climate-related opportunity driver</label>
        <label><input type="checkbox" name="question[]" value="23"/>Cost to realize opportunity</label>
        <label><input type="checkbox" name="question[]" value="24"/>Strategy to realize opportunity and explanation of cost calculation</label>
        </div>
        <label><input type="checkbox" name="question[]" value="30"/>C3.1</label>
        <label><input type="checkbox" name="question[]" value="25"/>(C3.1a) Does your organization use climate-related scenario analysis to inform its strategy?</label>
        <label><input type="checkbox" name="question[]" value="26"/>(C3.1b) Provide details of your organization’s use of climate-related scenario analysis.</label>
        <label><input type="checkbox" name="question[]" value="27"/>(C3.1d) Describe where and how climate-related risks and opportunities have influenced your strategy.</label>
        <label><input type="checkbox" name="question[]" value="28"/>(C3.1f) Provide any additional information on how climate-related risks and opportunities have influenced your strategy and financial planning (optional).</label>
        
        <label><input type="checkbox" name="question[]" value="31"/>(C3.1d) Provide details of your organization’s use of climate-related scenario analysis.</label>
        <label><input type="checkbox" name="question[]" value="32"/>C3.1c</label>
        <label><input type="checkbox" name="question[]" value="33"/>C3.1a</label>
        <div>
        <label><input type="checkbox" name="question[]" value="29"/>(C4.3c) What methods do you use to drive investment in emissions reduction activities?</label>
        </div>
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
                <label><input type="checkbox" name="value_chain[]" value="1"/>Upstream/Supply chain</label>
                <label><input type="checkbox" name="value_chain[]" value="2"/>Direct operations</label>
                <label><input type="checkbox" name="value_chain[]" value="3"/>Downstream/Customer</label>
                <label><input type="checkbox" name="value_chain[]" value="4"/>Investment Chain</label>
                <label><input type="checkbox" name="value_chain[]" value="5"/>Please select</label>
            </td>
          </tr>

          <tr class="cdp_c2">
              <td>Draw chart<span><select name="chart">  
              <option value=""></option>
                <option value="1">Company</option>
                <option value="2">Value chain</option>
                </select>
              </td>
          </tr> 

          <tr>
          <td style="white-space : nowrap;" ><input type="button" value="Search" id="search_btn" class="btn" ></td>
        </tr> 

        </form>
        
    </table>
   
   
</div>


</body>
</html>