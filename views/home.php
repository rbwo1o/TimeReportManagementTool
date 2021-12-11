<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <title>Home</title>
</head>
<body>
    <?php require 'nav.php'; ?>
    Home
    <?php
        if(isset($_SESSION['email'])){
            echo $_SESSION['email'];
        }
        if(isset($_SESSION['name'])){
            echo $_SESSION['name'];
        }
        if(isset($_SESSION['access_level'])){
            echo $_SESSION['access_level'];
        }
    
    ?>

<?php 
    if($_SESSION['id'] == 1){
        echo "
        <div class=\"row\" style = \"margin:auto;\">
            <div class=\"col-12 col-md-4\">
                <center>
                    <h3 style = \"font-family: calibri;\">Statistics <b><i class=\"fas fa-address-card\"></i></b></h3>
                </center>
            </div>
            <div class=\"col-12 col-md-8\">
                <center>
                    <h3 style = \"font-family: calibri;\">Notifications <span style = \"color: blue;\"><i class=\"fas fa-exclamation-circle\"></i></span></h3>
                </center>
            </div>
        </div>
        
        ";
    }
    else if($_SESSION['id'] == 2){
        echo "
        <div class=\"row\" style = \"margin:auto;\">
            <div class=\"col-12 col-md-4\">
                <center>
                    <h3 style = \"font-family: calibri;\">Statistics <b><i class=\"fas fa-address-card\"></i></b></h3>
                </center>
            </div>
            <div class=\"col-12 col-md-8\">
                <center>
                    <h3 style = \"font-family: calibri;\">Notifications <span style = \"color: blue;\"><i class=\"fas fa-exclamation-circle\"></i></span></h3>
                </center>
            </div>
        </div>
        
        ";
    }
    else{
        echo "
        <div class=\"row\" style = \"margin:auto;\">
            <div class=\"col-12 col-md-4\">
                <center>
                    <h3 style = \"font-family: calibri;\">Statistics <b><i class=\"fas fa-address-card\"></i></b></h3>
                </center>
            </div>
            <div class=\"col-12 col-md-8\">
                <center>
                    <h3 style = \"font-family: calibri;\">Notifications <span style = \"color: blue;\"><i class=\"fas fa-exclamation-circle\"></i></span></h3>
                </center>
            </div>
        </div>
        
        ";
    }


?>  
    <?php require 'footer.php'; ?>
</body>
</html>

