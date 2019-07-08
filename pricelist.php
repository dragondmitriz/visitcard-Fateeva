<html>
<head>
  <link href='css/pricelist.css' type='text/css' rel='stylesheet'>
</head>
<body>
  <center>Прайс-лист</center>
  <div class='pricelist'>
    <?php
      //фунция считывания ячеек для строки таблицы из строки файлы
      function get_cells($str)
      {
        while(strlen($str)>2)
        {
          $str=mb_substr($str,mb_strpos($str,'"')+1);
          $cells[]=mb_substr($str,0,mb_strpos($str,'"'));
          $str=mb_substr($str,mb_strpos($str,'"')+1);
        }
        return $cells;
      }

      $pricelist=file('content/pricelist/pricelist.txt');//считываем строки прайслиста для генериуемой таблицы
      if (count($pricelist)>3)//если строк недостаточно для генерации полноценной таблицы, то таблица не генерируется
      {

        echo '<table class="pricelist-table">';//начало  таблицы
        $first=true;//идентификатор первой строки
        //генерация строк таблицы
        foreach($pricelist as $pricerow)//перебор строк файла прайслиста
        {
          $cells=get_cells($pricerow);//извлекаем из строки файла ячейки таблицы
          echo '<tr class="pricelist-tr">';//начало строки таблицы
          //добавление ячеек в строки таблицы
          foreach($cells as $cell)
            if ($first)
              echo '<th class="pricelist-th">'.$cell.'</th>';//заголовки, если первая строка
            else
              echo '<td class="pricelist-td">'.$cell.'</td>';//обычные ячейки, если не первая строка
            $first=false;
          echo '</tr>';//конец строки таблицы
        }
        echo '</table>';//конец  таблицы
      }
    ?>
  </div>
</bode>
</html>
