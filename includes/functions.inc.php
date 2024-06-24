<?php
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
    function emptyInputSignup($parameter1,$parameter2,$parameter3,$parameter4)
    {
        if(empty($parameter1)||empty($parameter2)||empty($parameter3)||empty($parameter4))
        return true;

        else
        return false;
    }

    function invalidMail($email)
    {
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        return true;
        else
        return false;
    }
    function invalidPass($pwd)
    {
        if(strlen($pwd)>5)
        return true;
        else
        return false;
    }
    function pwdMatch($pwd,$pwd_cnf){
        if($pwd!==$pwd_cnf)
        return true;
        else
        return false;
    }
    function uidExists($conn,$username,$email){
        $sql= "SELECT * FROM users WHERE username='$username' OR email='$email';";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        else 
            return false;
    }
    function createAccount($conn,$username,$email,$pwd){
        
        $sql="INSERT INTO users (username,email,password) VALUES
        ('$username','$email','$pwd');";
        mysqli_query($conn,$sql);
        
    session_start();
        $sql= "SELECT * FROM users WHERE password='$pwd' AND email='$email';";
        
        $result=mysqli_query($conn,$sql);
        
                if(mysqli_num_rows($result)>0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                }
        header("location:../personalize.php");
        
    }
?>