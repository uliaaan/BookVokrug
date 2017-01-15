<? include ('header.php') ?>
    <div class="main">
        <div class="section">
        <div class="container tim-container">
                <!-- ГОРОДА -->
<div class="col-md-6">
    <?
    //Добавление города в сессию и редирект на главную
    $rcity = isset($_POST['rcity'])?$_POST['rcity']:NULL;
    if($rcity && $rcity !== 0)
    {
      $res = $connect->query('SELECT * FROM rcity WHERE id='.(int)$_POST['rcity'].' LIMIT 1');
      $row = mysqli_fetch_assoc($res);
      $_SESSION['usercity'] = $row['Name'];
        if ($rcity !== 0) {
            header ('Location: /');
        }
    }

    //Постоянные ссылки
    if (isset($_GET['allcitys'])) {
        $_SESSION['usercity'] = $allcitys;
        header("Location: /");
    } else if (isset($_GET['ufa'])) {
        $_SESSION['usercity'] = "Уфа";
        header("Location: /");
    } else if (isset($_GET['moscow'])) {
        $_SESSION['usercity'] = "Москва";
        header("Location: /");
    } else if (isset($_GET['sankt-peterburg'])) {
        $_SESSION['usercity'] = "Санкт-Петербург";
        header("Location: /");
    }


    function is_sel($a, $field)
    {
      $b = isset($_POST[$field])?$_POST[$field]:NULL;
      if($a == $b) return 'selected="selected"';
    }



    $res = $connect->query('SELECT * FROM rdistrict');
    ?>
    <form id="frm" method="post">
    <select class="dropdown-toggle btn cityslinks-select" name="rdistrict" onchange="document.getElementById('frm').submit()" >
    <option value='null'>- Выберите округ -</option>
    <?
    // выводим все строки из столбца name таблицы rdistrict
        while($row = mysqli_fetch_assoc($res))
        echo "<option ".is_sel($row['ID'],'rdistrict')." value='" . $row['ID'] . "'>" . $row['Name'] . "</option>\r\n";
        echo "</select>";

    if(isset($_POST['rdistrict']))
    {
      $res = $connect->query('SELECT * FROM rregion WHERE District = "'.$connect->real_escape_string($_POST['rdistrict']).'"');

      if(mysqli_num_rows($res)){

      echo "<br><select class='dropdown-toggle btn cityslinks-select' name=\"rregion\" onchange=\" document.getElementById('frm').submit();\" >
        <option  id=\"rregion\" value='0'>- Выберите область -</option>";

        while($row = mysqli_fetch_assoc($res))
          echo "<option ".is_sel($row['ID'],'rregion')." value='" . $row['ID'] . "'>" . $row['Name'] . "</option>\r\n";

      echo "</select>";

      }else{ // выбираю города без учета региона

      $res = $connect->query('SELECT * FROM rcity WHERE Region = '.$connect->real_escape_string($_POST['rdistrict']));

      echo "<br><select class='dropdown-toggle btn cityslinks-select' id=\"rcity\" name=\"rcity\" onchange=\"document.getElementById('frm').submit()\" >
        <option  value='0'>- Выберите город -</option>";

        while($row = mysqli_fetch_assoc($res))
          echo "<option ".is_sel($row['ID'],'rcity')." value='" . $row['ID'] . "'>" . $row['Name'] . "</option>\r\n";

      echo "</select>";

      }

    }

    $rregion = isset($_POST['rregion'])?$_POST['rregion']:NULL;
    if($rregion && $rregion !== 0)
    {
      $res = $connect->query('SELECT * FROM rcity WHERE Region = '.(int)$_POST['rregion']);

      echo "<br><select class='dropdown-toggle btn cityslinks-select' id=\"rcity\" name=\"rcity\" onchange=\"document.getElementById('frm').submit()\" >
        <option  value='0'>- Выберите город -</option>";

        while($row = mysqli_fetch_assoc($res))
          echo "<option ".is_sel($row['ID'],'rcity')." value='" . $row['ID'] . "'>" . $row['Name'] . "</option>\r\n";

      echo "</select>";

    }
    ?>
    </form>
</div>
<div class="col-md-6 cityslinks">
    <div class="cityslinks-main">
        <a href="?allcitys">Все города</a>
    </div>
    <div class="cityslinks-maincitys">
        <a href="?moscow">Москва</a>
        <a href="?sankt-peterburg">Санкт-Петербург</a>
        <a href="?ufa">Уфа</a>
    </div>
    <div class="cityslinks-othercitys">
        <a href="?ufa">Уфа</a>
    </div>
</div>

           </div>
        </div>
    </div>
    
   
<? include ('footer.php') ?>
