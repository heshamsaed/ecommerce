<?php
    session_start();
    
    if(isset($_SESSION['username'])){
        
        $pagetitle = "Dashborad";
        
    include 'ini.php';
        
    /*Start Dashborad page*/
        ?>
        <div class="home-stats text-center">
            <div class="container">
                <h1>Dashborad</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat member">
                            Total Member
                            <span><a href="member.php"><?php echo countitem('usersid','users'); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat pending">
                            Peneding Members
                            <span><a href="member.php?do=manage&page=panding"><?php echo checkitem('regstatus','users',0); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat item">
                            Total Items
                            <span>200</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat comment">
                            Total comments
                            <span>200</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i> latest Registerd user
                            </div>
                            <div class="panel-body">
                                TEST
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i> latest Items Add
                            </div>
                            <div class="panel-body">
                                TEST
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php 
    /*Start Dashborad page*/
    
    include $tbl.'footer.php';
        
    }else{
        
    header('Location: index.php');
        
    exit();
        
    }
 

