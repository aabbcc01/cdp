document.addEventListener('DOMContentLoaded', function() {

  var industries=document.querySelectorAll("input[name='industry[]']");
  var ind_names =document.getElementsByName('industry[]');
  var comp_list=document.getElementById('comp_list');
  const clearNodes=()=>{
      while(comp_list.lastChild){
        comp_list.removeChild(comp_list.lastChild);
      } };

  for(var index=0;index < industries.length;index++){
    industries[index].addEventListener('change',function(){
              var ind_checked=this.checked;
              var ind_value=this.value;
            
              
               var result={};　　//クエリ文字列生成用の連想配列        
              for(var i=0,len=ind_names.length;i<len;i++){
                  var ind=ind_names.item(i);
                  if(ind.checked){
                  //連想配列用のキーを生成   
                       if(ind.value==""){result['industry']=ind.value; break;}else{result[ind.value] = ind.value;
                          } ;  
                         

                  }
              }   

              //連想配列result{}からクエリ文字列の生成
               var queryStr=Object.keys(result).map(key=>key + '=' +result[key]).join('&'); 
              if(queryStr=="" || queryStr== null){var queryStr='industry=none'}; //Industryのチェックボックスを外した場合の時のため
              console.log('queryStr= ',queryStr); 
              var storage=sessionStorage;
             
              var xmlhttp=new XMLHttpRequest();
              xmlhttp.onreadystatechange=function() {               
                  if (this.readyState==4 && this.status==200) {
                      
                      clearNodes();  
                      var data= JSON.parse(this.responseText);
                      var d={}; 
                                             
                          if(ind_checked){      
                             
                             
                              var frag = document.createDocumentFragment(); 
                              for(var i=0; i<data.length; i++){
                               
                                  var label=document.createElement('label');

                                  var input=document.createElement('input');
                                  input.setAttribute('type','checkbox');
                                  input.setAttribute('value',data[i].company);
                                  input.setAttribute('industry',data[i].industry); //独自のindustry属性を用意しておく
                                  input.id=data[i].company_id;

                                  d['industry']=data[i].industry;
                                  d['company_id']=input.id;
                                  var ds= JSON.stringify(d);
                                  if(!storage[`company_${input.id}`]){storage[`company_${input.id}`] =ds;};
                                  var dp= JSON.parse(storage[`company_${input.id}`]);
                                  console.log('dp_compID= ',dp['company_id']);
                                
                                  if(dp['checked']===1 || dp['checked']==undefined){input.setAttribute('checked',true);}
                                                
                                  input.setAttribute('name','company[]');
                              
                                  input.addEventListener('change',function(){
                                      if(!this.checked){ 
                                      
                                           dp= JSON.parse(storage[`company_${this.id}`]);
                                          dp['checked']=0;
                                          storage[`company_${this.id}`]=JSON.stringify(dp);
                                         
                                      }
                                      else{

                                          dp= JSON.parse(storage[`company_${this.id}`]);
                                          dp['checked']=1;
                                          storage[`company_${this.id}`]=JSON.stringify(dp);
                                         
                                      
                                      }

                                  },false);
                                  

                                  label.appendChild(input)
                                  var label_text=document.createTextNode(data[i].company+": ");
                                  label.appendChild(label_text);
                              // form.appendChild(label);
                                  frag.appendChild(label);


                              }

                              document.getElementById('comp_list').appendChild(frag); 

                          }else{
                             console.log('yees');
                             console.log('yees2',comp_list.childElementCount);  
                              //要素の削除
                              for(var i=0; i<comp_list.childElementCount; i++){
                                
                                var compNode=comp_list.childNodes.item(i);
                                  
                                  console.log('ind_value= ',compNode.value);
                                  if(compNode.industry=ind_value){
                                   
                                      comp_list.removeChild(compNode);
                                    
                                     
                                  }
                              }
                                //ストレージの削除
                              for(var i=0; i< storage.length;i++){                                  

                                      var key =storage.key(i); //i番目のstorageのキー名を取得
                                      var dp=JSON.parse(storage[key]);
                                     if(dp['industry']=ind_value){
                                         delete storage[key];
                                     }
                              }
              
                          }
                  }                 
              }

              xmlhttp.open('GET',`../cdp3/Model/getIndustry.php?${queryStr}`,true);              
              xmlhttp.send();

    });   
  }
},false);  

