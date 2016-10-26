<?
session_start();
$connect = mysqli_connect('localhost', 'root', '12345678','bookvokrug');

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

?>