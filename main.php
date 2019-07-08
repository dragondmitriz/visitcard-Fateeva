<html>
  <head>
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class='main'>
      В логопедическом центре для детей и взрослых «Логопрогресс» осуществляется:
      <div class='main-scrollingBox'>
        <div class='main-scrollingBox-content'>
          <p class='main-scrollingBox-content-text'>
          </p>
        </div>
        <div class=main-scrollingBox-checkLine>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
          <div class='main-scrollingBox-checkLine-check'></div>
        </div>
      </div>
      <center>Запись по телефону: +7 985 663-94-15</center>
    </div>
    <script type="text/javascript" src="lib/JQuery/jquery-3.3.1.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.main-scrollingBox-checkLine-check:first').attr('class','main-scrollingBox-checkLine-checked');
        $('.main-scrollingBox-content-text').text(main[0]);
      });
      //Глобальные переменные текста для главной
      var main=[];
      <?php
        for($i=0;$i<10;$i++)
        {
          echo 'main['.$i.']=\''.str_replace(array("\r\n", "\r", "\n"),' ',file_get_contents('content//main//'.$i.'.txt')).'\';';
        }
      ?>
      //Функции для главой
      function main_changeCheck(indexItem, indexNextItem){
        $('.main-scrollingBox-content-text').animate({left: '-1vw', opacity: '0'},200,function(){
          $('.main-scrollingBox-content-text').css({left: '1vw'});
          $('.main-scrollingBox-content-text').text(main[indexNextItem]);
          $('.main-scrollingBox-content-text').animate({left: '0px', opacity: '1'},200);
        });
        var $item = $('.main-scrollingBox-checkLine').children().eq(indexItem);
        $item.attr('class','main-scrollingBox-checkLine-check');
        var $item = $('.main-scrollingBox-checkLine').children().eq(indexNextItem);
        $item.attr('class','main-scrollingBox-checkLine-checked');
      }
      //Процесс листания на главной
      setInterval(function(){
        var indexItem = $('.main-scrollingBox-checkLine-checked').index();
        var indexNextItem=0;
        if (indexItem == $('.main-scrollingBox-checkLine').children().length-1)
        {
          indexNextItem = 0;
        }
        else {
          indexNextItem = indexItem + 1;
        }
        main_changeCheck(indexItem,indexNextItem);
      },10000);
      //События на главной
      $('.main-scrollingBox-checkLine').children().click(function(){
        var indexItem = $('.main-scrollingBox-checkLine-checked').index();
        var indexNextItem=$(this).index();
        main_changeCheck(indexItem, indexNextItem);
      });
    </script>
  </body>
</html>
