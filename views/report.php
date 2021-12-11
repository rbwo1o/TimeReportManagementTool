<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <title>Dashboard</title>
    <link rel = "stylesheet" type = "text/css" href = "css/report.css">
</head>
<body>
    <?php require 'nav.php'; ?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            Generating a report will create a PDF document including each user's time for the week.<br>
            This will reset each user's time back to 0.00
            <br>
            <br>
            Please enter the password.
            <form method = "post">

            <input type="password" class="form-control" name = "password" placeholder="Password" autocomplete = "off" value required style="width: 20em;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button name = "submit" type="submit" class="btn btn-primary">Save changes</button>
            </form>
      </div>
    </div>
  </div>
</div>



<?php

    if(isset($_POST['submit'])){
        $password = $_POST['password'];
        if($password == PASSWORD){
            $_SESSION['generate_report'] = true;
            Flight::redirect("/generate_report");
        }
    }

?>



<?php


if(isset($_SESSION['mail_preview'])){
    echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Mailed Time Sheet Preview</div></center>";
    $_SESSION['mail_preview'] = null;
}

?>


<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            Would you like to email the timesheet as a preview?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <form action = "/mail_preview"method = "post">
                <button name = "submit" type="submit" class="btn btn-primary">Yes</button>
            </form>
      </div>
    </div>
  </div>
</div>



    <div class="row" style = "margin:auto;">
        
        <div class="col-12 col-md-12">
            <center>
            <h3 style = "font-family: calibri;">Report Preview <b><i class="fas fa-chart-line"></i></b></h3>
            <br>
            <div class="col-12 col-md-6">
                    <a class="float-right btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#exampleModal" style="color: white; width: 15em;"><i class="fas fa-table"></i> Generate FINAL Report</a>
            </div>
            <div class="col-12 col-md-6">
                    <a class="float-left btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#exampleModal2" id = "mail" style="width: 15em;"><i class="fas fa-envelope"></i> Mail Report Preview</a>
            </div>
            </center>
        </div>
    </div>
    

<br>


    <?php 
    
    // get date of report.
    // make a connection
    // query top of timesheet to get dates
    // display dates and table head
    
    $result = Database::get_top_timesheet();
    $row = $result->fetch_assoc();

    ?>


    <div class="row" style = "margin:auto;">
        
        <div class="col-12 col-md-12">
        
            <center>
                <table class="table">
            <thead class="thead-dark">
                <?php

                
                echo "
                    <tr>
                    <th scope=\"col\"><center>Employee Names</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['sunday_date'])) . "<br>Sunday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['monday_date'])) . "<br>Monday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['tuesday_date'])) . "<br>Tuesday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['wednesday_date'])) . "<br>Wednesday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['thursday_date'])) . "<br>Thursday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['friday_date'])) . "<br>Friday</center></th>
                    <th scope=\"col\"><center>" . date('m/d/Y', strtotime($row['saturday_date'])) . "<br>Saturday</center></th>
                    <th scope=\"col\"><center>Total Hours</center></th>
                    <th scope=\"col\"><center>Edit</center></th>
                    </tr>
                ";
                ?>
                
            </thead>
            <tbody>
                <?php


                if(($result = Database::preview_timesheet())){
                    while( ($row = $result->fetch_assoc()) ){
                        echo "
                            <tr>
                            <th><center>" . $row['name'] . "</center></th>
                            <th><center>" . number_format((float)$row['Sunday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Monday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Tuesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Wednesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Thursday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Friday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Saturday'], '2', '.') . "</center></th>
                            <th><center><span style = \"color: red;\">"; if(!$row['Total_Hours']){echo "0.00";}else{echo number_format((float)$row['Total_Hours'], '2', '.');} echo "</span></center></th>
                            <th><center><a href = \"update_timesheet/" . $row['id'] . "\"><i class=\"fas fa-save\"></i></a></center></th>
                            </tr>
                        ";
                    }
                }
                else{
                        echo" 
                        <tr>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                            <th>NULL</th>
                        </tr>
                            ";
                }
                
                ?>
            </tbody>
            </table>       
</center>
            
        </div>
    </div>


    

    <?php require 'footer.php'; ?>
</body>
</html>