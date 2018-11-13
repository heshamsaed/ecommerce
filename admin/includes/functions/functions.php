<?php
    function gettitle() {
        
        global $pagetitle;
        
        if(isset($pagetitle)){
            
            echo $pagetitle;
            
        }else{
            
            echo 'Default';
            
        }
    }
    /*
    ** Home Redirect function 
    ** This function Accept Parameters
    ** $Themsg = Echo The Message [ Error | success | warning ]
    ** $url = The link you want to Redirect To
    ** $seconds = seconed before redirecting
    */
    function redirecthome($errormsg,$url = null, $seconds = 3){
        
        if( $url === null ){
            
            $url = 'index.php';
            
        } else {
            
            $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==  '' ? $_SERVER['HTTP_REFERER'] : 'index.php' ;
    
        }
        echo $errormsg;
        echo "<div class='alert alert-info'>You Will Be Redirected To Homepage After $seconds seconds</div>";
        header("refresh:$seconds;url=$url");
        exit();
    }

    /*
    **  function To check Item In Datebase
    **  This function Accept Parameters
    ** 
    **  $select = the item to select [ Eaxmple : user , item]
    **  $from = the table to select from [ eample : users]
    **  $value = the value of the select
    */

    function checkitem($select,$from,$value){
        
        global $con;
        
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        
        $statement->execute(array($value));
        
        $count = $statement->rowCount();
        
        return $count;
            
    }


/*
    **  function To Count Item In Datebase
    **  This function Accept Parameters
    ** 
    **  $select = the item to select [ Eaxmple : user , item]
    **  $from = the table to select from [ eample : users]
    **  
    */

    function countitem($item,$table){
        
        global $con;
        
        $statm = $con->prepare("SELECT COUNT($item) FROM $table");
        
        $statm->execute();
        
        return $statm->fetchColumn();
    }
