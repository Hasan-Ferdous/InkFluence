<?php
            include 'dbh.inc.php';
            if(!isset($_POST['submit']))
            {
                
                $username=mysqli_real_escape_string($conn,$_POST['username']);
                $email=mysqli_real_escape_string($conn,$_POST['email']);

                $pwd=mysqli_real_escape_string($conn,$_POST['pass1']);
                $pwd_cnf=mysqli_real_escape_string($conn,$_POST['pass2']);
               

                include_once 'dbh.inc.php';
                include_once 'functions.inc.php';

                if(emptyInputSignup($username,$email,$pwd,$pwd_cnf)){
                    phpAlert("Fill all the Blank Field");
                    header("Location:../index.php?error=empty1");
                    exit();
                }
                

                if(invalidMail($email)!==false){
                    header("Location:../index.php?error=invalidemail");
                    exit();
                }
                if(invalidPass($pwd)==false){
                    header("Location:../index.php?error=invalidepass");
                    exit();
                }
                if(pwdMatch($pwd,$pwd_cnf)!==false){
                    header("Location:../index.php?error=passdontmatch");
                    exit();
                }
                
                if(uidExists($conn,$username,$email)){
                    header("Location:../index.php?error=uidexists");
                    exit();
                }
                
                createAccount($conn,$username,$email,$pwd);

                


            }
            else{
                header("Location:../index.php?signup=error");
                exit();
            }
        ?>