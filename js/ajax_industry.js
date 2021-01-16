document.addEventListener('DOMContentLoaded', function() {
  var industries=document.querySelectorAll("input[name='industry[]']");
  for(var index=0;index < industries.length;index++){
    industries[index].addEventListener('change',function(){
      
      var ind_names =document.getElementsByName('industry[]');
        var comp_list=document.getElementById('comp_list');
        //初期化用の関数
        const clearNodes=()=>{
          while(comp_list.lastChild){
            comp_list.removeChild(comp_list.lastChild);
          } };
        
        var result={};　　//クエリ文字列生成用の連想配列        
       
        for(var i=0,len=ind_names.length;i<len;i++){
            var ind=ind_names.item(i);
            if(ind.checked){
               //連想配列用のキーを生成   
                if(ind.value==""){result['industry']=ind.value; break;}else{result[ind.value] = ind.value;
                    }  ; 
            }
        }  

        //連想配列result{}からクエリ文字列の生成
        var queryStr=Object.keys(result).map(key=>key + '=' +result[key]).join('&'); 
        if(queryStr=="" || queryStr== null){var queryStr='industry=none'}; //Industryのチェックボックスを外した場合の時のため
        
      //  console.log("queryStr= ",queryStr);
                      
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {               
              if (this.readyState==4 && this.status==200) {
                
                  clearNodes();                  
                  var data=JSON.parse(this.responseText); 
                 /*  console.log('data= ',data);
                  console.log('data length= ',data.length); */
              　　
                var frag = document.createDocumentFragment();  
              /*   var form = document.createElement('form');
                form.action = "../cdp3/test_result.php";
                form.method = 'POST'; */
                　var storage=sessionStorage;
                //storage.clear();
                  for(var i=0; i<data.length; i++){
                   
                    
                    var label=document.createElement('label');

                    var input=document.createElement('input');
                    input.setAttribute('type','checkbox');
                    input.setAttribute('value',data[i].company);
                    input.id=data[i].company_id;
                    console.log('data= ',data[i]);

                   // if(!storage[`company_${i}`]){storage[`company_${i}`] =input.value;};
                   if(!storage[`company_${input.id}`]){storage[`company_${input.id}`] =input.id;};
                   //input.setAttribute('checked',true);
                  if(!storage[`uc_company_${input.id}`]){ input.setAttribute('checked',true);};
                 

                    input.setAttribute('name','company[]');
                   
                    input.addEventListener('change',function(){
                      if(!input.checked){ 
                        delete storage[`company_${this.id}`];
                        storage[`uc_company_${this.id}`]=this.id;
                    }
                      else{
                        storage[`company_${this.id}`]=this.id;
                        if(storage[`uc_company_${this.id}`]){delete storage[`uc_company_${this.id}`];}
                      }
                    },false);
                    

                    label.appendChild(input)
                    var label_text=document.createTextNode(data[i].company+": ");
                    label.appendChild(label_text);
                   // form.appendChild(label);
                    frag.appendChild(label);
                    
                  
                  }
                
                  document.getElementById('comp_list').appendChild(frag); 
                                

              }
           
            }  
              xmlhttp.open('GET',`../cdp3/Model/getIndustry.php?${queryStr}`,true);              
              xmlhttp.send();
    });   
  };
},false);  

