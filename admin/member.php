<?php
    session_start();
    $pagetitle ='Members';

    if(isset($_SESSION['username'])){
        
        include 'ini.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
        
        //start manage page
        
        
        
        if( $do == 'manage'){//manage page
            
            $qurey = '';
            
            if( isset($_GET['page']) && isset($_GET['page']) == 'panding'){
                
                $qurey = "AND regstatus = 0";
            }
            
        //select all user
        $stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1 $qurey");
        $stmt->execute();
        $rows = $stmt->fetchAll();                   
?>
            <h1 class="text-center">Manage Member</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>user name</td>
                            <td>Email</td>
                            <td>Full name</td>
                            <td>Registerd date</td>
                            <td>control</td>
                        </tr>
                        <?php
                            foreach( $rows as $row){
                                echo "<tr>";
                                    echo "<td>" .$row['usersid']."</td>";
                                    echo "<td>" .$row['username']."</td>";
                                    echo "<td>" .$row['email']."</td>";
                                    echo "<td>" .$row['fullname']."</td>";
                                    echo "<td>".$row['date']."</td>";
                                    echo '<td>
                                    <a href="member.php?do=edit&userid='.$row["usersid"].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="member.php?do=delete&userid='.$row["usersid"].'" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                    if ($row['regstatus'] == 0){
                                        echo '<a href="member.php?do=activate&userid='.$row["usersid"].'" class="btn btn-info actived"><i class="fa fa-close"></i> Actived </a>';
                                    }
                                    echo '</td>';
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>                            
            <a href='member.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>
            </div><!--end contaniar-->
<?php }elseif( $do == 'add' ){//add members page
      ?>
            <h1 class="text-center">Add New Member</h1>
                <div class="container">
                    <form action="?do=insert" method="post" class="form-horizontal">
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">USER NAME</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control"  autocomplete="off"  required="required" placeholder="Username To Login Into Shop" data-validation="length alphanumeric" data-validation-length="min4"/>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">password</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password Must Be hard & Complex" required="required"/>
                                <i class="showpass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control"  required="required" placeholder="Email must Be valid" data-validation="email"/>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">FULL NAME</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="full" class="form-control" required="required" placeholder="Full Name apper in your profile page" data-validation="length" data-validation-length="min4" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>
                </div>            
        <?php 
        }elseif ( $do == 'insert' ){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST' ){
                
                echo "<h1 class='text-center'>Update Member</h1>";
                
                echo "<div class='container'>";
              
                $user =$_POST['username'];
                $pass =$_POST['password'];
                $email=$_POST['email'];
                $full =$_POST['full'];
                //md5 for password
                $hashpass = md5($pass);
                //validate the form
                $formerror=array();
                if(strlen($user) >20){
                    
                     $formerror[] = "User Name Cant Be More Than<strong> 20 Characters</strong>";
                    
                }
                if(strlen($user) < 4){
                    
                     $formerror[] = "User Name Cant Be less than<strong> four characters</strong>";
                    
                }
                if( empty($user))
                {
                    
                    $formerror[] = "User Name Cant Be<strong> Empty</strong>";
                    
                }
                if( empty($pass))
                {
                    
                    $formerror[] = "password Name Cant Be<strong> Empty</strong>";
                    
                }
                if( empty($email))
                {
                    
                    $formerror[] = "Your Email Cant Be<strong> Empty</strong>";
                    
                }
                if( empty($full)){
                    
                    $formerror[] = "Full Name Cant Be<strong> Empty</strong>";
                    
                }
                
                foreach($formerror as $error){
                    
                    echo "<div class='alert alert-danger'>". $error."</div>";
                    
                }
                
                if(empty($formerror)){
                    
                    //check if user exist in database
                    
                    $check = checkitem('username','users',$user);
            
                   if( $check == 1 ){
                       
                     $errormsg =  '<div class= "alert alert-danger">Sorry This user Is Exist</div>' ;
                     redirecthome($errormsg,'back');
                       
                     }else{
                       
                       //Insert the datebase with thid info
                    
                    $stmt = $con->prepare('INSERT INTO users(username,password,email,fullname,regstatus,date)VALUES(:auser, :apass, :email, :full,1,now())');
                    $stmt->execute(array(
                    'auser' => $user,
                    'apass' => $hashpass,
                    'email' => $email,
                    'full' => $full
                    ));
                    //echo Success message
                    $errormsg = "<div class='alert alert-success'>".$stmt->rowcount() . " RECORD Update </div>";

                       redirecthome($errormsg,'back');
                   }
                    
                }
                
            }else{
                echo "<div class='container'>";
                $errormsg = "<div class='alert alert-danger'>sorry you can't browes this page</div>";
                redirecthome($errormsg,'back');
                echo "</div>";
            }
            echo "</div>";
            
            }elseif ($do == 'edit'){ //Edit page------------------------------------------------------------------
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
            $stmt   = $con->prepare("SELECT * FROM users WHERE usersid = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row    = $stmt->fetch();
            $count  = $stmt->rowCount();
            if($count >0){
            ?>
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form action="?do=update" method="post" class="form-horizontal">
                       <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">USER NAME</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control"  autocomplete="off" value="<?php echo $row['username']; ?>"  required="required" />
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">password</label>
                            <div class="col-sm-10 col-md-6">
                               <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>" />
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave BLank If You Dont Want to change" />
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required="required" />
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label for="" class="col-sm-2 control-label">FULL NAME</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="full" class="form-control" value="<?php echo $row['fullname']; ?>" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="SAVE" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>
                </div>
            
        <?php 
        }else{
                echo "<div class='container'>";
                $errormsg = "<div class='alert alert-danger'>there no id</div>";
                redirecthome($errormsg,'back');
                echo "</div>";
        }
        }elseif( $do == 'update'){//update page--------------------------------------------------------------------
            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST' ){
                $id   =$_POST['userid'];
                $user =$_POST['username'];
                $email=$_POST['email'];
                $full =$_POST['full'];
                //password
                $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : md5($_POST['newpassword']);
                //validate the form
                
                //validate the form
                
                $formerror=array();
                
                if(strlen($user) >20){
                    
                     $formerror[] = "User Name Cant Be More Than<strong> 20 Characters</strong>";
                    
                }
                if(strlen($user) < 4){
                    
                     $formerror[] = "User Name Cant Be less than<strong> four characters</strong>";
                    
                }
                if( empty($user))
                {
                    
                    $formerror[] = "User Name Cant Be<strong> Empty</strong>";
                    
                }
                if( empty($email))
                {
                    
                    $formerror[] = "Your Email Cant Be<strong> Empty</strong>";
                    
                }
                if( empty($full)){
                    
                    $formerror[] = "Full Name Cant Be<strong> Empty</strong>";
                    
                }
                foreach($formerror as $error){
                    
                    echo "<div class='alert alert-danger'>". $error."</div>";
                }
                if(empty($formerror)){
                    //update the datebase with thid info
                    $stmt = $con->prepare("UPDATE users SET username = ?, email = ?, fullname = ?,password = ? WHERE usersid =?");
                    $stmt->execute(array($user,$email,$full,$pass,$id));
                    //echo Success message
                   
                    $errormsg = "<div class='alert alert-success'>".$stmt->rowcount() . " RECORD UPDATE </div>";
                    redirecthome($errormsg,'back');
                }
                
                
            }else{
                $errormsg = "<div class='alert alert-danger'>sorry you can't browes this page</div>";
                    redirecthome($errormsg);
            }
            echo "</div>";
       /*End Update*/ } elseif( $do == 'delete' ){
                echo "<h1 class='text-center'>DELETE Member</h1>";
                echo "<div class='container'>";
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
               
                $check = checkitem('usersid','users',$userid);
               
                if( $check > 0  ){
                    $stmt = $con->prepare('DELETE FROM users WHERE usersid = :zuser');
                    $stmt->bindParam(":zuser", $userid);
                    $stmt->execute();
                    $errormsg = "<div class='alert alert-success'>".$stmt->rowcount() . " RECORD DELETED </div>";
                    redirecthome($errormsg);
                    echo "</div>";
                }else{
                    echo "<div class='container'>";
                    $errormsg = "<div class='alert alert-danger'>this id is not exist</div>";
                    redirecthome($errormsg,'back');
                    echo "</div>"; 
                }
        } elseif($do == 'activate'){
             echo "<h1 class='text-center'>Activtated Member</h1>";
             echo "<div class='container'>";
             $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
               
            $check = checkitem('usersid','users',$userid);
               
                if( $check > 0  ){
                    $stmt = $con->prepare("UPDATE users SET regstatus = 1 WHERE usersid = ?");
                    $stmt->execute(array($userid));
                    $errormsg = "<div class='alert alert-success'>".$stmt->rowcount() . " RECORD updated </div>";
                    redirecthome($errormsg);
                    echo "</div>";
                }else{
                    echo "<div class='container'>";
                    $errormsg = "<div class='alert alert-danger'>this id is not exist</div>";
                    redirecthome($errormsg,'back');
                    echo "</div>"; 
                }
        }
        include $tbl.'footer.php';
    }else{
        
        header('location:index.php');
        
        exit();
    }







