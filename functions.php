<? 
	session_start();
	$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');
	date_default_timezone_set('Europe/Moscow');

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
	$userid_query = $connect->query("SELECT `id` FROM `users` WHERE `login` = '$userlogin'");
	$userid_query_mass = mysqli_fetch_assoc($userid_query);
    $userlogin_id = $userid_query_mass['id'];
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
	$addbook_notif = "<div class=\"alert alert-success\"><div class=\"container\">Книга успешно добавлена</div></div>";
	$addbook_size_fallse = "<div class=\"alert alert-danger\"><div class=\"container\">Слишком большой размер файла</div></div>";


    /*Выход с сайта*/
	if (isset($_GET['exit'])) {
		unset($_SESSION['userlogin']);
		header("Location: index.php");
	}


	/*Подстановка жанра в поле селект лист*/
	$getbookgenre = $connect->query("SELECT `genre` FROM `bookgenre`");
	$getbookgenre_res = '';
	while($getbookgenre_mass = mysqli_fetch_assoc($getbookgenre)) {
	  		$getbookgenre_res .= '<option value = "'.$getbookgenre_mass['genre'].'">'.$getbookgenre_mass['genre'].'</option>';
	}


	/*Страница добавления книг*/
	if($_SERVER['REQUEST_URI'] === '/addbook.php') {
		if(isset($_POST['addtitlebook']) and isset($_POST['bookgenre']) and isset($_POST['addtextbook']) and isset($_POST['addpricebook'])) {
		$addtitlebook = htmlspecialchars($_POST['addtitlebook']); 
		$bookgenre = htmlspecialchars($_POST['bookgenre']);
		$addtextbook = htmlspecialchars($_POST['addtextbook']); 
		$addpricebook = htmlspecialchars(trim($_POST['addpricebook']));
		//Достаем id жанра
		$bookgenreid_query = $connect->query("SELECT `id` FROM `bookgenre` WHERE `genre` = '$bookgenre'");
		$bookgenre_id_mass = mysqli_fetch_assoc($bookgenreid_query);
        $bookgenre_id = $bookgenre_id_mass['id'];

		/*Дата добавления и окнчания*/
		$addtime = time();
        $endtime = $addtime + 2592000;
		

        /*Картинка в бд*/
        $uploaddir = 'assets/userbooks/';
        $uploadfilesize = $_FILES['uploadfile']['size'];
        
        /*Тип загружаемой картинки*/
        $typeimg = strtolower(substr(strrchr($_FILES['uploadfile']['name'],'.'), 1));
			switch (true)
			{
			    case in_array($typeimg, array('jpeg','jpe','jpg')):
			    {
			        $p = 'jpeg';
			        break;
			    }
			    case ($typeimg =='gif'):
			    {
			        $p = 'gif';
			        break;
			    }
			    case ($typeimg =='png'):
			    {
			        $p = 'png';
			        break;
			    }
			}


        	/*Проверка размера фото*/
	        if (($_FILES['uploadfile']['type'] == 'image/gif' || $_FILES['uploadfile']['type'] == 'image/jpeg' || $_FILES['uploadfile']['type'] == 'image/png') && ($uploadfilesize <= 1024000)) {
	        	/*Подстановка пути до картинки*/
	        	$uploadfile = $uploaddir.$addtime.'.'.$p;
		        copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
			
				$addbook = $connect->query("INSERT INTO `books` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`) VALUES ('','$userlogin_id','$addtitlebook','$bookgenre_id','$addtextbook','$addpricebook','$uploadfile', '$addtime', '$endtime')");
						if ($addbook) {
							header("Location: profile.php?addbook=1");

						}
			
			} else {
				header("Location: profile.php?addbook=2");
			}
		} //Конец добавление книги

		
	} //Конец - страница добавления книги
}// Конец $_SESSION['userlogin']


	/*Вывод книг на главную страницу*/
	function booksonmain() {
		global $connect;
		$booksrow = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books`");
		
			while($booksrow_res = mysqli_fetch_assoc($booksrow)) {
				echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
					$booksrow_res['id'];
					echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
					echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
					echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
					echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';

				echo "</div></a>";
			}
		
	}

	/*Страница книги*/
	if (isset($_GET['bookid'])) {
		$bookid = $_GET['bookid'];
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `id` = '$bookid'");
		$bookquery_res = mysqli_fetch_assoc($bookquery);
		$booktitle = $bookquery_res['booktitle'];
		
		$book_price = $bookquery_res['price'];
		$book_imgbookurl = $bookquery_res['imgbookurl'];
		$book_addtime = $bookquery_res['addtime'];
		$book_endtime = $bookquery_res['endtime'];

		/*Данные продавца*/
		$book_user_id = $bookquery_res['user_id'];
		$book_user_id_query = $connect->query("SELECT `id`, `login`, `password`,`email`,`telephone`,`city_id`,`street`,`building` FROM `users` WHERE `id` = '$book_user_id'");
		$book_user_id_query_mass = mysqli_fetch_assoc($book_user_id_query);
		$book_user_login = $book_user_id_query_mass['login'];
		$book_user_telephone = $book_user_id_query_mass['telephone'];
		$book_user_street = $book_user_id_query_mass['street'];
		$book_user_building = $book_user_id_query_mass['building'];

		/*Данные жанра*/
		$book_genre_id = $bookquery_res['bookgenre_id'];
		$book_genre_id_query = $connect->query("SELECT `id`, `genre` FROM `bookgenre` WHERE `id` = '$book_genre_id'");
		$book_genre_id_query_mass = mysqli_fetch_assoc($book_genre_id_query);
		$book_genre_name = $book_genre_id_query_mass['genre'];

		/*Перевод времени и подсчет остатка дней*/
		if ($book_endtime > time()) {
			$book_day_to_zero = ($book_endtime - time())/86400;
		} else {
			$book_day_to_zero = 0;
		}
		
	}








    
		
	
?>