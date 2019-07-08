<html>
  <head>
    <link href="css/books.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class='books'>
      <center class='books-headerText'>Литература</center>
      <ul type='disk' class='books-spis'>
        <?php
          $books=file("content//books//books.txt");//считывание элекментов списка литературы по строкам файла
          //генерация элементов списка в html
          foreach ($books as $book)
          {
            echo "<li>".$book."</li>";//вставка в список
          }
        ?>
      </ul>
    </div>
  </body>
</html>
