document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search_btn').addEventListener('click', function() {
      var result = document.getElementById('company_list');
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            result.textContent = xhr.responseText;
          } else {
            result.textContent = 'サーバーエラーが発生しました。';
          }
        } else {
          result.textContent = '通信中...';
        }
      };
      /*
      xhr.addEventListener('loadstart', function() {
        result.textContent = '通信中...';
      }, false);
  
      xhr.addEventListener('load', function() {
        result.textContent = xhr.responseText;
      }, false);
  
      xhr.addEventListener('error', function() {
        result.textContent = 'サーバーエラーが発生しました。';
      }, false);
      */
      xhr.open('POST', 'ajax_test.php', true);
      xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
      xhr.send('comp-name'+encodeURIComponent(document.getElementById('comp-name').value));
     
    }, false);
  }, false);