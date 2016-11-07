<? include ('header.php') ?>
<? if ($_SESSION['userlogin']) { ?>
<section id="add-book" class="section-with-space">
	<div class="container center-block text-center">
		<div class="row">

		<? echo $select_table_book_res; ?> 
			<h4 class="text-center">Добавить книгу</h4>
			<form method="post" class="form" enctype="multipart/form-data">
				<div class="form-inline">
					<label>Название книги</label>
					<div class="input-add-book">
						<input name="edittitlebook" type="text" id="addtitlebook" class="form-control second-role" value="<? echo $booktitle; ?>">
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Жанр</label>
					<div class="input-add-book">
						<select name="editbookgenre" class="form-control second-role" id="addgenre">
						 	<? echo '<option value = "'.$book_genre_id.'">'.$book_genre_name.'</option>' ?>
						 	<? echo $getbookgenre_res; ?>
						</select>
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Цена</label>
					<div class="input-add-book">
						<div class="input-group">
	                      <input name="editpricebook" type="text" id="addpricebook" maxlength="7" class="form-control second-role" value="<? echo $book_price; ?>">
	                      <span class="input-group-addon"><i class="fa fa-rub" aria-hidden="true"></i></span>
	                    </div>
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Фото</label>
					<div class="input-add-book">
						<input name="uploadfile" type="file" id="uploadfile" onchange="readURL(this);" />
						<img  src="<? echo $book_imgbookurl; ?>" id="imgwiev"/>
					</div>
				</div>
				
				
				<button name="submit" type="submit" id="editbook" class="btn btn-success center-block">Сохранить изменения</button>
			</form>
		</div>
	</div>
</section>
<? } else {
    header("Location: / ");
    } ?>
<? include ('footer.php') ?>
