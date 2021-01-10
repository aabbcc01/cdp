document.addEventListener('DOMContentLoaded', function() {
    
    var chapter=document.getElementsByClassName('chapter');
    chapter[0].style.display='none';
    
    var cdp_c2=document.getElementsByClassName('cdp_c2');
    
    for(var i=0,len=cdp_c2.length;i<len ; i++){
        cdp_c2[i].style.display='none';
    }  

    document.getElementById('chapter_href').addEventListener('click',function(e){
        e.preventDefault();
        chapter[0].style.display=(chapter[0].style.display)?'':'none';
    });


    document.getElementById('c2_href').addEventListener('click',function(e){
        e.preventDefault(); 
        for(var i=0,len=cdp_c2.length;i<len ; i++){
            cdp_c2[i].style.display= ( cdp_c2[i].style.display)? '':'none';
        }      
    }); 

    



},false);  

