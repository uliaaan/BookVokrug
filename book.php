<? include ('header.php') ?>
<section id="bookpage" class="section-with-space">
	<div class="container center-block text-center mobilebook">
		<div class="bookmb">
			<div class="bookmb-title"><h3><? echo $booktitle; ?></h3><div class="pagebookprice"><? echo $book_price; ?> руб.</div></div>
			<div class="bookmb-main">
			<div class="bookmb-left">
				<div class="bookmb-img">
					<span class="bookmb-img-bg" style="background-image: url(<? echo $book_imgbookurl; ?>);"></span>
					<img class="bgbooks" src="<? echo $book_imgbookurl; ?>">
					
				</div>
			</div>
			<div class="bookmb-right">
				<div class="bookmb-info">
					<div class="bookmb-info-top">№ <? echo $bookid; ?>, размещено <? echo date('Y-m-d', $book_addtime); ?> в <? echo date('H:i', $book_addtime); ?>
					</div>					 
					<div class="bookmb-info-top-right">Осталось дней: <? echo (int)$book_day_to_zero + 1; ?></div>
					<br>
					<div class="bookmb-info-main">
						<div class="bookmb-info-main-simple bookmb-info-main-tel"><small><i class="fa fa-phone" aria-hidden="true"></i></small>
							<a href="tel: 8<? echo $book_user_telephone; ?>">+7<? echo $book_user_telephone; ?></a></div>
							<div class="bookmb-info-main-simple"><small><i class="fa fa-map-marker" aria-hidden="true"></i></small>
						г. <? echo $book_user_city; ?>, <? echo $book_user_street; ?>, <? echo $book_user_building; ?></div>
						<div class="bookmb-info-main-simple"><small><i class="fa fa-book" aria-hidden="true"></i></small>
							<? echo $book_genre_name; ?></div>
						<div class="bookmb-info-main-simple"><small><i class="fa fa-user" aria-hidden="true"></i></small>
							<a href="profile.php?userid=<? echo$book_user_id; ?>"><? echo $book_user_login; ?></a></div>			
						<div class="bookmb-contacts-adres">
						
						<h6>Рецензия</h6>
						<p><? echo $book_text; ?></p>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	 
	</div>
</section>

<? include ('footer.php') ?>
