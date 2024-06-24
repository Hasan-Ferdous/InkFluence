<?php
            
            session_start();
            
            include 'dbh.inc.php';
            $email=mysqli_real_escape_string($conn,$_POST['email']);
            $pwd=mysqli_real_escape_string($conn,$_POST['pass1']);


            $sql= "SELECT * FROM users WHERE password='$pwd' AND email='$email';";
            
            if(isset($_POST['submit']))
            {
                
                $result=mysqli_query($conn,$sql);
        
                if(mysqli_num_rows($result)>0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                    
                    header("Location:../homepage.php");
                }

                else{
                    header("Location:../index.php?login=notfound");
                    exit();
                }
                
            }
            else{
                
                  header("ungabunga.php");     
            }
            
        ?>