<? include ('functions.php') ?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title><? title(); ?> - БУКВОКРУГ</title>

  <meta name="description" content="БУКВОКРУГ - купи, продай или обменяй книжки"/>
  <meta name="robots" content="noodp"/>
  <link rel="canonical" href="http://bookvokrug.ru/" />
  <meta property="og:locale" content="ru_RU" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="БУКВОКРУГ - купи, продай или обменяй книжки" />
  <meta property="og:description" content="Скопились книжки и Вы не знаете куда их деть? Продайте или обменяйте их на нашем порале!" />
  <meta property="og:url" content="http://bookvokrug.ru/" />
  <meta property="og:site_name" content="bookvokrug.ru" />

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <link href="assets/css/jquery-ui.css" rel="stylesheet" /> 
  <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/ct-paper.css" rel="stylesheet"/>
  <link href="assets/css/main.css" rel="stylesheet" /> 

  <!--     Fonts and icons     -->
  <link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet"> <!--  Добавить в папу -->
  <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
  <meta name="yandex-verification" content="868867660412cf61" />
  <meta name="google-site-verification" content="37ds4WzRmwb3lj5HuCccy0k91nZkkki_K0NdTzjWg_k" />

</head>
<body>

<nav class="navbar navbar-ct-transparent nav-img" role="navigation-demo" id="demo-navbar">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/">
           <div class="logo-container">
                <div class="logo">
                    <img src="assets/img/logo-main.svg" alt="logo">
                </div>
            
            </div>
      </a>
    </div>

<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-example-2">
      <ul class="nav navbar-nav navbar-right">
        <li><a href='/citys.php' class='btn btn-danger btn-fill' > <i class="fa fa-map-marker" aria-hidden="true"></i>
        <? if (empty($usercity_session) || empty($_SESSION['usercity'])) {
            echo $allcitys;
          } else {
            echo $usercity_session; 
          }?>
        </a></li>
        <!--   <li>
          <a href="components.html" class="btn btn-danger btn-simple">Components</a>
        </li>
        <li>
          <a href="tutorial.html" class="btn btn-danger btn-simple">Tutorial</a>
        </li> -->
          <? if(isset($_SESSION['userlogin'])) { 
          echo "
          
          <li class='dropdown profile-menu-button'>
            <a href='#' class='dropdown-toggle btn btn-danger' data-toggle='dropdown' aria-expanded='false'>" .$_SESSION['userlogin']. "<b class='caret'></b></a>
            <ul class='dropdown-menu dropdown-menu-right'>
              <li><a href='/profile.php'>Профиль</a></li>
              <li><a href='/settingsprofile.php'>Редактировать</a></li>
              <li><a href='?exit'>Выйти</a></li>
            </ul>
          </li>
          <li>
          <a href='/addbook.php' class='btn btn-danger btn-fill'>Добавить книгу</a>"; 
        	} else {
          echo "<a href='#enter' target='_blank' class='btn btn-danger btn-fill' data-toggle='modal' data-target='#enter'>Войти</a>";
          }
          ?>
          </li>
       </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-->
</nav>         


<div class="wrapper">