<? 
	session_start();
	$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');

	/*Обработчик входа*/
	if(isset($_POST['login']) and isset($_POST['password'])) {
			$userlogin = htmlspecialchars(trim($_POST['login']));
			$userpassword = htmlspecialchars(trim($_POST['password']));
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
	if(isset($_POST['login']) and isset($_POST['password1']) == isset($_POST['password2'])) {
		$userlogin = htmlspecialchars(trim($_POST['login'])); 
		/*$useremail = htmlspecialchars(trim($_POST['email'])); 
		$usertelephone = htmlspecialchars(trim($_POST['telephone'])); 
		$usercity = htmlspecialchars(trim($_POST['city']));
		$userstreet = htmlspecialchars(trim($_POST['street'])); 
		$userbuilding = htmlspecialchars(trim($_POST['building'])); */
		$userpassword = htmlspecialchars(trim($_POST['password1']));
		/*Проверка на существующий логин*/
		$double_reg_query = $connect->query("SELECT `login` FROM `users` WHERE `login` = '$userlogin'");
		/*Преобразование к элементу*/
		$double_reg_query_true = $double_reg_query->fetch_assoc();
		if (!$double_reg_query_true) {
			/*Запрос на добавление нового пользователя*/
			$reg_query = $connect->query("INSERT INTO `users` (`id`, `login`, `password`) VALUES ('','$userlogin','$userpassword')");
			if ($reg_query) {
				$_SESSION['userlogin'] = $userlogin;
			}
		} else {
			/*Переменная для вывода о том, что логин занят*/
			$UserLoginHasExist = "Логин занят";
		}





			/*$userlogin = htmlspecialchars(trim($_POST['login']));
			$userpassword = htmlspecialchars(trim($_POST['password']));
			$my_query = $connect->query("SELECT `login`,`password` FROM `users` WHERE `login` = '$userlogin' AND `password` = '$userpassword'");
			$result = $my_query->fetch_assoc();
			if ($result) {
				$_SESSION['userlogin'] = $userlogin;
			}*/
	}


	if (isset($_GET['exit'])) {
		unset($_SESSION['userlogin']);
		header("Location: index.php");
	}

/*	function simple_query() {
		$my_query = mysqli_query($connect, "SELECT `login` FROM `users`");
		$result = mysqli_fetch_assoc($my_query);
		$login = $result['login'];
		echo $login;
	}
*/

		
		
	
?>