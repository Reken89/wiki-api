<?php
# Нативный шаблон для представления
# HTML верстка и библиотеки css и jquery
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $pageData['title']; ?></title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css"> 
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
</head>
<body>
 
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Поиск</a></li>
    <li><a href="#tabs-2">Копирование статей</a></li>

  </ul>
  <div id="tabs-2">
    <form id="wiki-form" method="post">
        <input type="text" name="value" size="20">      
            <input type="button" id="wiki" value="Скопировать">
    </form>

      <p>Статьи скопированные с Википедии</p>
      
      <table>
<?php
foreach ($pageData['info'] as $key => $value) {
    echo "<tr>";
    echo "<td>" . $value['heading'] . "</td>";
    echo "</tr>";
}
?>
      </table>
          
          
  </div>
  <div id="tabs-1">
        <form id="wiki-form-search" method="post">
        <input type="text" name="search" size="20">      
            <input type="button" id="wiki-search" value="Поиск">
    </form>
      
      <p>Результаты поиска</p>
      <table>
          <tr><td>Статья</td><td>Совпадений</td><td></td></tr>
      <?php foreach ($pageData['search'] as $key => $value) {
          
          echo "<tr>";
          echo "<input type=hidden class='heading' value=" . $value['heading'] . ">";
          echo "<td>" . $value['heading'] . "</td>";
          echo "<td>" . $value['coincidence'] . "</td>";
          echo "<td><input type=button id='btn_1' value='Сведения'></td>";
          echo "</tr>";
      }
     
      ?>
      </table>
      
      <p>Содержание статьи</p>
<?php 

# Временный код
$route = explode("/", $_SERVER['REQUEST_URI']);
$route = str_replace(".php", "", $route);
print_r($route);

$content = $pageData['intelligence'];
?>
      <textarea rows='50' cols='100' type=text class='table_name'><?php echo $content['content']; ?></textarea>
  </div>

</div>
 
 
</body>
</html>
