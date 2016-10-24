<? 
	session_start();
	$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');

	if(isset($_POST['login']) and isset($_POST['password'])) {
			$userlogin = htmlspecialchars(trim($_POST['login']));
			$userpassword = htmlspecialchars(trim($_POST['password']));
			$my_query = $connect->query("SELECT `login`,`password` FROM `users` WHERE `login` = '$userlogin' AND `password` = '$userpassword'");
			$result = $my_query->fetch_assoc();
			if ($result) {
				$_SESSION['userlogin'] = $userlogin;
			}
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