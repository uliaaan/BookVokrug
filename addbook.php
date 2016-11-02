<? include ('header.php') ?>
<? if ($_SESSION['userlogin']) { ?>
<section id="add-book" class="section-with-space">
	<div class="container center-block text-center">
		<div class="row">
			<h4 class="text-center">Добавить книгу</h4>
			<form method="post" class="form">
				<div class="form-inline">
					<label>Название книги</label>
					<div class="input-add-book">
						<input name="addtitlebook" type="text" id="addtitlebook" class="form-control second-role">
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Жанр</label>
					<div class="input-add-book">
						<select class="form-control second-role" id="addgenre">
						 	<? echo $getbookgenre_res; ?>
						</select>
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Описание</label>
					<div class="input-add-book">
						<textarea name="addtextbook" type="text" id="addtextbook" class="form-control second-role"></textarea>
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Цена</label>
					<div class="input-add-book">
						<div class="input-group">
	                      <input name="addpricebook" type="text" id="addpricebook" maxlength="7" class="form-control second-role" value="0">
	                      <span class="input-group-addon"><i class="fa fa-rub" aria-hidden="true"></i></span>
	                    </div>
						<div class="reg-red-text"></div>
					</div>
				</div>
				<div class="form-inline">
					<label>Фото</label>
					<div class="input-add-book">
						<input type="file" onchange="readURL(this);" />
						<img id="imgwiev"/>
					</div>
				</div>
				
				
				<button name="submit" type="submit" id="submit-add-book" class="btn btn-success center-block" disabled>Добавить книгу</button>
			</form>
		</div>
	</div>
</section>
<? } else {
    header("Location: / ");
    } ?>
<? include ('footer.php') ?>
