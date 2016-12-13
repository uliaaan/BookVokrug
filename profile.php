<? include ('header.php') ?>
        <div class="profile-background"> 
            <div class="filter-black"></div>  
        </div>
        <div class="profile-content section-nude">
        <!-- Сообщение об успешном редактировании данных -->
            <? 
            if ($_GET['edituserprofile'] == 1) {
                    echo $update_user_data_notif;
            } else if ($_GET['addbook'] == 1) {
                echo $addbook_notif;
            } else if ($_GET['addbook'] == 2) {
                echo $addbook_size_fallse;
            } else if ($_GET['editbook'] == 1) {
                echo $update_user_data_notif;
            } else if ($_GET['editbook'] == 2) {
                echo $editbook_fallse;
            } else if ($_GET['delbook'] == 1) {
                echo $delbook_true;
            }
            ?>
        <section id="profile" class="section-with-space">
            <div class="container">
                <div class="profile-tabs">
                   <?   if($_SESSION['userlogin']) {
                            if(!$_GET['userid'])  { 
                    ?>

                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                                <li class="active"><a href="#activebooks" data-toggle="tab">Активные</a></li>
                                <li><a href="#notactivebooks" data-toggle="tab">Устаревшие</a></li>
                            </ul>
                        </div>
                    </div>

                       <?     
                            }
                        } 
                        ?>
                    <div id="my-tab-content" class="tab-content">
                        <div class="tab-pane active" id="activebooks">
                            <div class="row">
                            <? if($_SESSION['userlogin']) {
                                    if($_GET['userid'])  {

                                        echo profile_user_get();
                                    } else {
                                        echo profile_user();
                                    }
                                } else if ($_SERVER['REQUEST_URI'] === '/profile.php') {
                                    header("Location: / ");
                                } else {
                                    echo profile_booksonmain();
                                }
                            ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="notactivebooks">

                           <? echo profile_user_noactualbooks(); ?>
                        </div>
                    </div>
                    
                </div>        
            </div>
        </section>
        </div>
<? include ('footer.php') ?>