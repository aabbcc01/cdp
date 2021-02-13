
       
   // ページ内リンクのみ取得します。
  
   
   
   $(function() {

    $('a[href^="#"]').click(function(event){
        //デフォルトのイベントをキャンセル
        event.preventDefault();
     
        // 移動先となる要素を取得します。
        var target = $(this.hash);
     console.log('target= ',target);
   
        if (!target.length) return;
      
        // 移動先の位置を取得します
        var targetY = target.offset().top;
        
        // animateで移動します
        $('body').animate({scrollTop: targetY});
    });

       // スクロールしたときに実行
        $(window).scroll(function () {
          // 目的のスクロール量を設定(px)
          var TargetPos = 1000;
          // 現在のスクロール位置を取得
          var ScrollPos = $(window).scrollTop();
          // 現在位置が目的のスクロール量に達しているかどうかを判断
          if( ScrollPos >= TargetPos) {
             // 達していれば表示
             $("#topbutton").fadeIn();
          }
          else {
             // 達していなければ非表示
             $("#topbutton").fadeOut();
          }
       }); 

       
    

    });
