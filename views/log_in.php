<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <link rel = "stylesheet" type = "text/css" href = "css/log_in.css">
    <title>Log In</title>
</head>
<body>

<?php
    # validate user login
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            if(Database::auth($email, $password)){
                echo "<center><div class=\"alert alert-danger\" role=\"success\">Welcome! Redirecting</div></center>";
                $_SESSION['auth'] = true;
                if(Flight::request()->url == "/login"){
                    Flight::redirect("/");
                }

                Flight::redirect(Flight::request()->url);
            }
            else{
                echo "<center><div class=\"alert alert-danger\" role=\"alert\">Incorrect Username or Password.</div></center>";
            }
        }
?>



<?php
    # validate password reset has been emailed
        if(isset($_SESSION['reset_password'])){
            echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Reset Password. Please check your email (" . $_SESSION['reset_password'] . ").</div></center>";
            $_SESSION['reset_password'] = null;
        }
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            Please enter the email address associated with your account.
            <form method = "post">

            <input type="email" class="form-control" name = "reset_email" placeholder="Email" autocomplete = "off" value required style="width: 100%;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button name = "reset_password" type="submit" class="btn btn-primary">Reset Password</button>
            </form>
      </div>
    </div>
  </div>
</div>



<?php
    # attempt password reset
        if(isset($_POST['reset_password'])){
            $reset_email = $_POST['reset_email'];
            if(Database::get_user($reset_email)){
                $temp_pass = md5(time());
                $temp_pass = substr($temp_pass, 0, 8);
                Database::change_password($reset_email, md5($temp_pass));
                Mail::email_password($reset_email, $temp_pass);
            }
            else{
                echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Email Address</div></center>";
            }
        }
?>


<center>
        <form class="form-signin" method="post">
            <img class="mb-4" src="https://benlomandconnect.com/wp-content/uploads/logo-1.svg" alt="logo" width="303" height="110">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" class="form-control" name = "email" placeholder="Email address" value required autofocus style="width: 20em;">
            
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" class="form-control" name = "password" placeholder="Password" value required style="width: 20em;">
            
            <button class="btn btn-lg btn-primary btn-block" type="submit" name = "submit" style="width: 16em;">Sign in</button>
            
            <br>
            <a data-toggle="modal" data-target="#exampleModal"href = "" class = "forgot-password">Forgot Password?</a>

            <p class="mt-5 mb-3 text-muted">By Blaine Wilson</p>
        </form>
</center>   


</body>
</html>