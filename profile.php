<? include ('header.php') ?>
        <div class="profile-background"> 
            <div class="filter-black"></div>  
        </div>
        <div class="profile-content section-nude">
            <div class="container">
                <div class="row owner">
                    <div class="text-center">
                        <div class="userlogin">
                            <h4>
                                <? echo "Добрый день, " .$_SESSION['userlogin']. "!<br />
                                    <small>
                                        <a href='/settingsprofile.php' class='btn btn-simple btn-danger'><i class='fa fa-cog' aria-hidden='true'></i></a>
                                        <a href='?exit' class='btn btn-simple btn-danger'><i class='fa fa-sign-out' aria-hidden='true'></i></a>
                                        </small>
                                "; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <p>An artist of considerable range, Chet Faker — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music, giving it a warm, intimate feel with a solid groove structure. </p>
                        <br />
                        <btn class="btn"><i class="fa fa-cog"></i> Settings</btn>
                    </div>
                </div>
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
        </div>
<? include ('footer.php') ?>