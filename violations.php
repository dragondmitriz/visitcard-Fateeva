<html>
  <head>
    <link href="css/violations.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class='violations'>
      <?php
        //функция добавления разворачиваемого блока о нарушении
        function print_violation($violationName,$violationDescriprion,$violationCorrection)
        {
          echo '<div class=\'violation\'>';
          echo '<div class=\'violation-name\'>'.$violationName.'</div>';
          echo '<div class=\'violation-description\'>'.$violationDescriprion.'</div>';
          echo '<div class=\'violation-correction\'>'.'<p>Коррекция:</p>'.$violationCorrection.'</div>';
          echo '<div class=\'violation-slide\'>';
          echo '<div class=\'violation-slide-text\'>Подробнее:</div>';
          echo '<div class=\'violation-slide-iconShow\'></div>';
          echo '</div>';
          echo '</div>';
        }
        //генерация разворачиваемых блоков о нарушении
        $violations=scandir('content//violations');
        $count=0;
        foreach ($violations as $violation)
        {
          $len=strpos($violation, '.txt');
          if ($len!==false)
          {
            $file_content=file('content//violations//'.$violation);
            $violationName=mb_substr(iconv('windows-1251','utf-8',$violation),0,$len);
            $violationDescriprion=$file_content[0];
            $violationCorrection=$file_content[1];
            switch ($count)
            {
              case 0:
                echo '<div class=\'violations-row\'>';
                print_violation($violationName,$violationDescriprion,$violationCorrection);
                $count++;
                break;
              case 3:
                print_violation($violationName,$violationDescriprion,$violationCorrection);
                echo '</div>';
                $count=0;
                break;
              default:
                print_violation($violationName,$violationDescriprion,$violationCorrection);
                $count++;
                break;
            }
          }
        }
        if ($count!=0)
          echo '</div>';
      ?>
    </div>
    <script type="text/javascript" src="lib/JQuery/jquery-3.3.1.js"></script>
    <script type="text/javascript">
      var speedTime=1000;
      //сворачивание блока о нарушении
      function slideHide(selectedItem){
        var $parentRow=$(selectedItem).parent().parent();
        var $prev=$(selectedItem).parent().parent().prev();
        var $violationHidden=$parentRow.prev().children('#violation-hidden');
        $parentRow.slideUp(speedTime/2, function(){
          $parentRow.remove();
        });
        $violationHidden.show();
        $violationHidden.animate({width: '22vw', opacity: '1'},speedTime,function(){$violationHidden.attr('style','');});
        $violationHidden.height('auto');
        $violationHidden.attr('id','');
      };
      //разворачивание блока о нарушении
      $('.violation-slide').click(function(){
        slideHide($('.violation-selected').children('.violation-slide'));
        var $item=$(this).parent();
        var $clone=$item.clone();
        var $parentRow=$item.parent('.violations-row');
        $item.animate({width: '0px', height: '0px', opacity: '0'},speedTime,function(){
          $item.hide();
          $item.attr('id','violation-hidden');
        });
        $parentRow.after($('<div class=\'violations-row\' style=\'display: none\'></div>'));
        var $newRow=$parentRow.next();
        $newRow.append($clone);
        $clone.attr('class','violation-selected');
        $clone.children('.violation-description').show();
        $clone.children('.violation-correction').show();
        $clone.children('.violation-slide').children('.violation-slide-iconShow').attr('class','violation-slide-iconHide');
        $clone.children('.violation-slide').children('.violation-slide-text').text('Свернуть:');
        //сворачивание блока о нарушении
        $clone.children('.violation-slide').click(function(){
          slideHide($(this));
        });
        $newRow.slideDown(speedTime);
      });
    </script>
  </body>
</html>
