</div> <!-- end wrapper -->

    <!-- </div> -->
    <div class="main">
        <div class="section section-nude section-with-space">
            <div class="container tim-container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h2>Do you like what you see?</h2>
                        <p>Cause if you do, it can be yours for free. Hit the button below to navigate to Creative Tim where you can find the kit. Start a new project or give an old Bootstrap project a new look, we've got you covered. </p>
                    </div>
                    <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 download-area">
                        <a href="http://www.creative-tim.com/product/paper-kit" class="btn btn-danger btn-fill btn-block btn-lg">Download</a>
                    </div>
                </div>
                <div class="row sharing-area text-center">
                        <h3>Sharing is caring!</h3>
                        <a href="#" class="btn">
                            <i class="fa fa-twitter"></i>
                            Twitter
                        </a>
                        <a href="#" class="btn">
                            <i class="fa fa-facebook-square"></i>
                            Facebook
                        </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-demo section-dark">
    <div class="container">
        <nav class="pull-left">
            <ul>

                <li>
                    <a href="http://www.creative-tim.com">
                        Creative Tim
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com">
                       Blog
                    </a>
                </li>
                <li>
                    <a href="http://www.creative-tim.com/product/rubik">
                        Licenses 
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright pull-right">
            &copy; 2015, made with <i class="fa fa-heart heart"></i> by Creative Tim
        </div>
    </div>
</footer>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. </p>
      </div>
      <div class="modal-footer">
        <div class="left-side">
            <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Never mind</button>
        </div>
        <div class="divider"></div>
        <div class="right-side">
            <button type="button" class="btn btn-danger btn-simple">Delete</button>
        </div>
      </div>
    </div>
  </div>
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
              <input name="login" type="text" id="login" class="form-control" placeholder="Логин"><div class="reg-red-text"></div><br>
              <input name="email" type="text" id="email" class="form-control" placeholder="E-mail"><div class="reg-red-text"></div><br>
              <input name="telephone" type="telephone" id="telephone" class="form-control" placeholder="Номер телефона"><div class="reg-red-text"></div><br>
              <div class="display-flex">
                <input name="city" type="text" id="city" class="form-control" placeholder="Город">&nbsp;&nbsp;
                <input name="street" type="text" id="street" class="form-control" placeholder="Улица">&nbsp;&nbsp;
                <input name="building" type="text" id="building" class="form-control" placeholder="Дом">
              </div><br>
              <input name="password" type="password" id="password" class="form-control" placeholder="Пароль"><div class="reg-red-text"></div><br>
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
</html>