document.addEventListener('DOMContentLoaded', function() {
    
    var cdp_c2=document.getElementsByClassName('cdp_c2');
    console.log('cdp_c2_from Js file .len= ',cdp_c2.length);
    
    for(var i=0,len=cdp_c2.length;i<len ; i++){
        cdp_c2[i].style.display='none';
        
    }  

    document.getElementById('visible_C2_href').addEventListener('click',function(e){
        e.preventDefault(); 
 
        for(var i=0,len=cdp_c2.length;i<len ; i++){
            cdp_c2[i].style.display= ( cdp_c2[i].style.display)? '':'none';
        }  
    
    });

},false);  

