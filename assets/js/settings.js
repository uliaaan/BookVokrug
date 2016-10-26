$(document).ready(function(){
	var fields = ["login", "password1",];

	$(".form").submit(function(){
	/*Флаг заполнения обязательных полей*/
		var error = 0;
		/*Выбираем все поля*/
		$(".form").find(":input").each(function() {  
			/*Работаем по каждому полю*/
			for(var i = 0; i < fields.length; i++) {
				/*Если это поле есть в массиве*/
				if($(this).attr("name") == fields[i]) {
					/*Если поле не заполнено*/
					if( !$.trim($(this).val()) ) {
						$(this).addClass("error-input");
						error = 1;
					} else {
						/*Если поле заполнено*/
						$(this).removeClass("error-input");
					}
				}
			}
		});

		/*Проверка перед отправкой*/
		if(error == 0) {
			return true;
		} else {
			var err_text = "";
			if(error) err_text += "Заполните красные поля!";
			$("#err_text_form").hide().fadeIn(500).html(err_text);
			return false;
		}
	});
});