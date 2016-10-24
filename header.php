<? include ('functions.php') ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/paper_img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Paper Kit by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/ct-paper.css" rel="stylesheet"/>
    <link href="assets/css/main.css" rel="stylesheet" /> 
        
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
      
</head>
<body>
<nav class="navbar navbar-ct-transparent" role="navigation-demo" id="demo-navbar">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="http://www.creative-tim.com">
           <div class="logo-container">
                <div class="logo">
                    <img src="assets/paper_img/new_logo.png" alt="Creative Tim Logo">
                </div>
                <div class="brand">
                    Creative Tim
                </div>
            </div>
      </a>
    </div>

<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-example-2">
      <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="components.html" class="btn btn-danger btn-simple">Components</a>
          </li>
          <li>
            <a href="tutorial.html" class="btn btn-danger btn-simple">Tutorial</a>
          </li>
          <li>
          <? echo "<a href='?exit' class='btn btn-danger btn-simple'>Выйти</a>" ?>
          </li>
          <li>
          <? if(!isset($_SESSION['userlogin'])) { 
            echo "<a href='#' target='_blank' class='btn btn-danger btn-fill' data-toggle='modal' data-target='#enter'>Войти</a>"; } else {
            echo "<a href='#'' target='_blank' class='btn btn-danger btn-fill'>$userlogin</a>";
            }
          ?>
          </li>
       </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-->
</nav>         


<div class="wrapper">