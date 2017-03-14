<? 
	session_start();
	$connect = mysqli_connect('localhost', 'i96607v1_bd', '12345678','i96607v1_bd');
	date_default_timezone_set('Europe/Moscow');
	ob_start();
    //Переменные 
	$allcitys = "Все города";
	$allgenres = "Все жанры";
	$usercity_session = $_SESSION['usercity']; //Название города

	$usercity_id_null = $usercity_session;
	$usercity_query = $connect->query("SELECT `ID` FROM `rcity` WHERE `Name` = '$usercity_id_null'");
	$usercity_query_mass = mysqli_fetch_assoc($usercity_query);

	$usercity_session_id = $usercity_query_mass['ID']; //ID города

	function title() {
	global $connect;
	$page=$_GET['page'];
	$filterbookgenre = $_GET['filterbookgenre'];

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

    if (($_GET['edituserprofile']) || ($_GET['addbook']) || ($_GET['editbook']) || ($_GET['delbook'])) {
    	echo 'Профиль';
    }


		if($_SERVER['REQUEST_URI'] === '/index.php' || $_SERVER['REQUEST_URI'] === '/') {
			echo 'БУКВОКРУГ - продай или купи книгу';
		} else if ($_SERVER['REQUEST_URI'] === '/?page='.$page) {
			echo 'Страница '.$page;
		} else if ($_SERVER['REQUEST_URI'] === '/?page='.$page.'&filterbookgenre='.$filterbookgenre) {
			$bookgenreid_query = $connect->query("SELECT `id`,`genre` FROM `bookgenre` WHERE `id` = '$filterbookgenre'");
			$bookgenre_id_mass = mysqli_fetch_assoc($bookgenreid_query);
	        $bookgenre_name = $bookgenre_id_mass['genre'];
			echo 'Страница '.$page.' - '.$bookgenre_name;
		} else if (($_SERVER['REQUEST_URI'] === '/book.php?bookid='.$bookid) || ($_SERVER['REQUEST_URI'] === '/book.php?noactivebookid='.$bookid)) {
			echo $booktitle;
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
		} else if ($_SERVER['REQUEST_URI'] === '/rules.php') {
			echo 'Правила';
		} else if ($_SERVER['REQUEST_URI'] === '/citys.php') {
			echo 'Выбор города';
		} else if ($_SERVER['REQUEST_URI'] === '/about.php') {
			echo 'О проекте';
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
		$usercity_id = $connect->query("SELECT `ID` FROM `rcity` WHERE `Name` = '$usercity'");
		$usercity_id_true = mysqli_fetch_assoc($usercity_id);
        $res_city_id = $usercity_id_true['ID'];
		$userstreet = htmlspecialchars(trim($_POST['street'])); 
		$userbuilding = htmlspecialchars(trim($_POST['building'])); 
		$timenow = time();
		$reg_query = $connect->query("INSERT INTO `users` (`id`, `login`, `password`,`email`,`telephone`,`city_id`,`street`,`building`,`datereg`) VALUES ('','$userlogin','$userpassword','$useremail','$usertelephone','$res_city_id','$userstreet','$userbuilding','$timenow')");
			if ($reg_query) {
				$_SESSION['userlogin'] = $userlogin;
				$_SESSION['usercity'] = $usercity;
				header("Location: /");
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
		$double_reg_query = $connect->query("SELECT `Name` FROM `rcity` WHERE `Name` = '$city'");
		$double_reg_query_true = mysqli_fetch_assoc($double_reg_query);
		$res = $double_reg_query_true['Name'];
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
	    $query = $connect->query("SELECT `Name` FROM `rcity` WHERE `Name` LIKE '%".$searchTerm."%' ORDER BY `Name` ASC");
	    while ($row = $query->fetch_assoc()) {
	        $data[] = $row['Name'];
	    }
	    //Возвращение значения
    	echo json_encode($data);
	}

	/*Подстановка жанра в поле селект лист*/
	$getbookgenre = $connect->query("SELECT `id`,`genre` FROM `bookgenre`");
	$getbookgenre_res = '';
	while($getbookgenre_mass = mysqli_fetch_assoc($getbookgenre)) {
	  		$getbookgenre_res .= '<option value = "'.$getbookgenre_mass['id'].'">'.$getbookgenre_mass['genre'].'</option>';
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
    $usercity_query = $connect->query("SELECT `Name` FROM `rcity` WHERE `id` = '$usercity_id'");
	$usercity_id_true = mysqli_fetch_assoc($usercity_query);
    $usercity = $usercity_id_true['Name'];



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
			$usercity_id = $connect->query("SELECT `ID` FROM `rcity` WHERE `Name` = '$usercity'");
			$usercity_id_true = mysqli_fetch_assoc($usercity_id);
	        $res_city_id = $usercity_id_true['ID'];
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
		$addbookgenre = htmlspecialchars($_POST['bookgenre']); 
		$addpricebook = htmlspecialchars(trim($_POST['addpricebook']));
		if ($addpricebook == "") {
				$addpricebook = 0;
			} 
		$addtextbook = htmlspecialchars($_POST['addtextbook']); 
		

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
        if (($_FILES['uploadfile']['type'] == 'image/gif' || $_FILES['uploadfile']['type'] == 'image/jpeg' || $_FILES['uploadfile']['type'] == 'image/png') && ($uploadfilesize <= 1024000) && ($uploadfilesize != 0)) {
        	/*Подстановка пути до картинки*/
        	$uploadfile = $uploaddir.$addtime.'.'.$p;
	        copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
		
			$addbook = $connect->query("INSERT INTO `books` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id`) VALUES ('','$userlogin_id','$addtitlebook','$addbookgenre','$addtextbook','$addpricebook','$uploadfile', '$addtime', '$endtime','$usercity_id')");
					if ($addbook) {
						header("Location: profile.php?addbook=1");

					}
		
		} else if ($uploadfilesize == 0) {
					$addbook = $connect->query("INSERT INTO `books` (`id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime`,`city_id`) VALUES ('','$userlogin_id','$addtitlebook','$addbookgenre','$addtextbook','$addpricebook','', '$addtime', '$endtime','$usercity_id')");
					if ($addbook) {
						header("Location: profile.php?addbook=1");
					} else {
						header("Location: profile.php?addbook=2");
					}
		} else {
			header("Location: profile.php?addbook=2");
		}
		} //Конец добавление книги	
	} //Конец - страница добавления книги


	//Страница редактирования книги
	if (isset($_GET['editbookid'])) {
		$editbookid = $_GET['editbookid'];
		//Супер запрос на поиск из двух таблиц
		$bookquery = $connect->query("SELECT * FROM `books` WHERE `id` = '$editbookid'"); //Запрос на вывод данных по запрошенному айдишник
		while($bookquery_res = mysqli_fetch_assoc($bookquery)) { //Циклом решаем проблему сравнения нескольких полей
				if ($bookquery_res['user_id'] == $userlogin_id) { //Если серв находит второе совпадение - БИНГО
					$booktitle = $bookquery_res['booktitle'];
					$book_price = $bookquery_res['price'];
					$book_imgbookurl = $bookquery_res['imgbookurl'];
					$book_genre_id = $bookquery_res['bookgenre_id'];
					$book_text = $bookquery_res['textbook'];

					/*Данные жанра*/
					$book_genre_id_query = $connect->query("SELECT `id`, `genre` FROM `bookgenre` WHERE `id` = '$book_genre_id'");
					$book_genre_id_query_mass = mysqli_fetch_assoc($book_genre_id_query);
					$editbook_genre_name = $book_genre_id_query_mass['genre'];
				} else {
					header("Location: profile.php");
				}
			}

			/*Запрос страницы редактирования книг*/
			if(isset($_POST['edittitlebook']) and isset($_POST['editbookgenre']) and isset($_POST['editpricebook'])) {
			$edittitlebook = htmlspecialchars($_POST['edittitlebook']); 
			$editpricebook = htmlspecialchars(trim($_POST['editpricebook']));
			if ($editpricebook == "") {
				$editpricebook = 0;
			} 
			$editbookgenre = htmlspecialchars($_POST['editbookgenre']); 
			$edittextbook = htmlspecialchars($_POST['edittextbook']); 
			//Достаем id жанра
			$editbookgenreid_query = $connect->query("SELECT `id`,`genre` FROM `bookgenre` WHERE `id` = '$editbookgenre'");
			$editbookgenre_id_mass = mysqli_fetch_assoc($editbookgenreid_query);
	        $editbookgenre_id = $editbookgenre_id_mass['id'];

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
					$editbook = $connect->query("UPDATE `books` SET `booktitle` = '$edittitlebook', `bookgenre_id` = '$editbookgenre_id',`textbook` = $edittextbook, `price` = '$editpricebook', `imgbookurl` = '$uploadfile' WHERE `id` = '$editbookid'");
							if ($editbook) {
								header("Location: profile.php?editbook=1");
							} else {
								header("Location: profile.php?editbook=2");
							}
				} else if ($uploadfilesize == 0) {
					$editbook = $connect->query("UPDATE `books` SET `booktitle` = '$edittitlebook', `bookgenre_id` = '$editbookgenre_id', `textbook` = $edittextbook, `price` = '$editpricebook' WHERE `id` = '$editbookid'");
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



		/*Вывод профиля*/
		function profile_user() {
		global $connect;
		global $userlogin_id;
		$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `user_id` = '$userlogin_id' ORDER BY `id` DESC");
		while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
				echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
					$booksrow_res['id'];			
					echo '<img class="bgbooks" src="/' .$booksrow_res['imgbookurl']. '"> ';
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
			$profile_user_id = $_GET['userid'];
			
				if ($profile_user_id == $userlogin_id) {
					header("Location: profile.php");
				} else {
					nameinprofile();
					$profile_query = $connect->query("SELECT `id`, `user_id`, `booktitle`,`bookgenre_id`,`textbook`,`price`,`imgbookurl`,`addtime`,`endtime` FROM `books` WHERE `user_id` = '$profile_user_id'");
						while($booksrow_res = mysqli_fetch_assoc($profile_query)) {
							echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
								$booksrow_res['id'];
								echo '<img class="bgbooks" src="/' .$booksrow_res['imgbookurl']. '"> ';
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
					echo '<img class="bgbooks" src="/' .$booksrow_res['imgbookurl']. '"> ';
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




}// Конец $_SESSION['userlogin']
	
	
	
/*Запрет на посещение устаревших книг*/
if (isset($_GET['noactivebookid']) && !$_SESSION['userlogin']) {
	header("Location: profile.php");
}

/*Вывод имя профиля*/
function nameinprofile() {
	global $connect;
	$profile_user_id = $_GET['userid'];
	$userlogininprofile_query = $connect->query("SELECT `id`, `login`, `password`,`email`,`telephone`,`city_id`,`street`,`building`,`datereg` FROM `users` WHERE `id` = '$profile_user_id'");
	$userlogininprofile_mass = mysqli_fetch_assoc($userlogininprofile_query);
	$userlogininprofile = $userlogininprofile_mass['login'];
	$profileuser_daterig = $userlogininprofile_mass['datereg'];
	$profileuser_daterig_onair = (time() - $profileuser_daterig)/86400 + 1;
	$profileuser_city_id = $userlogininprofile_mass['city_id'];
	$profileuser_city_query = $connect->query("SELECT `Name` FROM `rcity` WHERE `ID` = '$profileuser_city_id'");
	$profileuser_city_mass = mysqli_fetch_assoc($profileuser_city_query);
	$profileuser_city_name = $profileuser_city_mass['Name'];
	echo '<h3 class="text-center profileuser-title">Профиль пользователя - ' .$userlogininprofile. '<br><span class="profileuser-undertitle">г. ' .$profileuser_city_name. ' - ' .round($profileuser_daterig_onair, 0). ' дней на сайте</span></h3>';
	echo '<br>';
}


//ФИЛЬТРЫ НА ГЛАВНОЙ!!!!!!!!!!!!!!!!!!!!!
//Переменные	
$filtersearch_value = '';
$filterbookgenre_value = '';
$filterbookgenre = '';
$allgenres_all = '';
$book_genre_name = '';
$allsearch_all = '';
	
//Обработчик формы фильтрации
if(isset($_POST['filtersearch']) && isset($_POST['filterbookgenre'])) {
	$filtersearch = htmlspecialchars($_POST['filtersearch']);
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

	//Если указан текст и жанр
	if (($filtersearch != "") && ($filterbookgenre != $allgenres)) {
		header("Location: ?page=1&filtersearch=$filtersearch&filterbookgenre=$filterbookgenre");
	//Если указан текст
	} else if (($filtersearch != "") && ($filterbookgenre == $allgenres)) {
		header("Location: ?page=1&filtersearch=$filtersearch&filterbookgenre=$allgenres");
	//Если указан жанр
	} else if (($filtersearch == "") && ($filterbookgenre != $allgenres)) {
		header("Location: ?page=1&filterbookgenre=$filterbookgenre");
	//Если все жанры
	} else if (($filtersearch == "") && ($filterbookgenre == $allgenres)) {
		header("Location: ?page=1");
	} 	
} // Конец обработчика формы фильтрации


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

if (isset($_GET['filtersearch'])) {
	$allsearch_all = $_GET['filtersearch'];
}

/*Вывод книг на главную страницу*/
function booksonmain() {
	global $connect;
	//Подключение общих переменных
	global $allcitys;
	global $usercity_session;
	global $usercity_session_id;
	global $filtersearch_value;
	global $filterbookgenre_value;
	global $allgenres_all;
	global $allgenres;
	$filtercity_value = "";
	$filterbookgenre = $allgenres;

	//Работа с выодом ВСЕ ГОРОДА или определенный ГОРОД
	if ($usercity_session == $allcitys) {
		$filtercity_value = "";
	} else if (empty($usercity_session)) {
		$filtercity_value = "";
	} else {
		$filtercity_value = "WHERE `city_id` = '$usercity_session_id'";
	}

	//Работа со страницами
	$quantity = 20; // Кол-во книг на странице
	$limit = 3; // Страниц ..
	$page=$_GET['page'];
	if(!is_numeric($page)) { $page=1; }
	if ($page<1) { $page=1; }
	$cout_rows_query = $connect->query("SELECT * FROM `books` $filtercity_value");
	$cout_rows = mysqli_num_rows($cout_rows_query);
	$pages = $cout_rows/$quantity;
	$pages = ceil($pages);
	$pages++;
	if ($page>$pages) { $page = 1; }
	if (!isset($list)) { $list=0; }
	$list =-- $page*$quantity;
	
	

	if (isset($_GET['filtersearch']) && isset($_GET['filterbookgenre']) ||
		isset($_GET['filtersearch']) || isset($_GET['filterbookgenre'])) {
		if($_GET['filtersearch'] != "") {
			$filtersearch = htmlspecialchars($_GET['filtersearch']);
		} else {
			$filtersearch = "";
		}

		if($_GET['filterbookgenre'] != $allgenres) {
			$filterbookgenre = htmlspecialchars($_GET['filterbookgenre']);
		} else {
			$filterbookgenre = $allgenres;
		}


		
		
		
		

		if ($usercity_session == $allcitys) {
			$filtercity_value = "";
			//Если текст и все жанры
			if (!empty($filtersearch) && ($filterbookgenre == $allgenres)) {
			$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
			$resulturl = "&filtersearch=$filtersearch";
			//Если указан жанр
			} else if (empty($filtersearch) && ($filterbookgenre != $allgenres)) {
			$filterbookgenre_value = "WHERE `bookgenre_id` = '$filterbookgenre'";
			$resulturl = "&filterbookgenre=$filterbookgenre";
			//Если указан текст и жанр
			} else if (!empty($filtersearch) && ($filterbookgenre != $allgenres)) {
			$filtersearch_value = "WHERE `booktitle` LIKE '%".$filtersearch."%'";
			$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
			$resulturl = "&filtersearch=$filtersearch&filterbookgenre=$filterbookgenre";
			//Если ничего не указано и все жанры
			} else if (empty($filtersearch) && ($filterbookgenre == $allgenres)) {
			$resulturl = "";
			}
		} else {
			$filtercity_value = "WHERE `city_id` = '$usercity_session_id'";
		 	//Если текст и все жанры
			if (!empty($filtersearch) && ($filterbookgenre == $allgenres)) {
				$filtersearch_value = "AND `booktitle` LIKE '%".$filtersearch."%'";
				$resulturl = "&filtersearch=$filtersearch";
			//Если указан жанр
			} else if (empty($filtersearch) && ($filterbookgenre != $allgenres)) {
				$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filterbookgenre=$filterbookgenre";
			//Если указан текст и жанр
			} else if (!empty($filtersearch) && ($filterbookgenre != $allgenres)) {
				$filtersearch_value = "AND `booktitle` LIKE '%".$filtersearch."%'";
				$filterbookgenre_value = "AND `bookgenre_id` = '$filterbookgenre'";
				$resulturl = "&filtersearch=$filtersearch&filterbookgenre=$filterbookgenre";
			//Если ничего не указано и все жанры
			} else if (empty($filtersearch) && ($filterbookgenre == $allgenres)) {
				$resulturl = "";
			}
		}

		
			$quantity = 20; // Кол-во книг на странице
			$limit = 3; // Страниц ..
			$page=$_GET['page'];
			if(!is_numeric($page)) { $page=1; }
			if ($page<1) { $page=1; }
			$cout_rows_query = $connect->query("SELECT * FROM `books` $filtercity_value $filtersearch_value $filterbookgenre_value");
			$cout_rows = mysqli_num_rows($cout_rows_query);
			$pages = $cout_rows/$quantity;
			$pages = ceil($pages);
			$pages++;
			if ($page>$pages) { $page = 1; }
			if (!isset($list)) { $list=0; }
			$list =-- $page*$quantity;
		

		//Вывести книги на главной через фильтр и запрос
		$booksrow = $connect->query("SELECT * FROM `books` $filtercity_value $filtersearch_value $filterbookgenre_value ORDER BY `id` DESC LIMIT $quantity OFFSET $list");
	} else {
		//Вывести книги на главной без какого либо запроса
		$booksrow = $connect->query("SELECT * FROM `books` $filtercity_value ORDER BY `id` DESC LIMIT $quantity OFFSET $list");
	}// Конец isset($_GET['filtersearch']) && isset($_GET['filterbookgenre']

	if (mysqli_num_rows($booksrow) > 0) {
		while($booksrow_res = mysqli_fetch_assoc($booksrow)) {
			echo '<a href="book.php?bookid=' .$booksrow_res['id']. '"><div class="books-block">';
				$booksrow_res['id'];
				echo '<img class="bgbooks" src="/' .$booksrow_res['imgbookurl']. '"> ';
				echo '<div class="books-block-gradient"></div>';
				echo '<div class="bookprice">' .$booksrow_res['price']. ' &#8381;</div>';
				echo '<div class="bookline"><div style="color: #fff; display: inline;">БУК</div>ВОКРУГ</div>';
				echo '<div class="bookname"><div class="booknameinner">' .$booksrow_res['booktitle']. '</div></div>';
			echo "</div></a>";
		}
	} else {
		echo '<div class="text-center"><h3>К сожалению, по Вашему запросу ничего не найдено</h3></div>';
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
	$book_user_city_id = $book_user_id_query_mass['city_id'];
	$book_user_city_id_query = $connect->query("SELECT `ID`, `Name` FROM `rcity` WHERE `ID` = '$book_user_city_id'");
	$book_user_city_id_query_mass = mysqli_fetch_assoc($book_user_city_id_query);
	$book_user_city = $book_user_city_id_query_mass['Name'];

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
					echo '<img class="bgbooks" src="/' .$booksrow_res['imgbookurl']. '"> ';
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