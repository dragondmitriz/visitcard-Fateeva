<html>
  <head>
    <link href="css/gallery.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class='gallery'>
      <div class='gallery-images'>
        <div class='gallery-images-left'>
          <img class='gallery-images-leftImage'/>
        </div>
        <div class='gallery-images-main'>
          <img class='gallery-images-mainImage'/>
        </div>
        <div class='gallery-images-right'>
          <img class='gallery-images-rightImage'/>
        </div>
      </div>
      <center class='gallery-description'></center>
    </div>
    <script type="text/javascript" src="lib/JQuery/jquery-3.3.1.js"></script>
    <script type="text/javascript">
      var images=[];
      <?php
        $images=scandir('content//gallery');
        $i=0;
        foreach ($images as $image) {
          if (($image!=".")&&($image!=".."))
            echo 'images['.$i++."]='content//gallery//".iconv('windows-1251','utf-8',$image)."';\n";
        }
      ?>

      //логическая переменная для обозначения активности акнимации
      var activeAnimate;
      //универсальная функция перехода на выбранное изображение. В параметр передается символ "r" или "l" в соответсвии с выбранной стороной
      function gallery_change(RorL){
        if (!activeAnimate)
        {
          //фикс скролла, когда в портретном режиме скролл смещался вверх к галерее
          var currentScrollTop=$(document).scrollTop();
          //обозначаем, что анимация запущена
          activeAnimate=true;
          //смена индекса основного изображения в зависимости от направления
          var prevIndex, nextIndex;
          if (RorL=="l")
          {
            //левое направление
            prevIndex=selectedIndex;
            if (selectedIndex==0) selectedIndex=images.length-1; else selectedIndex--;
            if (selectedIndex==0) nextIndex=images.length-1; else nextIndex=selectedIndex-1;
            var duration="left";
          }
          else
          {
            //правое направление
            prevIndex=selectedIndex;
            if (selectedIndex==images.length-1) selectedIndex=0; else selectedIndex++;
            if (selectedIndex==images.length-1) nextIndex=0; else nextIndex=selectedIndex+1;
            var duration="right";
          }
          var $cloneMain=$('.gallery-images-main').clone();//создание копии элемента с основным изображением
          var $clone=$('.gallery-images-'+duration).clone();//содание копии элемента с изображением, указанного в параметрах направления
          //смена стиля копий, для расположения их над оригиналами
          $cloneMain.attr('class','gallery-images-mainAnimate');
          $cloneMain.css('left','calc(20% + 1vh)');
          $clone.attr('class','gallery-images-'+duration+'Animate');
          if (duration=="right") $clone.css('right','2vh'); else $clone.css('left','2vh');
          //добавление копий в струкутру сайта
          $('.gallery-images').prepend($clone);
          $('.gallery-images').prepend($cloneMain);
          //подготовка оригиналов перед анимацией
          $('.gallery-images-main').css('opacity','0');//невидимость для оригинала главной картинки для процесса анимации
          $('.gallery-images-main').children('.gallery-images-mainImage').attr('src',images[selectedIndex]);//смена изображения в оригинале основного изображения
          $('.gallery-images-'+duration).children('.gallery-images-'+duration+'Image').attr('src',images[nextIndex]);//смена изображения в оригинале побочного изображения, указанного в параметрах направления
          //анимация перехода основного изображения в побочное, указанного в параметрах направления
          if (duration=="right") $cloneMain.animate({left: '2.5vh', width: '19%'}, 400); else $cloneMain.animate({left: '79.7%', width: '19%'}, 400);
          $cloneMain.children('.gallery-images-mainImage').animate({'max-width': '80%', 'max-height': '40%'}, 400,function(){
            $('.gallery-images-main').css('opacity','1');//снятие невидимости с основного изображения
            $cloneMain.remove();//удаление копии основного изображения
          });
          //анимация ухода побочного изображения противоположного направлению, указанного в параметрах
          if (duration=="right") $('.gallery-images-left').children('.gallery-images-leftImage').animate({width: '0', height: '0'}, 400); else $('.gallery-images-right').children('.gallery-images-rightImage').animate({width: '0', height: '0'}, 400);
          //анимация прихода побочного изображения противоположного направлению, указанного в параметрах
          $('.gallery-images-'+duration).children('.gallery-images-'+duration+'Image').css({'max-height': '0','max-width': '0'});
          $('.gallery-images-'+duration).children('.gallery-images-'+duration+'Image').animate({'max-height': '40%','max-width': '80%'}, 400, function(){
            $('.gallery-images-'+duration).children('.gallery-images-'+duration+'Image').css({width: '', height: ''});//сброс изменений стиля при анимации
          });
          //анимация перехода побочного изображения, указанного в параметрах направления, в основное
          $clone.animate({left: '21%', width: '58%'}, 400, function(){
            //смена побочного изображения противоположного направлению, указнного в параметрах
            if (duration=="right")
            {
              $('.gallery-images-left').children('.gallery-images-leftImage').css({width: '', height: ''});//сброс изменений стиля при анимации
              $('.gallery-images-left').children('.gallery-images-leftImage').attr('src',images[prevIndex]);
            }
            else
            {
              $('.gallery-images-right').children('.gallery-images-rightImage').css({width: '', height: ''});//сброс изменений стиля при анимации
              $('.gallery-images-right').children('.gallery-images-rightImage').attr('src',images[prevIndex]);
            }
            $clone.remove();//удаление копии побочного изображения противоположного направлению, указнного в параметрах
            //обозначаем, что анимация закончена
            activeAnimate=false;
          });
          $clone.children('.gallery-images-'+duration+'Image').animate({'max-width': '100%', 'max-height': '100%'}, 400);
          $('.gallery-description').text(images[selectedIndex].substr(images[selectedIndex].lastIndexOf("/")+1,images[selectedIndex].lastIndexOf(".")-images[selectedIndex].lastIndexOf("/")-1));
          //фикс скролла, когда в портретном режиме скролл смещался вверх к галерее
          $(document).scrollTop(currentScrollTop);
        }
      }

      //индекс основного изображения
      var selectedIndex;

      $(document).ready(function(){
        selectedIndex=1;
        $('.gallery-images-leftImage').attr('src',images[selectedIndex-1]);
        $('.gallery-images-mainImage').attr('src',images[selectedIndex]);
        $('.gallery-images-rightImage').attr('src',images[selectedIndex+1]);
        $('.gallery-description').text(images[1].substr(images[selectedIndex].lastIndexOf("/")+1,images[selectedIndex].lastIndexOf(".")-images[selectedIndex].lastIndexOf("/")-1));
      });

      //Процесс листания изображений
      setInterval(function(){
        gallery_change("r");
      },3000);

      //действия при щелчке по правому изображению
      $('.gallery-images-rightImage').click(function(){
        gallery_change("r");
      });
      //действия при щелчке по левому изображению
      $('.gallery-images-leftImage').click(function(){
        gallery_change("l");
      });
    </script>
  </body>
</html>
