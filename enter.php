<? include ('header.php') ?>

<div class="main">
        <div class="section">
        <div class="container tim-container" id="page-enter">

<div class="nav-tabs-navigation">
    <div class="nav-tabs-wrapper">
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active"><a href="#home" data-toggle="tab">Форма входа</a></li>
        <li><a href="#profile" data-toggle="tab">Регистрация</a></li>
    </ul>
    </div>
</div>

<div id="my-tab-content" class="tab-content text-center">
    <div class="tab-pane active" id="home">
         <form method="post">
	          <div class="modal-body">
	                <input name="login" type="text" class="form-control" placeholder="Логин"><br> 
	                <input name="password" type="password" class="form-control" placeholder="Пароль"><br>
	            <div class="forgot text-center">
	                <a href="#" class="btn btn-simple btn-danger">Забыли пароль?</a>
	            </div>
	          </div>
	            <div class="right-side">
	                <button name="submit_enter" type="submit" class="btn btn-danger btn-fill" >Войти</button>
	            </div>
	        </form>
    </div>

    <div class="tab-pane" id="profile">
       <form method="post" class="form">
        <div class="modal-body">
              <input name="login" type="text" id="login" maxlength="30" class="form-control" placeholder="Логин"><div class="reg-red-text"></div><br>
              <input name="email" type="text" id="email" maxlength="50" class="form-control" placeholder="E-mail"><div class="reg-red-text"></div><br>
              <input name="telephone" type="text" id="telephone" maxlength="10" class="form-control" placeholder="Номер телефона без 8"><div class="reg-red-text"></div>
              
              <p>Данные для подачи объявлений</p>
              <input name="city" type="text" id="city" maxlength="40" class="form-control input-city" placeholder="Город"><div class="reg-red-text"></div><br>
              <input name="street" type="text" id="street" maxlength="50" class="form-control input-street" placeholder="Улица"><div class="reg-red-text"></div><br>
             <input name="building" type="text" id="building" maxlength="10" class="form-control input-building" placeholder="Дом"><br>
              <input name="password" type="password" id="password" maxlength="50" class="form-control" placeholder="Пароль"><div class="reg-red-text"></div>
        </div>

              <button name="submit" type="submit" id="submit" class="btn btn-danger btn-fill" disabled>Зарегистрироваться</button>
    </form>
    </div> 
</div>
       
</div>
</div>
</div>
<? include ('footer.php') ?>
