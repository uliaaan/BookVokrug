<? include ('header.php') ?>

   <!--  <div class="demo-header demo-header-image">
   	    <div class="container">
   		    <div class="banner-on-index">
   		    	<img src="/assets/paper_img/ul2.png">
   		    </div>
   		</div>
   </div> -->

    <div class="filterblock">
        <div class="container">
                <form method="post">
                    <div class="filter-main">
                    <div class="mainbar-search"><input name="filtersearch" type="text" class="form-control width100" placeholder="Поиск" value="<? echo $allsearch_all; ?>"></div>

                   <!--  <div style="width:20%"><input name="filtercity" type="text" id="filtercity" maxlength="40" class="form-control input-city" placeholder="Город" value="<? echo $allcitys_all; ?>"></div> -->

                    <div class="mainbar-genre"><select name="filterbookgenre" class="form-control"><? echo $allgenres_all; ?><option value = "<? echo $allgenres; ?>"><? echo $allgenres; ?></option><? echo $getbookgenre_res; ?></select></div>
                    <div class="mainbar-button"><button name="submit" type="submit" href="#" class="btnfilter" style="width:100%">Найти</button></div>
                    </div>
                </form>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="main">
        <div class="section">
        <div class="container tim-container">
                <? booksonmain(); ?>
         </div>
        </div>
    </div>
    
   
<? include ('footer.php') ?>
