document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('search_btn').addEventListener('click',function(){
          
        var compsInStorage={};
        var storage=sessionStorage;
        const ds=(a)=>{
            return JSON.stringify(a);
        };
        var xmlhttp=new XMLHttpRequest();
        for(var i=0; i<storage.length; i++){
            var key=storage.key(i);
            var val = storage[key];
            
            var dp= JSON.parse(val);
                if(dp['checked']==1){
                    
                    compsInStorage[key]=ds(dp);
                }               

       } 
       
       storage['compsInStorage']=ds(compsInStorage);  

        /* xmlhttp.onreadystatechange=function() {               
            if (this.readyState==4 && this.status==200) {

                var data= JSON.parse(this.responseText);
                var div=document.getElementById('test');
                div.innterHTML=data;

            }
        } */

       /* var query={};　　//クエリ文字列生成用の連想配列                       
       for(var i=0 ; i<compsInStorage.length; i++){
        var ind=industries.item(i);
        if(ind.checked){
        //連想配列用のキーを生成   
            if(ind.value==""){query['industry']=ind.value; break;}else{query[ind.value] = ind.value;
                } ;  
        }
        }  */                
       //var queryStr=Object.keys(compsInStorage).map(key=>key + '=' +compsInStorage[key]).join('&'); 
       //var queryStr=Object.keys(compsInStorage).map(key=>key + '=' +compsInStorage[key]).join('&'); 
      // var xmlhttp=new XMLHttpRequest();
       //xmlhttp.open('GET',"../cdp3/test_result_2.php?q="+"test",true);   
       //xmlhttp.open('GET',"../cdp3/test_result_2.php?q="+queryStr,true);      
       //xmlhttp.open('GET',`../cdp3/test_result_2.php?${queryStr}`,true); 

      /* 
        xmlhttp.open('POST',"../cdp3/test_result_2.php",true);
       xmlhttp.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
       xmlhttp.send('comps='+"this is test");    */ 
 
        //xmlhttp.send('comps='+encodeURIComponent(ds(compsInStorage)));     
       
     /*      var form = document.createElement('form');
       form.action="../cdp3/test_result_2.php";
       form.method="POST";
       form.name="comps";
       form.value=ds(compsInStorage);
       document.body.append(form);
       form.submit();  */ 

      /*  var div = document.createElement('div');
    
       div.name="comps";
       div.value=ds(compsInStorage);
       var form_1=document.getElementById('form_1');
      form_1.appendChild(div);
      form_1.action="../cdp3/test_result_2.php";
       form_1.method="POST";
      form_1.submit(); */
      


/* 
      var form_1=document.getElementById('form_1');
       form_1.action="../cdp3/test_result_2.php";
       form_1.method="POST";
       form_1.name="comps2";
       form_1.value=ds(compsInStorage); 
       form_1.submit(); */

      /*  var comps=document.getElementById('comp_list');
       comps.name="comps_storage";
       comps.value=ds(compsInStorage); */
       document.getElementById('form_1').appendChild(comp_list);
    }); 

},false);  