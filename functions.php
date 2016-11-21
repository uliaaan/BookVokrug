<? 
	session_start();
	$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');
	date_default_timezone_set('Europe/Moscow');

	function title() {
	global $connect;
	$page=$_GET['page'];
	$filterbookgenre = $_GET['bookgenre'];

	if ($_GET['bookid']) {
		$bookid = $_GET['bookid'];
		$bookquery = $connect->query("SELECT * FROM `books` WHERE `id` = '$bookid'");
		$bookquery_res = mysqli_fetch_assoc($bookquery);
		$booktitle = $bookquery_res['booktitle'];
    } else if ($_GET['noactivebookid']) {
    	$bookid = $_GET['noactivebookid'];
		$bookquery = $connect->query("SELECT * FROM `booksold` WHERE `id` = '$bookid'");
		$bookquery_res = mysqli_fetch_assoc($bookquery);
		$booktitle = $bookquery_res['booktitle'];
    } else if ($_GET['userid']) {
    	$userid = $_GET['userid'];
		$bookquery = $connect->query("SELECT * FROM `users` WHERE `id` = '$userid'");
		$bookquery_res = mysqli_fetch_assoc($bookquery);
		$userlogin = $bookquery_res['login'];
    } else if ($_GET['editbookid']) {
    	$bookid = $_GET['editbookid'];
		$bookquery = $connect->query("SELECT * FROM `books` WHERE `id` = '$bookid'");
		$bookquery_res = mysqli_fetch_assoc($bookquery);
		$booktitle = $bookquery_res['booktitle'];
    }


		if($_SERVER['REQUEST_URI'] === '/index.php' || $_SERVER['REQUEST_URI'] === '/') {
			echo 'БУКВОКРУГ - продай или купи книгу';
		} else if ($_SERVER['REQUEST_URI'] === '/index.php?page='.$page) {
			echo 'Страница '.$page.' - БУКВОКРУГ';
		} else if ($_SERVER['REQUEST_URI'] === '/index.php?page='.$page.'&bookgenre='.$filterbookgenre) {
			echo 'Страница '.$page.' - БУКВОКРУГ';
		} else if (($_SERVER['REQUEST_URI'] === '/book.php?bookid='.$bookid) || ($_SERVER['REQUEST_URI'] === '/book.php?noactivebookid='.$bookid)) {
			echo $booktitle.' - БУКВОКРУГ';
		} else if ($_SERVER['REQUEST_URI'] === '/profile.php?userid='.$userid) {
			echo 'Профиль пользователя - '.$userlogin;
		} else if ($_SERVER['REQUEST_URI'] === '/profile.php') {
			echo 'Профиль';
		} else if ($_SERVER['REQUEST_URI'] === '/settingsprofile.php') {
			echo 'Редактировать профиль';
		} else if ($_SERVER['REQUEST_URI'] === '/addbook.php') {
			echo 'Добавить книгу';
		} else if ($_SERVER['REQUEST_URI'] === '/settingsbook.php?editbookid='.$bookid) {
			echo 'Редактировать книгу - '.$booktitle;
		}
	}

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



    $usercity_query_id = $connect->query("SELECT `city_id` FROM `users` WHERE `login` = '$userlogin'");
	$usercity_query_id_mass = mysqli_fetch_assoc($usercity_query_id);
    $usercity_id = $usercity_query_id_mass['city_id'];

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
	} //Конец $_SERVER['REQUEST_URI'] === '/settingsprofile.php'
	

	$update_user_data_notif = "<div class=\"alert alert-success\"><div class=\"container\">Данные успешно изменены</div></div>";
	$addbook_notif = "<div class=\"alert alert-success\"><div class=\"container\">Книга успешно добавлена</div></div>";
	$delbook_true = "<div class=\"alert alert-success\"><div class=\"container\">Книга успешно удалена</div></div>";
	$addbook_size_fallse = "<div class=\"alert alert-danger\"><div class=\"container\">Слишком большой размер файла</div></div>";
	$editbook_fallse = "<div class=\"alert alert-danger\"><div class=\"container\">Ошибка</div></div>";


    /*Выход с сайта*/
	if (isset($_GET['exit'])) {
		unset($_SESSION['userlogin']);
		header("Location: index.php");
	}

	//Удаление книги
	if (isset($_GET['deletebookid'])) {
		$userlogin_id;
		$bookid = $_GET['deletebookid'];
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `books` WHERE `id` = '$bookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
			if ($bookquery_res['user_id'] == $userlogin_id) { 
				$bookdel_query = $connect->query("DELETE FROM `books` WHERE `id` = '$bookid'");
					if ($bookdel_query) {
						header("Location: profile.php?delbook=1");
					} else {
						header("Location: profile.php?addbook=2");
					}
			}
		}
	}

	//Удаление книги из второй таблицы
	if (isset($_GET['deletebookid'])) {
		$userlogin_id;
		$bookid = $_GET['deletebookid'];
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `booksold` WHERE `id` = '$bookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
			if ($bookquery_res['user_id'] == $userlogin_id) { 
				$bookdel_query = $connect->query("DELETE FROM `booksold` WHERE `id` = '$bookid'");
					if ($bookdel_query) {
						header("Location: profile.php?delbook=1");
					} else {
						header("Location: profile.php?addbook=2");
					}
			}
		}
	}

	//Поднять книгу по времени
	if (isset($_GET['upbookid'])) {
		$userlogin_id;
		$bookid = $_GET['upbookid'];
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `booksold` WHERE `id` = '$bookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
			if ($bookquery_res['user_id'] == $userlogin_id) { 
				$addtime_new = time();
        		$endtime_new = $addtime_new + 2592000;
				$uptimebook = $connect->query("UPDATE `booksold` SET `endtime` = '$endtime_new' WHERE `id` = '$bookid'");
					if ($uptimebook) {
						header("Location: profile.php?edituserprofile=1");
					} else {
						header("Location: profile.php?editbook=2");
					}
			}
		}
	}



	

	/*Страница добавления книг*/
	if($_SERVER['REQUEST_URI'] === '/addbook.php') {
		if(isset($_POST['addtitlebook']) and isset($_POST['bookgenre']) and isset($_POST['addpricebook']) and isset($_POST['addtextbook'])) {
		$addtitlebook = htmlspecialchars($_POST['addtitlebook']); 
		$bookgenre = htmlspecialchars($_POST['bookgenre']); 
		$addpricebook = htmlspecialchars(trim($_POST['addpricebook']));
		$addtextbook = htmlspecialchars($_POST['addtextbook']); 
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
		
			$addbook = $connect->query("INSERT INTO `books` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id`) VALUES ('','$userlogin_id','$addtitlebook','$bookgenre_id','$addtextbook','$addpricebook','$uploadfile', '$addtime', '$endtime','$usercity_id')");
					if ($addbook) {
						header("Location: profile.php?addbook=1");

					}
		
		} else {
			header("Location: profile.php?addbook=2");
		}
		} //Конец добавление книги

		
	} //Конец - страница добавления книги




		/*Вывод профиля*/
		function profile_user() {
		global $connect;
		global $userlogin_id;
		$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `user_id` = '$userlogin_id'");
		while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
				echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
					$booksrow_res['id'];			
					echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
					echo '<div class="books-block-gradient"></div>';
					echo '<div class="edit-book-button"><a href="settingsbook.php?editbookid=' .$booksrow_res['id']. '"><i class="fa fa-cog" aria-hidden="true"></i></a></div>';
					echo '<div class="delete-book-button"><a href="?deletebookid=' .$booksrow_res['id']. '"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>';	
					echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
					echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
					echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';
					

				echo "</div></a>";
			}
		}


		/*Вывод если есть запрос на профиль*/
		function profile_user_get() {
		global $connect;
		global $userlogin_id;
		global $profile_user_id;
		$profile_user_id = $_GET['userid'];
		nameinprofile();
			if ($profile_user_id == $userlogin_id) {
				header("Location: profile.php");
			} else {
				$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `user_id` = '$profile_user_id'");
					while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
						echo '<a href="book.php?editbookid=' .$booksrow_res['id']. '"><div class="books-block">';
							$booksrow_res['id'];
							echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
							echo '<div class="books-block-gradient"></div>';
							echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
							echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
							echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';

						echo "</div></a>";
					}
			}
		}


		/*Вывод неактуальных книг*/
		function profile_user_noactualbooks() {
		global $connect;
		global $userlogin_id;
		$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `booksold` WHERE `user_id` = '$userlogin_id'");
		while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
				echo '<a href="book.php?noactivebookid=' .$booksrow_res['id']. '"><div class="books-block">';
					$booksrow_res['id'];
					echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
					echo '<div class="books-block-gradient"></div>';
					echo '<div class="up-book-button"><a href="?upbookid=' .$booksrow_res['id']. '"><i class="fa fa-arrow-up" aria-hidden="true"></i></a></div>';
					echo '<div class="delete-book-button"><a href="?deletebookid=' .$booksrow_res['id']. '"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>';	
					echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
					echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
					echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';

				echo "</div></a>";
			}
		}


	/*Страница книги устаревшей*/
	if (isset($_GET['noactivebookid'])) {
		$bookid = $_GET['noactivebookid'];
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `booksold` WHERE `id` = '$bookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
				if ($bookquery_res['user_id'] == $userlogin_id) { //Если серв находит второе совпадение - БИНГО
					$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `booksold` WHERE `id` = '$bookid'");
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
				} else {
					header("Location: profile.php");
				}
		} //Конец while

	}//Конец isset($_GET['noactivebookid'])



	//Страница редактирования книги
	if (isset($_GET['editbookid'])) {
		$editbookid = $_GET['editbookid'];
		//Супер запрос на поиск из двух таблиц
		$bookquery = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `id` = '$editbookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
				if ($bookquery_res['user_id'] == $userlogin_id) { //Если серв находит второе совпадение - БИНГО
					$booktitle = $bookquery_res['booktitle'];
					$book_price = $bookquery_res['price'];
					$book_imgbookurl = $bookquery_res['imgbookurl'];
					$book_genre_id = $bookquery_res['bookgenre_id'];

					/*Данные жанра*/
					$book_genre_id = $bookquery_res['bookgenre_id'];
					$book_genre_id_query = $connect->query("SELECT `id`, `genre` FROM `bookgenre` WHERE `id` = '$book_genre_id'");
					$book_genre_id_query_mass = mysqli_fetch_assoc($book_genre_id_query);
					$book_genre_name = $book_genre_id_query_mass['genre'];
				} else {
					header("Location: profile.php");
				}
			}

			/*Запрос страницы редактирования книг*/
			if(isset($_POST['edittitlebook']) and isset($_POST['editbookgenre']) and isset($_POST['editpricebook'])) {
			$edittitlebook = htmlspecialchars($_POST['edittitlebook']); 
			$editpricebook = htmlspecialchars(trim($_POST['editpricebook']));
			$editbookgenre = htmlspecialchars($_POST['editbookgenre']); 
			//Достаем id жанра
			$bookgenreid_query = $connect->query("SELECT `id` FROM `bookgenre` WHERE `genre` = '$editbookgenre'");
			$bookgenre_id_mass = mysqli_fetch_assoc($bookgenreid_query);
	        $editbookgenre_id = $bookgenre_id_mass['id'];

			/*Дата добавления и окнчания*/
			$addtime = time();
	    
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
		       if (($_FILES['uploadfile']['type'] == 'image/gif' || $_FILES['uploadfile']['type'] == 'image/jpeg' || $_FILES['uploadfile']['type'] == 'image/png') && ($uploadfilesize <= 1024000) && ($uploadfilesize != 0)) {
		        	$uploadfile = $uploaddir.$addtime.'.'.$p;
			        copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
					$editbook = $connect->query("UPDATE `books` SET `booktitle` = '$edittitlebook', `bookgenre_id` = '$editbookgenre_id', `price` = '$editpricebook', `imgbookurl` = '$uploadfile' WHERE `id` = '$editbookid'");
							if ($editbook) {
								header("Location: profile.php?editbook=1");
							} else {
								header("Location: profile.php?editbook=2");
							}
				} else if ($uploadfilesize == 0) {
					$editbook = $connect->query("UPDATE `books` SET `booktitle` = '$edittitlebook', `bookgenre_id` = '$editbookgenre_id', `price` = '$editpricebook' WHERE `id` = '$editbookid'");
					if ($editbook) {
						header("Location: profile.php?editbook=1");
					} else {
						header("Location: profile.php?editbook=2");
					}
				} else {
					header("Location: profile.php?editbook=2");
				}
			} //Конец добавление книги




	}// Конец isset($_GET['editbookid'])


		

		


}// Конец $_SESSION['userlogin']

	/*Подстановка жанра в поле селект лист*/
	$getbookgenre = $connect->query("SELECT `id`,`genre` FROM `bookgenre`");
	$getbookgenre_res = '';
	while($getbookgenre_mass = mysqli_fetch_assoc($getbookgenre)) {
	  		$getbookgenre_res .= '<option value = "'.$getbookgenre_mass['id'].'">'.$getbookgenre_mass['genre'].'</option>';
	}

	
	/*Запрет на посещение устаревших книг*/
	if (isset($_GET['noactivebookid']) && !$_SESSION['userlogin']) {
		header("Location: profile.php");
	}

	/*Вывод имя профиля*/
	function nameinprofile() {
		global $connect;
		global $profile_user_id;
		$userlogininprofile_query = $connect->query("SELECT `id`, `login`, `password`,`email`,`telephone`,`city_id`,`street`,`building` FROM `users` WHERE `id` = '$profile_user_id'");
		$userlogininprofile_mass = mysqli_fetch_assoc($userlogininprofile_query);
		$userlogininprofile = $userlogininprofile_mass['login'];
		echo '<h3 class="text-center">Профиль пользователя - ' .$userlogininprofile. '</h3>';
		echo '<br>';
	}


//ФИЛЬТРЫ НА ГЛАВНОЙ!!!!!!!!!!!!!!!!!!!!!
//ЖАНР
//Переменные
	
	$filtersearch_value = '';
	$filtercity_value = '';
	$filterbookgenre_value = '';
	$filterbookgenre = '';
	$allgenres_all = '';
	$book_genre_name = '';
	$allsearch_all = '';
	
	$allgenres = "Все жанры";

	//Обработчик формы
	if(isset($_POST['filtersearch']) && isset($_POST['filtercity']) && isset($_POST['filterbookgenre'])) {
		$filtersearch = htmlspecialchars($_POST['filtersearch']);
		$filtercity = htmlspecialchars($_POST['filtercity']); 

		$filtercity_query = $connect->query("SELECT `id`, `city` FROM `citys` WHERE `city` = '$filtercity'");
		$filtercity_query_mass = mysqli_fetch_assoc($filtercity_query);
		$filtercity = $filtercity_query_mass['id'];

		$filterbookgenre_post = htmlspecialchars($_POST['filterbookgenre']);
		$filterbookgenre = ""; 
		if (is_numeric($filterbookgenre_post)) {
			$filterbookgenre = htmlspecialchars(trim($_POST['filterbookgenre'])); 
		} else if ($filterbookgenre_post == $allgenres) {
			$filterbookgenre = $allgenres;
		} else {
			$book_genre_id_query = $connect->query("SELECT `id`, `genre` FROM `bookgenre` WHERE `genre` = '$filterbookgenre_post'");
			$book_genre_id_query_mass = mysqli_fetch_assoc($book_genre_id_query);
			$filterbookgenre = $book_genre_id_query_mass['id'];
		}


		//Если указан текст, город и жанр
		if (($filtersearch != "") && ($filtercity != "") && ($filterbookgenre != $allgenres)) {
			header("Location: ?page=1&filtersearch=$filtersearch&filtercity=$filtercity&filterbookgenre=$filterbookgenre");
		//Если указан текст и город
		} else if (($filtersearch != "") && ($filtercity != "") && ($filterbookgenre == $allgenres)) {
			header("Location: ?page=1&filtersearch=$filtersearch&filtercity=$filtercity&filterbookgenre=$allgenres");
		//Если указан город и жанр
		} else if (($filtersearch == "") && ($filtercity != "") && ($filterbookgenre != $allgenres)) {
			header("Location: ?page=1&filtercity=$filtercity&filterbookgenre=$filterbookgenre");
		//Если указан текст и жанр
		} else if (($filtersearch != "") && ($filtercity == "") && ($filterbookgenre != $allgenres)) {
			header("Location: ?page=1&filtersearch=$filtersearch&filterbookgenre=$filterbookgenre");
		//Если указан текст
		} else if (($filtersearch != "") && ($filtercity == "") && ($filterbookgenre == $allgenres)) {
			header("Location: ?page=1&filtersearch=$filtersearch&filterbookgenre=$allgenres");
		//Если указан город
		} else if (($filtersearch == "") && ($filtercity != "") && ($filterbookgenre == $allgenres)) {
			header("Location: ?page=1&filtercity=$filtercity&filterbookgenre=$allgenres");
		//Если указан жанр
		} else if (($filtersearch == "") && ($filtercity == "") && ($filterbookgenre != $allgenres)) {
			header("Location: ?page=1&filterbookgenre=$filterbookgenre");
		//Если все жанры
		} else if (($filtersearch == "") && ($filtercity == "") && ($filterbookgenre == $allgenres)) {
			header("Location: ?page=1");
		} 

		
	} 

	if ($_SESSION['userlogin']) {
		$userlogin = $_SESSION['userlogin'];
		$userdatequery = $connect->query("SELECT * FROM `users` WHERE `login` = '$userlogin'");
		$userdatequery_mass = mysqli_fetch_assoc($userdatequery);
	    $usercity_id = $userdatequery_mass['city_id'];
	    $usercity_query = $connect->query("SELECT `city` FROM `citys` WHERE `id` = '$usercity_id'");
		$usercity_id_true = mysqli_fetch_assoc($usercity_query);
	    $usercity = $usercity_id_true['city'];

	    $allcitys_all = $usercity;
	    if(!empty($_POST['filtercity'])) {
	    	$filtercity = htmlspecialchars($_POST['filtercity']);
	    	$allcitys_all = htmlspecialchars($_POST['filtercity']);
	    } else {
	    	$filtercity = "";
	    	$allcitys_all = ""; //!!!!
	    }

	}
	
	


//На любой странице, если есть фильтр от жанров выводить жанр
	if (isset($_GET['filterbookgenre'])) {
		$filterbookgenre_get = $_GET['filterbookgenre'];
		$book_genre_id_query = $connect->query("SELECT `id`, `genre` FROM `bookgenre` WHERE `id` = '$filterbookgenre_get'");
		$book_genre_id_query_mass = mysqli_fetch_assoc($book_genre_id_query);
		$book_genre_name = $book_genre_id_query_mass['genre'];
		if($book_genre_name != "") {
			$allgenres_all = '<option value = "'.$book_genre_name.'">'.$book_genre_name.'</option>';
		} else {
			$allgenres_all = '<option value = "'.$filterbookgenre_get.'">'.$filterbookgenre_get.'</option>';
		}
	}

	if (isset($_GET['filtercity'])) {
		$filtercity = $_GET['filtercity'];
		$filtercity_id = $connect->query("SELECT `id`,`city` FROM `citys` WHERE `id` = '$filtercity'");
		$filtercity_id_mass = mysqli_fetch_assoc($filtercity_id);
		$filtercity_id_res = $filtercity_id_mass['city'];
		$allcitys_all = $filtercity_id_res;
	}

	if (isset($_GET['filtersearch'])) {
		$allsearch_all = $_GET['filtersearch'];
	}

	/*Вывод книг на главную страницу*/
	function booksonmain() {
		global $connect;
		global $filtersearch_value;
		global $filtercity_value;
		global $filterbookgenre_value;
		global $allgenres_all;
		global $allgenres;
		$filterbookgenre = $allgenres;


		
			//Работа со страницами
			$quantity = 2; // Кол-во книг на странице
			$limit = 3; // Страниц ..
			$page=$_GET['page'];
			if(!is_numeric($page)) { $page=1; }
			if ($page<1) { $page=1; }
			$cout_rows_query = $connect->query("SELECT * FROM `books`");
			$cout_rows = mysqli_num_rows($cout_rows_query);
			$pages = $cout_rows/$quantity;
			$pages = ceil($pages);
			$pages++;
			if ($page>$pages) { $page = 1; }
			if (!isset($list)) { $list=0; }
			$list =-- $page*$quantity;
		
		

		if (isset($_GET['filtersearch']) && isset($_GET['filtercity']) && isset($_GET['filterbookgenre']) || 
			isset($_GET['filtersearch']) && isset($_GET['filtercity']) ||
			isset($_GET['filtercity']) && isset($_GET['filterbookgenre']) ||
			isset($_GET['filtersearch']) && isset($_GET['filterbookgenre']) ||
			isset($_GET['filtersearch']) || isset($_GET['filtercity']) || isset($_GET['filterbookgenre'])) {

			/*$filtersearch = htmlspecialchars($_GET['filtersearch']);
			$filtercity = htmlspecialchars($_GET['filtercity']);
			$filterbookgenre = htmlspecialchars($_GET['filterbookgenre']);*/

			if($_GET['filtersearch'] != "") {
				$filtersearch = htmlspecialchars($_GET['filtersearch']);
			} else {
				$filtersearch = "";
			}
			
			if($_GET['filtercity'] != "") {
				$filtercity = htmlspecialchars($_GET['filtercity']);
			} else {
				$filtercity = "";
			}

			if($_GET['filterbookgenre'] != $allgenres) {
				$filterbookgenre = htmlspecialchars($_GET['filterbookgenre']);
			} else {
				$filterbookgenre = $allgenres;
			}


			//Запрос на все текст, город и жанр
			if (!empty($filtersearch) && !empty($filtercity) && ($filterbookgenre != $allgenres)) {
				$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
				$filtercity_value = "AND `city_id` = '$filtercity'";
				$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filtersearch=$filtersearch&filtercity=$filtercity&filterbookgenre=$filterbookgenre";
			//Если текст, город и все жанры
			} if (!empty($filtersearch) && !empty($filtercity) && ($filterbookgenre == $allgenres)) {
				$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
				$filtercity_value = "AND `city_id` = '$filtercity'";
				$resulturl = "&filtersearch=$filtersearch&filtercity=$filtercity&filterbookgenre=$filterbookgenre";
			//Если текст и все жанры
			} else if (!empty($filtersearch) && empty($filtercity) && ($filterbookgenre == $allgenres)) {
				$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
				$resulturl = "&filtersearch=$filtersearch";
			//Если указан город и жанр
			} else if (empty($filtersearch) && !empty($filtercity) && ($filterbookgenre != $allgenres)) {
				$filtercity_value = "WHERE `city_id` = '$filtercity'";
				$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filtercity=$filtercity&filterbookgenre=$filterbookgenre";
			//Если указан жанр
			} else if (empty($filtersearch) && empty($filtercity) && ($filterbookgenre != $allgenres)) {
				$filterbookgenre_value = "WHERE `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filterbookgenre=$filterbookgenre";
			//Если указан текст и жанр
			} else if (!empty($filtersearch) && empty($filtercity) && ($filterbookgenre != $allgenres)) {
				$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
				$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filtersearch=$filtersearch&filterbookgenre=$filterbookgenre";
			//Если указан город и все жанры
			} else if (empty($filtersearch) && !empty($filtercity) && ($filterbookgenre == $allgenres)) {
				$filtercity_value = "WHERE `city_id` = '$filtercity'";
				$resulturl = "&filtercity=$filtercity&filterbookgenre=$filterbookgenre";
			//Если ничего не указано и все жанры
			} else if (empty($filtersearch) && empty($filtercity) && ($filterbookgenre == $allgenres)) {
				$resulturl = "";
			}

			
				$quantity = 2; // Кол-во книг на странице
				$limit = 3; // Страниц ..
				$page=$_GET['page'];
				if(!is_numeric($page)) { $page=1; }
				if ($page<1) { $page=1; }
				$cout_rows_query = $connect->query("SELECT * FROM `books` $filtersearch_value $filtercity_value $filterbookgenre_value");
				$cout_rows = mysqli_num_rows($cout_rows_query);
				$pages = $cout_rows/$quantity;
				$pages = ceil($pages);
				$pages++;
				if ($page>$pages) { $page = 1; }
				if (!isset($list)) { $list=0; }
				$list =-- $page*$quantity;
			


			$booksrow = $connect->query("SELECT * FROM `books` $filtersearch_value $filtercity_value $filterbookgenre_value ORDER BY `id` DESC LIMIT $quantity OFFSET $list");
		//Вывести книги на главной без какого либо запроса
		} else {
			$booksrow = $connect->query("SELECT * FROM `books` $filtersearch_value $filtercity_value $filterbookgenre_value ORDER BY `id` DESC LIMIT $quantity OFFSET $list");
		}



		while($booksrow_res = mysqli_fetch_assoc($booksrow)) {
			echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
				$booksrow_res['id'];
				echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
				echo '<div class="books-block-gradient"></div>';
				echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
				echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
				echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';

			echo "</div></a>";
		}

	
		echo '<div class="clearfix"></div><div class="pagebottons"><ul class="pagination pagination-danger">';
		if ($page>=1) {
    		echo '<li><a href="/?page=1'.$resulturl.'"><<</a></li>';
   			echo '<li><a href="/?page=' . $page . ''.$resulturl.'">< </a></li>';
		}

		$thispage = $page+1;
		$start = $thispage-$limit;
		$end = $thispage+$limit;
		for ($j = 1; $j<$pages; $j++) {
		    if ($j>=$start && $j<=$end) {

		        // Ссылка на текущую страницу выделяется жирным
		        if ($j==($page+1)) echo '<li class="active"><a href="/?page=' . $j . ''.$resulturl.'">' . $j . '</a></li>';

		        // Ссылки на остальные страницы
		        else echo '<li><a href="/?page=' . $j . ''.$resulturl.'">' . $j . '</a></li>';
		    }
		}

		if ($j>$page && ($page+2)<$j) {
		    echo '<li><a href="/?page=' . ($page+2) . ''.$resulturl.'"> ></a></li>';
		    echo '<li><a href="/?page=' . ($j-1) . ''.$resulturl.'">>></a></li>';
		}
		echo '</ul><div>';
			
		
	} //booksonmain()






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
		$book_text = $bookquery_res['textbook'];

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


	/*Страница профиля*/
	function profile_booksonmain() {

	global $connect;
	if (isset($_GET['userid'])) {
		global $profile_user_id;
		$profile_user_id = $_GET['userid'];
		nameinprofile();
		$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `user_id` = '$profile_user_id'");
		while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
				echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
					$booksrow_res['id'];
					echo '<img class="bgbooks" src="http://localhost:88/' .$booksrow_res['imgbookurl']. '"> ';
					echo '<div class="books-block-gradient"></div>';
					echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
					echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
					echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';

				echo "</div></a>";
			}
		}
	}


	/*Перенос данных по книге в новую таблицу и удаление из старой*/
	$transfer_book_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `books`");
	while($transfer_book_mass = mysqli_fetch_assoc($transfer_book_query)) {
		$transfer_book_id = $transfer_book_mass['id'];
		$transfer_book_end_time = $transfer_book_mass['endtime'];
			if ($transfer_book_end_time < time()) {
				$connect->query("INSERT INTO `booksold` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id`) SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `books` WHERE `id`='$transfer_book_id'");
				$connect->query("DELETE FROM `books` WHERE `id`='$transfer_book_id'");
			}
	}



	//Перенос устаревшей книги после поднятия
	$transfer_book_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `booksold`");
	while($transfer_book_mass = mysqli_fetch_assoc($transfer_book_query)) {
		$transfer_book_id = $transfer_book_mass['id'];
		$transfer_book_end_time = $transfer_book_mass['endtime'];
			if ($transfer_book_end_time > time()) {
				$connect->query("INSERT INTO `books` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id`) SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id` FROM `booksold` WHERE `id`='$transfer_book_id'");
				$connect->query("DELETE FROM `booksold` WHERE `id`='$transfer_book_id'");
			}
	}
?>