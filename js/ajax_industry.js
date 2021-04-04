document.addEventListener('DOMContentLoaded', function() {

  var industries=document.querySelectorAll("input[name='industry[]']");
  var comp_list=document.getElementById('comp_list');
  const clearNodes=()=>{ 
      while(comp_list.lastChild){
        comp_list.removeChild(comp_list.lastChild);
      } };
  var storage=sessionStorage;
  const converter=(indtype)=>{
    if(indtype==1){
      return 'Auto mobile ';
    }else if(indtype==2){
      return 'Chemical ';
    }else if(indtype==3){
      return 'Construction ';
    }
  };
  const caseNotfound=(ind_value)=>{
    /* if(typeof ind_value=="undefined"){return;} */
    var text=document.createTextNode(converter(ind_value)+'Not found');
    var div =document.createElement('div');

    div.setAttribute('id','div_'+ind_value);
    div.appendChild(text);
    comp_list.appendChild(div);
  };

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
                          
                          if(data.length===0){
                           
                              caseNotfound(ind_value);
                          }
                         
                          var d={}; 
                          var frag = document.createDocumentFragment(); 
                          var div= document.createElement('div');
                              div.setAttribute('id',ind_value);
                          
                          for(var i=0; i<data.length; i++){
                       
                              console.log('data= ',data);
                              var label=document.createElement('label');
                              label.setAttribute('data-industry',data[i].ind_id); //独自のindustry属性を用意しておく
                             // label.setAttribute('name','comp_id[]');
                              var input=document.createElement('input');
                              input.setAttribute('type','checkbox');
                              input.setAttribute('name',"comp_id[]");
                              input.setAttribute('value',data[i].company_id);
                              input.setAttribute('data-industry',data[i].ind_id); //独自のindustry属性を用意しておく
                              console.log('ind_value= ',ind_value);
                              input.id='company_'+data[i].company_id;

                              d['industry']=data[i].ind_id;
                              d['company_id']=data[i].company_id;

                              var ds= JSON.stringify(d);
                              if(!storage[input.id]){storage[input.id] =ds;};
                              var dp= JSON.parse(storage[input.id]);
                            
                              if(storage[input.id] || dp['checked']===1 || dp['checked']==undefined){
                                  input.setAttribute('checked',1);
                                  dp['checked']=1;
                                  storage[input.id]=JSON.stringify(dp);
                               } 

                              input.addEventListener('change',function(){
                                
                                      if(storage[`company_${this.id}`]){
                                        
                                          dp= JSON.parse(storage[`company_${this.id}`]);
                                          dp['checked']=this.checked;
                                          storage[`company_${this.id}`]=JSON.stringify(dp);
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

                  xmlhttp.open('GET',`../cdp/Model/getIndustry.php?${queryStr}`,true);              
                  xmlhttp.send();

              }
              //industryボックスのチェックが外された場合の処理。
              else{
                
                // not foundの削除
                if(document.getElementById('div_'+ind_value)){
                  document.getElementById('div_'+ind_value).remove();
                }
                     //チェックがはずされたindustryに応じてcompanyのチェックボックスを削除 。
                     var divNode=document.getElementById(ind_value);
                     if(divNode){
                      if(ind_value==divNode.getAttribute('id')){ 
                        divNode.remove();
                      }
                    }

                     //ストレージの削除用の関数
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
    var form=document.getElementById('form_1');
    form.appendChild(comp_list);
    form.submit();
    location.reload();
    /* location=location; */
  });  

},false);  

