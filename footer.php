</div> <!-- end wrapper -->



    <footer class="footer-demo section-dark">
    <div class="container">
        <nav class="pull-left">
            <ul>

                <li>
                    <a href="/about.php">
                        О проекте
                    </a>
                </li>
                <li>
                    <a href="/rules.php">
                       Правила
                    </a>
                </li>
                <li>
                    <a href="/lince.php">
                        Лицензионное соглашение
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright pull-right">
            powered by <a href="http://uliaaan.ru"><img src="http://uliaaan.ru/logo000.svg"></a>
        </div>
        <div class="footer-social-icons">
        <a href="https://github.com/uliaaan/BookVokrug">
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-github fa-stack-1x fa-inverse"></i>
          </span>
        </a>
        <a href="https://instagram.com/bookvokrug">
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
          </span>
        </a>
        <span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
        </span>
        <span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
        </span>
        </div>
        
    </div>
</footer>
</div>


<!-- MODAL ENTER -->

<div class="modal fade" id="enter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Форма входа</h4>
          </div>
          <div class="modal-body">
                <input name="login" type="text" class="form-control" placeholder="Логин"><br> 
                <input name="password" type="password" class="form-control" placeholder="Пароль"><br>
            <div class="forgot text-center">
                <a href="#" class="btn btn-simple btn-danger">Забыли пароль?</a>
            </div>
          </div>
          <div class="modal-footer">
            <div class="left-side">
                <a href="#" target="_blank" type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-toggle="modal" data-target="#register">Регистрация</a>
            </div>
            <div class="divider"></div>
            <div class="right-side">
                <button name="submit_enter" type="submit" class="btn btn-default btn-simple" >Войти</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>

<!-- MODAL REGISTER -->

<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <form method="post" class="form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Регистрация</h4>
        </div>
        <div class="modal-body">
              <input name="login" type="text" id="login" maxlength="30" class="form-control" placeholder="Логин"><div class="reg-red-text"></div><br>
              <input name="email" type="text" id="email" maxlength="50" class="form-control" placeholder="E-mail"><div class="reg-red-text"></div><br>
              <input name="telephone" type="text" id="telephone" maxlength="10" class="form-control" placeholder="Номер телефона без 8"><div class="reg-red-text"></div><br>
              <div class="display-flex">
                <div class="ui-widget input-city-with-error">
                  <input name="city" type="text" id="city" maxlength="40" class="form-control input-city" placeholder="Город"><div class="reg-red-text"></div>
                </div>
                <div class="input-street-with-error">
                  <input name="street" type="text" id="street" maxlength="50" class="form-control input-street" placeholder="Улица"><div class="reg-red-text"></div>
                </div>
                <div class="input-building-with-error">
                  <input name="building" type="text" id="building" maxlength="10" class="form-control input-building" placeholder="Дом">
                </div>
              </div><br>
              <input name="password" type="password" id="password" maxlength="50" class="form-control" placeholder="Пароль"><div class="reg-red-text"></div>
        </div>
        <div class="modal-footer">
              <button name="submit" type="submit" id="submit" class="btn btn-default btn-simple" disabled>Зарегистрироваться</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!--    end modal -->


</body>

    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	
	<!--  Plugins -->
	<script src="assets/js/ct-paper-checkbox.js"></script>
	<script src="assets/js/ct-paper-radio.js"></script>
	<script src="assets/js/bootstrap-select.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
	
  <script src="assets/js/ct-paper.js"></script>    
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
    
</html>