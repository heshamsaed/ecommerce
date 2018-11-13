<?php
    include 'ini.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
    if($do == "manage"){
        echo "manage";
    }elseif($do == "add"){
        echo "add";
    }elseif($do=="insert"){
        echo "insert";
    }else{
        echo "error there's no page with this name";
    }

?>