<? include ('header.php') ?>
<? if ($_SESSION['userlogin']) { ?>
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
                }
            ?>
        <section id="profile" class="section-with-space">
            <div class="container">
                <div class="profile-tabs">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                                <li class="active"><a href="#follows" data-toggle="tab">Follows</a></li>
                                <li><a href="#following" data-toggle="tab">Following</a></li>
<!--                                 <li><a href="#following" data-toggle="tab">Following</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div id="my-tab-content" class="tab-content">
                        <div class="tab-pane active" id="follows">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <ul class="list-unstyled follows">
                                        <li>
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-0 col-xs-3 col-xs-offset-2">
                                                    <img src="../assets/paper_img/flume.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                </div>
                                                <div class="col-md-7 col-xs-4">
                                                    <h6>Flume<br /><small>Musical Producer</small></h6>
                                                </div>
                                                <div class="col-md-3 col-xs-2">
                                                    <div class="unfollow" rel="tooltip" title="Unfollow">
                                                        <label class="checkbox" for="checkbox1" >
                                                            <input type="checkbox" value="" id="checkbox1" data-toggle="checkbox" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <hr />
                                        <li>
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-0 col-xs-3 col-xs-offset-2">
                                                    <img src="../assets/paper_img/banks.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                </div>
                                                <div class="col-md-7 col-xs-4">
                                                    <h6>Banks<br /><small>Singer</small></h6>
                                                </div>
                                                <div class="col-md-3 col-xs-2">
                                                    <div class="unfollow" rel="tooltip" title="Unfollow">
                                                        <label class="checkbox" for="checkbox1" >
                                                            <input type="checkbox" value="" id="checkbox1" data-toggle="checkbox" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-center" id="following">
                            <h3 class="text-muted">Not following anyone yet :(</h3>
                            <btn class="btn btn-warning btn-fill">Find artists</btn>
                        </div>
                    </div>
                    
                </div>        
            </div>
        </section>
        </div>
<? } else {
    header("Location: / ");
    } ?>
<? include ('footer.php') ?>