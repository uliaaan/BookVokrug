<? include ('header.php') ?>
<? if ($_SESSION['userlogin']) { ?>
<section id="edit-profile" class="section-with-space">
	<div class="container edit-profile-block">
		<h4 class="text-center">Редактировать профиль</h4>
		<form method="post" class="form">
			<label>Логин - <? echo $userlogin ?></label><br>
			<label>E-mail</label>
			<input name="email" type="text" id="email" maxlength="50" class="form-control" placeholder="E-mail" value="<? echo $useremail ?>"><div class="reg-red-text" ></div><br>
			<label>Телефон</label>
			<input name="telephone" type="text" id="telephone" maxlength="10" class="form-control" placeholder="Номер телефона без 8" value="<? echo $usertelephone ?>"><div class="reg-red-text"></div><br>
			<div class="display-flex">
			    <div class="ui-widget input-city-with-error">
					<label>Город</label>
			    	<input name="city" type="text" id="city" maxlength="40" class="form-control input-city" placeholder="Город" value="<? echo $usercity ?>"><div class="reg-red-text"></div>
			    </div>
			    <div class="input-street-with-error">
			    	<label>Улица</label>
			    	<input name="street" type="text" id="street" maxlength="50" class="form-control input-street" placeholder="Улица" value="<? echo $userstreet ?>"><div class="reg-red-text"></div>
			    </div>
			    <div class="input-building-with-error">
					<label>Дом</label>
			    	<input name="building" type="text" id="building" maxlength="10" class="form-control input-building" placeholder="Дом" value="<? echo $userbuilding ?>">
			    </div>
			</div><br>
			<label>Старый пароль</label>
			<input name="passwordlate" type="password" id="passwordlate" maxlength="50" class="form-control"><div class="reg-red-text"></div><br>
			<label>Новый пароль</label>
			<input name="passwordnew" type="password" id="passwordnew" maxlength="50" class="form-control" disabled><div class="reg-red-text"></div><br>
			<button name="submit" type="submit" id="submitredact" class="btn btn-success center-block" disabled>Сохранить изменения</button>
		</form>
	</div>
</section>
<? } else {
    header("Location: / ");
    } ?>
<? include ('footer.php') ?>
