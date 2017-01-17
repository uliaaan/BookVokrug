var login,
	email,
	password,
	telephone,
	city,
	filtercity,
	street,
	addtitlebook,
	loginStat,
	building,
	passwordlate,
	addtitlebookStat,
	passwordlateStat,
	emailStat,
	passwordStat,
	telephoneStat,
	cityStat,
	streetStat,
	buildingStat;

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
					buttonOnAndOffRedact();			
				}else{					
					$("#login").removeClass().addClass("form-control inputGreen");
					$("#login").next().text("");
					loginStat = 1;
					buttonOnAndOff();
					buttonOnAndOffRedact();
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
			buttonOnAndOffRedact();
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
					buttonOnAndOffRedact();				
				}else{					
					$("#email").removeClass().addClass("form-control inputGreen");
					$("#email").next().text("");
					emailStat = 1;
					buttonOnAndOff();
					buttonOnAndOffRedact();	
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
	$("#password").mouseout(function(){
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

	//Телефон
	$("#telephone").change(function(){
		telephone = $("#telephone").val();
		if(telephone.length < 10){
			$("#telephone").next().hide().text("Слишком короткий номер").css("color","red").fadeIn(400);
			$("#telephone").removeClass().addClass("form-control inputRed");
			telephoneStat = 0;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}else{
			$("#telephone").removeClass().addClass("form-control inputGreen");
			$("#telephone").next().text("");
			telephoneStat = 1;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}		
	});
	$("#telephone").keyup(function(){
		$("#telephone").removeClass("inputGreen");
		$("#telephone").removeClass("inputRed");
		$("#telephone").next().text("");
	});

	/*Обработчик для проверки ввода чисел в поле телефона*/
	document.getElementsByName("telephone")[0].onkeypress = function(e) {
      e = e || event;
      if (e.ctrlKey || e.altKey || e.metaKey) return;
      var chr = getChar(e);
      if (chr == null) return;
      if (chr < '0' || chr > '9') {
        return false;
      }
    }

    function getChar(event) {
      if (event.which == null) {
        if (event.keyCode < 32) return null;
        return String.fromCharCode(event.keyCode) // IE
      }

      if (event.which != 0 && event.charCode != 0) {
        if (event.which < 32) return null;
        return String.fromCharCode(event.which) // остальные
      }

      return null; // специальная клавиша
    }
	
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
		if(emailStat == 1 && passwordStat == 1 && loginStat == 1 && telephoneStat == 1 && cityStat == 1){
			$("#submit").removeAttr("disabled");
		}else{
			$("#submit").attr("disabled","disabled");
		}
	
	}
	

	//Город автоподстановка в регистрацию и подстановка в фильтр
	$("#city, #filtercity").autocomplete({
        source: 'functions.php',
        minLength: 3
    });


	//Город сравнение 
	// CLICK НУЖНО ИСПРАВИТЬ!!!!!!!!!!!!!!!
	$("#street").focus(function(){
		city = $("#city").val();
			if (city != "") {
			$.ajax({
			url: "functions.php",
			type: "GET",
			data: "city=" + city,
			cache: false,
			success: function(response){
				if(response == "no"){
					$("#city").next().hide().html("Город введен неверно").css("color","red").fadeIn(400);
					$("#city").removeClass().addClass("form-control inputRed");	
					cityStat = 0;
					buttonOnAndOff();
					buttonOnAndOffRedact();				
				}else{					
					$("#city").removeClass().addClass("form-control inputGreen");
					$("#city").next().text("");
					cityStat = 1;
					buttonOnAndOff();
					buttonOnAndOffRedact();	
				}				
			}
			});
		} else {
			$("#city").next().hide().html("Введите город").css("color","red").fadeIn(400);
			$("#city").removeClass().addClass("form-control inputRed");	
			cityStat = 0;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}	
	});
	$("#city").keyup(function(){
		$("#city").removeClass("inputGreen");
		$("#city").removeClass("inputRed");
		$("#city").next().text("");
	});
	

	//Улица
	$("#street").change(function(){
	street = $("#street").val();
		if(street.length < 1){
			$("#street").next().hide().text("Введите город").css("color","red").fadeIn(400);
			$("#street").removeClass().addClass("form-control input-street inputRed");
			streetStat = 0;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}else{
			$("#street").removeClass().addClass("form-control input-street inputGreen");
			$("#street").next().text("");
			streetStat = 1;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}		
	});
	$("#street").keyup(function(){
		$("#street").removeClass("inputGreen");
		$("#street").removeClass("inputRed");
		$("#street").next().text("");
	});

	//Дома building
	$("#building").change(function(){
	building = $("#building").val();
		if(building.length < 1){
			$("#building").removeClass().addClass("form-control input-street inputRed");
			buildingStat = 0;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}else{
			$("#building").removeClass().addClass("form-control input-street inputGreen");
			$("#building").next().text("");
			buildingStat = 1;
			buttonOnAndOff();
			buttonOnAndOffRedact();
		}		
	});
	$("#building").keyup(function(){
	$("#building").removeClass("inputGreen");
	$("#building").removeClass("inputRed");
	$("#building").next().text("");
	});

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!//
//Редактирование профиля
	//Пароль
	$("#passwordlate").change(function(){
		passwordlate = $("#passwordlate").val(); //записываем значение логина в переменную
		if(passwordlate.length > 0){ //запрос к бд через аджакс
			$.ajax({
			url: "functions.php",
			type: "GET",
			data: "passwordlate=" + passwordlate,
			cache: false,
			success: function(response){
				if(response == "no"){
					$("#passwordlate").next().hide().html("Не верный пароль").css("color","red").fadeIn(400);
					$("#passwordlate").removeClass().addClass("form-control inputRed");
					$("#passwordnew").val("").removeClass("inputGreen inputGreen");
					passwordlateStat = 0;	
					buttonOnAndOffPassword();	
					buttonOnAndOffRedact();		
				}else{					
					$("#passwordlate").removeClass().addClass("form-control inputGreen");
					$("#passwordlate").next().text("");
					passwordlateStat = 1;
					buttonOnAndOffPassword();
					buttonOnAndOffRedact();
				}			
				
			}
			});
			
		}
		
	});
	$("#passwordlate").keyup(function(){
		$("#passwordlate").removeClass("inputGreen");
		$("#passwordlate").removeClass("inputRed");
		$("#passwordlate").next().text("");
	});

	function buttonOnAndOffPassword(){
		if(passwordlateStat == 1){
			$("#passwordnew").removeAttr("disabled");
		}else{
			$("#passwordnew").attr("disabled","disabled");
		}
	
	}
	
	//Новый пароль
	$("#passwordnew").change(function(){
		password = $("#passwordnew").val();
		if(password.length < 6){
			$("#passwordnew").next().hide().text("Слишком короткий пароль").css("color","red").fadeIn(400);
			$("#passwordnew").removeClass().addClass("form-control inputRed");
			passwordStat = 0;
			buttonOnAndOffRedact();
		}else{
			$("#passwordnew").removeClass().addClass("form-control inputGreen");
			$("#passwordnew").next().text("");
			passwordStat = 1;
			buttonOnAndOffRedact();
		}		
	});
	$("#passwordnew").keyup(function(){
		$("#passwordnew").removeClass("inputGreen");
		$("#passwordnew").removeClass("inputRed");
		$("#passwordnew").next().text("");
	});

	/*Кнопка Сохранить изменения*/
	function buttonOnAndOffRedact(){
		if(emailStat == 1 || loginStat == 1 || telephoneStat == 1 || cityStat == 1 || streetStat == 1 || buildingStat == 1 || passwordlateStat == 1 && passwordStat == 1){
			$("#submitredact").removeAttr("disabled");
		}else{
			$("#submitredact").attr("disabled","disabled");
		}
	
	}

//ДОБАВЛЕНИЕ КНИГИ!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	//Обработчик цены
	document.getElementsByName("addpricebook")[0].onkeypress = function(e) {
      e = e || event;
      if (e.ctrlKey || e.altKey || e.metaKey) return;
      var chr = getChar(e);
      if (chr == null) return;
      if (chr < '0' || chr > '9') {
        return false;
      }
    }

    //Заголовок книги
	$("#addtitlebook").change(function(){
	addtitlebook = $("#addtitlebook").val();
		if(addtitlebook.length < 1){
			$("#addtitlebook").next().hide().text("Введите название книги").css("color","red").fadeIn(400);
			$("#addtitlebook").removeClass().addClass("form-control inputRed");
			addtitlebookStat = 0;
			buttonOnAndOffaddbook();
		}else{
			$("#addtitlebook").removeClass().addClass("form-control inputGreen");
			$("#addtitlebook").next().text("");
			addtitlebookStat = 1;
			buttonOnAndOffaddbook();
		}		
	});
	$("#addtitlebook").keyup(function(){
		$("#addtitlebook").removeClass("inputGreen");
		$("#addtitlebook").removeClass("inputRed");
		$("#addtitlebook").next().text("");
	});

	function buttonOnAndOffaddbook() {
		if(addtitlebookStat == 1){
			$("#submitaddbook").removeAttr("disabled");
		} else {
			$("#submitaddbook").attr("disabled","disabled");
		}
	
	}



	
}); //End functions()

	//Изоображение отображаемое сразу после загрузки
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgwiev').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }