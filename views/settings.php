<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <title>Settings</title>
    <link rel = "stylesheet" type = "text/css" href = "css/settings.css">
</head>
<body>
    <?php require 'nav.php'; ?>

    <?php
        if(isset($_SESSION['edit_user'])){
            echo "<center><div style = \"width: 50%;\" class=\"alert alert-success\" role=\"alert\">Successfully Edited User: " . $_SESSION['edit_user'] . "</div></center>";
            $_SESSION['edit_user'] = null;
        }
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $vpassword = $_POST['vpassword'];
            $access_level = $_POST['access_level'];

            if($password != $vpassword){
                echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
            }
            else if($access_level != "1" && $access_level != "3"){
                echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Access Level!</div></center>";
            }
            else{
                if(Database::edit_user($_SESSION['email'], $email, $name, $password, $access_level)){
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['access_level'] = $access_level;
                    header("Refresh:0");
                    $_SESSION['edit_user'] = $email;
                }
                else{
                    echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Error Changing Password! Please Contact Level 2.</div></center>";
                }
            }
        }
        if(isset($_POST['submit_admin'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $vpassword = $_POST['vpassword'];
            $access_level = "2";

            if($password != $vpassword){
                echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
            }
            else if($access_level != "2"){
                echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Access Level!</div></center>";
            }
            else{
                if(Database::edit_user($_SESSION['email'], $email, $name, $password, $access_level)){
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['access_level'] = $access_level;
                    header("Refresh:0");
                    $_SESSION['edit_user'] = $email;
                }
                else{
                    echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Error Changing Password! Please Contact Level 2.</div></center>";
                }
            }
        }
        if(isset($_POST['change_password'])){
            $password = $_POST['password'];
            $vpassword = $_POST['vpassword'];
            if($password != $vpassword){
                echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
            }
            else{
                if(Database::change_password($_SESSION['email'], $password)){
                    echo "<center><div style = \"width: 50%;\" class=\"alert alert-success\" role=\"alert\">Sucessfully Changed Password!</div></center>";
                }
                else{
                    echo "<center><div style = \"width: 50%;\" class=\"alert alert-danger\" role=\"alert\">Error Changing Password! Please Contact Level 2.</div></center>";
                }
            }
        }

    ?>

    <?php
        if($_SESSION['access_level'] == 1){
            echo "
            
            <div class=\"row\" style = \"margin: auto;\">
            <div class=\"col-sm-12\">
                <center>
                    <h1 class=\"h3 mb-3 font-weight-normal \">Change Password <b><i class=\"fas fa-cog\"></i></b></h1>
                    <form class=\"form-signin\" method=\"post\">
                    
                    <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                    <input type=\"password\" class=\"form-control\" name = \"password\" placeholder=\"New Password\" value required style=\"width: 25em;\">
    
                    <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                    <input type=\"password\" class=\"form-control\" name = \"vpassword\" placeholder=\"Validate New Password\" value required style=\"width: 25em;\">
                    
                    <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" name = \"change_password\" style=\"width: 20em;\">Apply Changes</button>
                    
                </form>
                    <h3 class = \"desc user-info\"><b>Name: </b><span style = \"font-family: calibri;\">" . $_SESSION['name'] . "</span></h3>
                    <h3 class = \"desc user-info\"><b>Email: </b><a href = \"mailto: " . $_SESSION['email'] . "\" style = \"font-family: calibri;\">" . $_SESSION['email'] . "</a></h3>


                </center>
            </div>
            
            </div>";
        }
        else if($_SESSION['access_level'] == 3){
            echo "
            <center>
            
            
            <div class=\"col-sm-12\">
            

            <form class=\"form-signin\" method=\"post\">
                <h1 class=\"h3 mb-3 font-weight-normal \">Account Settings <b><i class=\"fas fa-cog\"></i></b></h1>
                
                <label for=\"inputEmail\" class=\"sr-only\">Name</label>
                <input type=\"text\" class=\"form-control color-btn\" name = \"name\" placeholder=\"Name\" value = \"" . $_SESSION['name'] . "\" required autofocus style=\"width: 25em;\">

                <label for=\"inputEmail\" class=\"sr-only\">Email address</label>
                <input type=\"email\" class=\"form-control color-btn\" name = \"email\" placeholder=\"Email address\" value = \"" . $_SESSION['email'] . "\" required autofocus style=\"width: 25em;\">
                
                <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                <input type=\"password\" class=\"form-control\" name = \"password\" placeholder=\"New Password\" value required style=\"width: 25em;\">

                <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                <input type=\"password\" class=\"form-control\" name = \"vpassword\" placeholder=\"Validate New Password\" value required style=\"width: 25em;\">
                

                    <select class=\"custom-select mr-sm-2 color-btn i4\" aria-label=\"Default select example\" name = \"access_level\" style = \"width: 25em; margin-left: 1%;\" required>
                    <option "; if(!isset($_SESSION['access_level'])){ echo "selected"; } echo ">Access Level</option>
                    <option value=\"1\""; if($_SESSION['access_level'] == 1){ echo "selected"; } echo ">1 (User)</option>

                    <option value=\"3\""; if($_SESSION['access_level'] == 3){ echo "selected"; } echo ">3 (Super 'Admin + User')</option>
                </select>";
                
            
                echo "
                <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" name = \"submit\" style=\"width: 20em;\">Apply Changes</button>
                
            </form>


            </div>
            </center>
            </div>";
        }
        else{
            echo "
            <center>
            
            
            <div class=\"col-sm-12\">
            

            <form class=\"form-signin\" method=\"post\">
                <h1 class=\"h3 mb-3 font-weight-normal \">Account Settings <b><i class=\"fas fa-cog\"></i></b></h1>
                
                <label for=\"inputEmail\" class=\"sr-only\">Name</label>
                <input type=\"text\" class=\"form-control color-btn\" name = \"name\" placeholder=\"Name\" value = \"" . $_SESSION['name'] . "\" required autofocus style=\"width: 25em;\">

                <label for=\"inputEmail\" class=\"sr-only\">Email address</label>
                <input type=\"email\" class=\"form-control color-btn\" name = \"email\" placeholder=\"Email address\" value = \"" . $_SESSION['email'] . "\" required autofocus style=\"width: 25em;\">
                
                <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                <input type=\"password\" class=\"form-control\" name = \"password\" placeholder=\"New Password\" value required style=\"width: 25em;\">

                <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                <input type=\"password\" class=\"form-control\" name = \"vpassword\" placeholder=\"Validate New Password\" value required style=\"width: 25em;\">
                


                <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" name = \"submit_admin\" style=\"width: 20em;\">Apply Changes</button>
                
            </form>
 
            </div>
            </center>
            </div>
            ";
        }
        
    ?>


    </div>
    
    <?php require 'footer.php'; ?>
</body>
</html>