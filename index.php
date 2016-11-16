<? include ('header.php') ?>

    <div class="demo-header demo-header-image">
            <div class="motto">
                <h1 class="title-uppercase"><? ?></h1>
                <h3>232313.</h3>
            </div>
    </div>

    <div class="filterblock">
        <div class="container">
                <form method="post">
                    <div class="filter-main">
                    <div style="width:50%"><input name="filtersearch" type="text" class="form-control width100" placeholder="Поиск"></div>
                    <div style="width:20%"> 
                        <input name="filtercity" type="text" id="city" maxlength="40" class="form-control input-city" value="<? echo $allrussia; ?>">
                    </div>
                    <div style="width:20%"><select name="filterbookgenre" class="form-control"><? echo $allgenres_all; ?><option value = "<? echo $allgenres; ?>"><? echo $allgenres; ?></option><? echo $getbookgenre_res; ?></select></div>
                    <div style="width:8%"><button name="submit" type="submit" href="#" class="btnfilter" style="width:100%">Найти</button></div>
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
