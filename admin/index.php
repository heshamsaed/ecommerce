<?php 
    session_start();
    $nonavbar = '';
    $pagetitle = "Login";
    if(isset($_SESSION['username'])){
    header('location:dashborad.php');
    }
   	include 'ini.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedpass = md5($password);
        
    $stmt= $con->prepare('SELECT 
                                usersid, username, Password 
                        FROM 
                                users
                        WHERE 
                                username =? 
                        AND 
                                password =? 
                        AND 
                                groupid = 1
                        LIMIT 1');   
    $stmt->execute(array($username,$hashedpass));
    $row= $stmt->fetch();
    $count = $stmt->rowCount();
        
      if($count>0){
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['usersid'];
        header('location:dashborad.php');
        exit();
       
          
      }  
    }



?>

    <form class="login" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" >
        <h4 class="text-center">Admin control</h4>
        <input class="form-control input-lg" type="text" name="user" placeholder="user name" autocomplete="off"/>
        <input class="form-control input-lg" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="login" />
    </form>



<?php 
	include $tbl."footer.php";

?>