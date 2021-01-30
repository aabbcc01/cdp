document.addEventListener('DOMContentLoaded', function() {

  var industries=document.querySelectorAll("input[name='industry[]']");
  var comp_list=document.getElementById('comp_list');
  const clearNodes=()=>{ 
      while(comp_list.lastChild){
        comp_list.removeChild(comp_list.lastChild);
      } };
  var storage=sessionStorage;

  for(var index=0;index < industries.length;index++){
    industries[index].addEventListener('change',function(){
              var ind_checked=this.checked;
              var ind_value=this.value;
              
              if(ind_checked){

                  var query={};　　//クエリ文字列生成用の連想配列                       

                  for(var i=0 ; i<industries.length; i++){
                    var ind=industries.item(i);
                    if(ind.checked){
                    //連想配列用のキーを生成   
                        if(ind.value==""){query['industry']=ind.value; break;}else{query[ind.value] = ind.value;
                            } ;  
                    }
                }
              
                  //連想配列query{}からクエリ文字列の生成
                  var queryStr=Object.keys(query).map(key=>key + '=' +query[key]).join('&'); 
                  if(queryStr=="" || queryStr== null){var queryStr='industry=none'}; //Industryのチェックボックスを外した場合の時のため
                  console.log('queryStr= ',queryStr); 

                  var xmlhttp=new XMLHttpRequest();
                   xmlhttp.onreadystatechange=function() {               
                      if (this.readyState==4 && this.status==200) {

                          var data= JSON.parse(this.responseText);
                          var d={}; 
                          var frag = document.createDocumentFragment(); 
                          var div= document.createElement('div');
                              div.setAttribute('id',ind_value);
                          
                          for(var i=0; i<data.length; i++){
                                
                              var label=document.createElement('label');
                              label.setAttribute('data-industry',data[i].industry); //独自のindustry属性を用意しておく
                             // label.setAttribute('name','comp_id[]');
                              var input=document.createElement('input');
                              input.setAttribute('type','checkbox');
                              input.setAttribute('name',"comp_id[]");
                              input.setAttribute('value',data[i].company_id);
                              input.setAttribute('data-industry',data[i].industry); //独自のindustry属性を用意しておく
                            
                              input.id='company_'+data[i].company_id;

                              d['industry']=data[i].industry;
                              d['company_id']=data[i].company_id;

                              var ds= JSON.stringify(d);
                              if(!storage[input.id]){storage[input.id] =ds;};
                              var dp= JSON.parse(storage[input.id]);
                            
                              if(storage[input.id] || dp['checked']===1 || dp['checked']==undefined){
                                  input.setAttribute('checked',true);
                                  dp['checked']=1;
                                  storage[input.id]=JSON.stringify(dp);
                               } 

                              input.addEventListener('change',function(){
                                  if(!this.checked){ 
                                  
                                      if(storage[`company_${this.id}`]){
                                        
                                          dp= JSON.parse(storage[`company_${this.id}`]);
                                          dp['checked']=0;
                                          storage[`company_${this.id}`]=JSON.stringify(dp);
                                    }

                                  }
                                  else{
                                      
                                      if(storage[`company_${this.id}`]){

                                          dp= JSON.parse(storage[`company_${this.id}`]);
                                          dp['checked']=1;
                                          storage[`company_${this.id}`]=JSON.stringify(dp);
                                      }
                                      
                                  }

                              },false);
                              
                              label.appendChild(input)
                              var label_text=document.createTextNode(data[i].company+" ");
                              label.appendChild(label_text);
                              
                              //divのidにはindustryタイプが入っている。divのindustryと一致しているlabel要素のみdivに格納するようにする.
                              if(div.id==label.getAttribute('data-industry')){div.appendChild(label);}
                              
                          }
                         
                          comp_list.appendChild(div);
                          

                      }

                  }

                  xmlhttp.open('GET',`../cdp3/Model/getIndustry.php?${queryStr}`,true);              
                  xmlhttp.send();

              }
              //industryボックスのチェックが外された場合の処理。
              else{
                     //チェックがはずされたindustryに応じてcompanyのチェックボックスを削除 。
                     var divNode=document.getElementById(ind_value);
                     if(divNode){
                      if(ind_value==divNode.getAttribute('id')){ 
                        divNode.remove();
                      }
                    }

                     //ストレージの削除
                     const delSto=()=>{
                      for(var i=0; i<storage.length;i++){  
                          var key =storage.key(i); //i番目のstorageのキー名を取得
                          var dp=JSON.parse(storage[key]);
                          if(dp['industry']==ind_value){
                         
                            delete storage[key];
                          }
                       }

                     };

                     var t=0;
                     var len=storage.length;
                     do {delSto(); t++;}while(t<=len); //繰り返しの回数がストレージの数と同数になるまで繰り返す。

              }
                              
    });   
  }
   // 動的に作成した要素をフォームに追加。追加しないとサーバーに値が送られない。
   document.getElementById('search_btn').addEventListener('click',function(){
    document.getElementById('form_1').appendChild(comp_list);
  }); 

},false);  

