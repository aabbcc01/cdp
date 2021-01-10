document.addEventListener('DOMContentLoaded', function() {
  var industries=document.querySelectorAll("input[name='industry']")
  for(var index=0;index < industries.length;index++){
    industries[index].addEventListener('change',function(){
    
       // var ind_options =document.getElementById('industry').options;
       var ind_names =document.getElementsByName('industry');
        var comp_list=document.getElementById('comp_list');
        //初期化用の関数
        const clearNodes=()=>{
          while(comp_list.lastChild){
            comp_list.removeChild(comp_list.lastChild);
          } };
        
        var result={};　　//クエリ文字列生成ようの連想配列
        for(var i=0,len=ind_names.length;i<len;i++){
            var ind=ind_names.item(i);
            if(ind.checked){
               //連想配列用のキーを生成   
                console.log('ind.value_1= ',ind.value); 
                if(ind.value==""){result['industry']=ind.value; break;}else{result[ind.value] = ind.value;
                    }  ; 
            }
        }  

        //連想配列result{}からクエリ文字列の生成
        var queryStr=Object.keys(result).map(key=>key + '=' +result[key]).join('&'); 
        if(queryStr=="" || queryStr== null){var queryStr='industry=none'} //Industryのチェックボックスを外した場合の時のため
        
        console.log("queryStr= ",queryStr);
                      
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                
              if (this.readyState==4 && this.status==200) {
                
                  clearNodes();
                  
                  var data=JSON.parse(this.responseText); 
                  console.log('data= ',data);
                  console.log('data length= ',data.length);
              　　
                var frag = document.createDocumentFragment();  
                  for(var i=0; i<data.length; i++){
                    var label=document.createElement('label');
                    var label_text=document.createTextNode(data[i].company);
                    label.appendChild(label_text);

                    var input=document.createElement('input');
                    input.setAttribute('type','checkbox');
                    input.setAttribute('checked',true);
                    input.value=data[i].company;
                    label.appendChild(input)
                    
                    frag.appendChild(label);
                  
                  }
                  document.getElementById('comp_list').appendChild(frag); 

              }
           
            }  
              xmlhttp.open('GET',`../cdp3/Model/MainRoutine.php?${queryStr}`,true);
             /*  var url=`http://localhost/php_apps/cdp3/Model/MainRoutine.php?${queryStr}`;
              xmlhttp.open('GET',url,true); */
              
              xmlhttp.send();
    });   
  };
},false);  

