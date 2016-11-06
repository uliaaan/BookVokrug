<? include ('header.php') ?>
<section id="bookpage" class="section-with-space">
	<div class="container center-block text-center">
		<div class="bookmb">
			<div class="bookmb-title"><h3><? echo $booktitle; ?></h3></div>
			<div class="bookmb-main">
			<div class="bookmb-left">
				<div class="bookmb-img">
					<span class="bookmb-img-bg" style="background-image: url(/<? echo $book_imgbookurl; ?>);"></span>
					<img class="bgbooks" src="http://localhost:88/<? echo $book_imgbookurl; ?>">
					<div class="bookmb-price"><? echo $book_price; ?></div>
				</div>
			</div>
			<div class="bookmb-right">
				<div class="bookmb-info">
					<div class="bookmb-info-top">№ <? echo $bookid; ?>, размещено <? echo date('Y-m-d', $book_addtime); ?> в <? echo date('H:i', $book_addtime); ?>
					</div>					 
					<br>
					<div class="bookmb-info-main">
						<h6><small>Жанр</small><br>
							<? echo $book_genre_name; ?></h6>
						<h6><small>Цена</small><br>
							<? echo $book_price; ?> &#8381;</h6>
						<h6><small>Осталось дней:</small><br> 
							<? echo (int)$book_day_to_zero; ?></h6>
						<h6><small>Продавец</small><br>
							<a href="profile.php?userid=<? echo$book_user_id; ?>"><? echo $book_user_login; ?></a></h6>			
						<div class="bookmb-contacts-tel">
						<h6><small>Телефон</small><br>
							<a href="tel: 8<? echo $book_user_telephone; ?>">+7<? echo $book_user_telephone; ?></a></h6>
						</div>
						<div class="bookmb-contacts-adres">
						<h6><small>Адрес</small><br>
						<? echo $book_user_street; ?>, <? echo $book_user_building; ?></h6>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	 
	</div>
</section>

<? include ('footer.php') ?>
