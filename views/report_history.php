<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <title>Report History</title>
    <link rel = "stylesheet" type = "text/css" href = "css/report_history.css">
</head>
<body>
    <?php require 'nav.php'; ?>

        <center>
            <h1 class = "h3 font-weight-normal" id = "title" >Report History <span style = "font-weight: bold;"><i class="fas fa-history"></i></span></h1>
        </center>

<?php


if(isset($_SESSION['deleted_report'])){
    echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Deleted Report: " . $_SESSION['deleted_report'] . "</div></center>";
    $_SESSION['deleted_report'] = null;
}


?>



<div class="row" style = "margin:auto;">

            <div class="col-12 col-md-12">
                <center>
                    <form method = "post">
                        <h5>Searh by Date</h5>
                        <div class="input-group mb-3" style = "width: 450px;">
                            <input name = "date" type="date" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button name = "submit" class="btn btn-outline-secondary" id = "date_search" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </center>
            </div>

</div>


        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                <th scope="col"><center>#</center></th>
                <th scope="col"><center>Report ID</center></th>
                <th scope="col"><center>Start Date</center></th>
                <th scope="col"><center>End Date</center></th>
                <th scope="col"><center>Time Generated</center></th>
                <th scope="col"><center>Edit</center></th>
                </tr>
            </thead>
            <tbody>

            <?php
            
            if(isset($_POST['submit'])){
                $date = $_POST['date'];
                $result = Database::get_report_by_date($date);
                $count = 0;
                while(($row = $result->fetch_assoc())){
                    $count++;
                    echo "
                    <tr>
                    <th scope=\"col\"><center>" . $count . "</center></th>
                    <th scope=\"col\"><center>" . $row['report_id'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['sunday_date'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['saturday_date'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['time'] . "</center></th>
                    <th scope=\"col\"><center><span style = \"color: blue\"><a href = \"/download_report/" . $row['report_id'] . "\"><i class=\"fas fa-file-download\"></i></a></span>&emsp;<a href = \"/delete_report/" . $row['report_id'] . "\"><span style = \"color: red;\"><i class=\"fas fa-trash-alt\"></i></a></span></center></th>
                    </tr>
                    "; 
                }
            }
            else{
                $result = Database::get_reports();
                $count = 0;
                while(($row = $result->fetch_assoc())){
                    $count++;
                    echo "
                    <tr>
                    <th scope=\"col\"><center>" . $count . "</center></th>
                    <th scope=\"col\"><center>" . $row['report_id'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['sunday_date'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['saturday_date'] . "</center></th>
                    <th scope=\"col\"><center>" . $row['time'] . "</center></th>
                    <th scope=\"col\"><center><span style = \"color: blue\"><a href = \"/download_report/" . $row['report_id'] . "\"><i class=\"fas fa-file-download\"></i></a></span>&emsp;<a href = \"delete_report/" . $row['report_id']. "\"><span style = \"color: red;\"><i class=\"fas fa-trash-alt\"></i></a></span></center></th>
                    </tr>
                    ";
                }
            }
                
            
            ?>

            </tbody>
        </table>


    <?php require 'footer.php'; ?>
</body>
</html>