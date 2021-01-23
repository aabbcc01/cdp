document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('search_btn').addEventListener('click',function(){

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
      

    }); 

},false);  