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
		$useremail = htmlspecialchars(trim($_POST['email'])); 
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

	/*Выход с сайта*/
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
	    
    
		
	
?>