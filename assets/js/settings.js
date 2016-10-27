var login,
	email,
	password,
	password2,
	loginStat,
	emailStat,
	passwordStat,
	password2Stat;

$(function() {
	//Логин
	$("#login").change(function(){
		login = $("#login").val(); //записываем значение логина в переменную
		var expLogin = /^[a-zA-Z0-9_]+$/g; //допустимые символы
		var resLogin = login.search(expLogin);
		if(resLogin == -1){
			$("#login").next().hide().text("Неверный логин").css("color","red").fadeIn(400); // к следующему классу
			$("#login").removeClass().addClass("form-control inputRed");
			loginStat = 0;
			buttonOnAndOff();
		}else{ //запрос к бд через аджакс
			$.ajax({
			url: "functions.php",
			type: "GET",
			data: "login=" + login,
			cache: false,
			success: function(response){
				if(response == "no"){
					$("#login").next().hide().html("Логин занят").css("color","red").fadeIn(400);
					$("#login").removeClass().addClass("form-control inputRed");
					loginStat = 0;	
					buttonOnAndOff();			
				}else{					
					$("#login").removeClass().addClass("form-control inputGreen");
					$("#login").next().text("");
					loginStat = 1;
					buttonOnAndOff();
				}			
				
			}
			});
			
		}
		
	});
	$("#login").keyup(function(){
		$("#login").removeClass("inputGreen");
		$("#login").removeClass("inputRed");
		$("#login").next().text("");
	});

		//email
	$("#email").change(function(){
		email = $("#email").val();
		var expEmail = /[-0-9a-z_]+@[-0-9a-z_]+\.[a-z]{2,6}/i;
		var resEmail = email.search(expEmail);
		if(resEmail == -1){
			$("#email").next().hide().text("Неверный формат Email").css("color","red").fadeIn(400);
			$("#email").removeClass().addClass("form-control inputRed");
			emailStat = 0;
			buttonOnAndOff();
		}else{
			$.ajax({
			url: "functions.php",
			type: "GET",
			data: "email=" + email,
			cache: false,
			success: function(response){
				if(response == "no"){
					$("#email").next().hide().html("Email занят").css("color","red").fadeIn(400);
					$("#email").removeClass().addClass("form-control inputRed");	
					emailStat = 0;
					buttonOnAndOff();				
				}else{					
					$("#email").removeClass().addClass("form-control inputGreen");
					$("#email").next().text("");
					emailStat = 1;
					buttonOnAndOff();	
				}			
				
			}
			});
			
		}
		
	});
	$("#email").keyup(function(){
		$("#email").removeClass("inputGreen");
		$("#email").removeClass("inputRed");
		$("#email").next().text("");
	});
	
	
	//Пароль
	$("#password").change(function(){
		password = $("#password").val();
		if(password.length < 6){
			$("#password").next().hide().text("Слишком короткий пароль").css("color","red").fadeIn(400);
			$("#password").removeClass().addClass("form-control inputRed");
			passwordStat = 0;
			buttonOnAndOff();
		}else{
			$("#password").removeClass().addClass("form-control inputGreen");
			$("#password").next().text("");
			passwordStat = 1;
			buttonOnAndOff();
		}		
	});
	$("#password").keyup(function(){
		$("#password").removeClass("inputGreen");
		$("#password").removeClass("inputRed");
		$("#password").next().text("");
	});
	
/*	//Проверка пароля
	$("#password2").change(function(){
		if(password2 != password){
			$("#password2").next().hide().text("Пароли не совпадают").css("color","red").fadeIn(400);
			$("#password2").removeClass().addClass("inputRed");
			password2Stat = 0;
			buttonOnAndOff();
		}else{
			$("#password2").removeClass().addClass("inputGreen");
			$("#password2").next().text("");
		}		
	});
	$("#password2").keyup(function(){
		password2 = $("#password2").val();
		if(password2 == password){
			password2Stat = 1;
			buttonOnAndOff();
		}else{
			password2Stat = 0;
			buttonOnAndOff();
		}
	});*/
	
	function buttonOnAndOff(){
		if(emailStat == 1 && passwordStat == 1 && loginStat == 1){
			$("#submit").removeAttr("disabled");
		}else{
			$("#submit").attr("disabled","disabled");
		}
	
	}
	
});