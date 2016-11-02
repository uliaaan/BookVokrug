<? 
	session_start();
	$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');

	/*Обработчик если логин занят*/
	if(isset($_GET['login'])){
		$login = $_GET['login'];
		$double_reg_query = $connect->query("SELECT `login` FROM `users` WHERE `login` = '$login'");
		$double_reg_query_true = mysqli_fetch_assoc($double_reg_query);
		$res = $double_reg_query_true['login'];
		if($login == $res){
			echo "no";
		}else{
			echo "yes";
		}
	}

	/*Обработчик если email занят*/
	if(isset($_GET['email'])){
		$email = $_GET['email'];
		$double_reg_query = $connect->query("SELECT `email` FROM `users` WHERE `email` = '$email'");
		$double_reg_query_true = mysqli_fetch_assoc($double_reg_query);
		$res = $double_reg_query_true['email'];
		if($login == $res){
			echo "yes";
		}else{
			echo "no";
		}
	}


	/*Обработчик входа*/
	if(isset($_POST['login']) and isset($_POST['password'])) {
			$userlogin = htmlspecialchars(trim($_POST['login']));
			$userpassword = md5(htmlspecialchars(trim($_POST['password'])));
			/*Проверка на пустые поля*/
				if ($userlogin == '' and $userpassword == '') {
				header("Location: index.php");
				} else {
				/*Запрос к БД на авторизацию*/
				$my_query = $connect->query("SELECT `login`,`password` FROM `users` WHERE `login` = '$userlogin' AND `password` = '$userpassword'");
				$result = $my_query->fetch_assoc();
				if ($result) {
					$_SESSION['userlogin'] = $userlogin;
					}
				}
	}

	/*Обработчик регистрации*/
	if(isset($_POST['login']) and isset($_POST['password']) and isset($_POST['email']) and isset($_POST['telephone'])) {
		$userlogin = htmlspecialchars(trim($_POST['login'])); 
		$userpassword = md5(htmlspecialchars(trim($_POST['password'])));
		if(isset($_POST['email'])) {
				preg_match_all('#([a-z0-9\-\.\_]+@[a-z0-9\-]+\.[a-z]+$)#isU', $_POST['email'], $matches);
				$_POST['email'] = implode('', $matches[1]);
					if($_POST['email']) {
						$useremail = htmlspecialchars(trim($_POST['email'])); 
					}
		} 
		$usertelephone = htmlspecialchars(trim($_POST['telephone'])); 
		$usercity = htmlspecialchars(trim($_POST['city']));
		//Достаем id города
		$usercity_id = $connect->query("SELECT `id` FROM `citys` WHERE `city` = '$usercity'");
		$usercity_id_true = mysqli_fetch_assoc($usercity_id);
        $res_city_id = $usercity_id_true['id'];
		$userstreet = htmlspecialchars(trim($_POST['street'])); 
		$userbuilding = htmlspecialchars(trim($_POST['building'])); 
		$reg_query = $connect->query("INSERT INTO `users` (`id`, `login`, `password`,`email`,`telephone`,`city_id`,`street`,`building`) VALUES ('','$userlogin','$userpassword','$useremail','$usertelephone','$res_city_id','$userstreet','$userbuilding')");
			if ($reg_query) {
				$_SESSION['userlogin'] = $userlogin;
			}
	}

/*	function simple_query() {
		$my_query = mysqli_query($connect, "SELECT `login` FROM `users`");
		$result = mysqli_fetch_assoc($my_query);
		$login = $result['login'];
		echo $login;
	}
*/

	/*Обработчик если город введен не венро*/
	if(isset($_GET['city'])){
		$city = $_GET['city'];
		$double_reg_query = $connect->query("SELECT `city` FROM `citys` WHERE `city` = '$city'");
		$double_reg_query_true = mysqli_fetch_assoc($double_reg_query);
		$res = $double_reg_query_true['city'];
		if($city == $res){
			echo "yes";
		}else{
			echo "no";
		}
	}

	//Город подстановка
	if(isset($_GET['term'])) {
	    $searchTerm = $_GET['term'];
	    
	    //Выборка по городам
	    $query = $connect->query("SELECT `city` FROM `citys` WHERE `city` LIKE '%".$searchTerm."%' ORDER BY `city` ASC");
	    while ($row = $query->fetch_assoc()) {
	        $data[] = $row['city'];
	    }
	    //Возвращение значения
    echo json_encode($data);
	}


/*Если пользоваетль в сессии*/
if ($_SESSION['userlogin']) {
	$userlogin = $_SESSION['userlogin'];
	$userdatequery = $connect->query("SELECT * FROM `users` WHERE `login` = '$userlogin'");
	$userdatequery_mass = mysqli_fetch_assoc($userdatequery);
    $useremail = $userdatequery_mass['email'];
    $usertelephone = $userdatequery_mass['telephone'];
    $usercity_id = $userdatequery_mass['city_id'];
    $usercity_query = $connect->query("SELECT `city` FROM `citys` WHERE `id` = '$usercity_id'");
	$usercity_id_true = mysqli_fetch_assoc($usercity_query);
    $usercity = $usercity_id_true['city'];
    $userstreet = $userdatequery_mass['street'];
    $userbuilding = $userdatequery_mass['building'];
    $userpassword = $userdatequery_mass['password'];


	/*Обработчки проверки пароля*/
    if(isset($_GET['passwordlate'])){
		$password_late = md5($_GET['passwordlate']);
		$password_latequery = $connect->query("SELECT `password` FROM `users` WHERE `password` = '$password_late'");
		$password_latequery_mass = mysqli_fetch_assoc($password_latequery);
		$password_late_true = $password_latequery_mass['password'];
		if($password_late == $password_late_true){
			echo "yes";
		}else{
			echo "no";
		}
	}


	/*Изменение данных в профиле*/
	if($_SERVER['REQUEST_URI'] === '/settingsprofile.php') {
		if(isset($_POST['email']) or isset($_POST['telephone']) or isset($_POST['city']) or isset($_POST['street']) or isset($_POST['building'])) {
			/*Проверка емейла сервером*/
			if(isset($_POST['email'])) {
				preg_match_all('#([a-z0-9\-\.\_]+@[a-z0-9\-]+\.[a-z]+$)#isU', $_POST['email'], $matches);
				$_POST['email'] = implode('', $matches[1]);
					if($_POST['email']) {
						$useremail = htmlspecialchars(trim($_POST['email'])); 
					}
			}
			/*Обновление данных*/
			$usertelephone = htmlspecialchars(trim($_POST['telephone'])); 
			$usercity = htmlspecialchars(trim($_POST['city']));
			//Достаем id города
			$usercity_id = $connect->query("SELECT `id` FROM `citys` WHERE `city` = '$usercity'");
			$usercity_id_true = mysqli_fetch_assoc($usercity_id);
	        $res_city_id = $usercity_id_true['id'];
			$userstreet = htmlspecialchars(trim($_POST['street'])); 
			$userbuilding = htmlspecialchars(trim($_POST['building']));
			$update_query = $connect->query("UPDATE `users` SET `email` = '$useremail', `telephone` = '$usertelephone', `city_id` = '$res_city_id', `street` = '$userstreet', `building` = '$userbuilding' WHERE `login` = '$userlogin'");
				if ($update_query) {
					header("Location: profile.php?edituserprofile=1");
				}
		}

		/*Обновление информации по паролю*/
		if (isset($_POST['passwordlate']) and isset($_POST['passwordnew'])) {
			$passwordlate = md5(htmlspecialchars(trim($_POST['passwordlate'])));
			$passwordnew = md5(htmlspecialchars(trim($_POST['passwordnew'])));
			if($userpassword == $passwordlate){
				$update_query_pass = $connect->query("UPDATE `users` SET `password` = '$passwordnew' WHERE `login` = '$userlogin'");
				if ($update_query_pass) {
					header("Location: profile.php?edituserprofile=1");
				}
			}
		}
	}

	$update_user_data_notif = "<div class=\"alert alert-success\"><div class=\"container\">Данные успешно изменены</div></div>";
	$update_user_data_notif_fallse = "<div class=\"alert alert-danger\"><div class=\"container\">Ошибка изменения данных</div></div>";


    /*Выход с сайта*/
	if (isset($_GET['exit'])) {
		unset($_SESSION['userlogin']);
		header("Location: index.php");
	}


	/*Подстановка жанра в поле селект лист*/
	$getbookgenre = $connect->query("SELECT `genre` FROM `bookgenre`");
	$getbookgenre_res = '';
	 while($getbookgenre_mass = mysqli_fetch_assoc($getbookgenre))
		{
	  		$getbookgenre_res .= '<option value = "'.$getbookgenre_mass['genre'].'">'.$getbookgenre_mass['genre'].'</option>';
		}

}


    
		
	
?>