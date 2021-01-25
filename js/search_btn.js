document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('search_btn2').addEventListener('click',function(){

        var compsInStorage={};
        var storage=sessionStorage;
        const ds=(a)=>{
            return JSON.stringify(a);
        };
        

        for(var i=0; i<storage.length; i++){
            var key=storage.key(i);
            var val = storage[key];
            dp= JSON.parse(val);

            if(dp['checked']==1){
                
                compsInStorage[key]=ds(dp);
            }
            
       } 
         
       storage['compsInStorage']=ds(compsInStorage);  

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
       var xmlhttp=new XMLHttpRequest();
       //xmlhttp.open('GET',"../cdp3/test_result_2.php?q="+"test",true);   
       //xmlhttp.open('GET',"../cdp3/test_result_2.php?q="+queryStr,true);      
       //xmlhttp.open('GET',`../cdp3/test_result_2.php?${queryStr}`,true);         
       xmlhttp.open('POST',"../cdp3/test_result_2.php",true);
       xmlhttp.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
       //xmlhttp.send('comps='+encodeURIComponent(ds(compsInStorage)));     
       xmlhttp.send('comps='+ds(compsInStorage));     
       
      
      
    }); 

},false);  