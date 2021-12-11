<?php // ADMIN UPDATE USER TIME
?>


<!Doctype html>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link rel = "stylesheet" type = "text/css" href = "../../css/nav.css">
    <link rel = "stylesheet" type = "text/css" href = "../../css/footer.css">
    <title>Update <?php echo $id ?></title>
</head>
<body>
    <?php require 'nav.php'; ?>
    

    <?php  
            if(($result = Database::get_user_time($id))){


            $row = $result->fetch_assoc(); // expecting one return value...

            $sunday = $row['Sunday'];
            $monday = $row['Monday'];
            $tuesday = $row['Tuesday'];
            $wednesday = $row['Wednesday'];
            $thursday = $row['Thursday'];
            $friday = $row['Friday'];
            $saturday = $row['Saturday'];

            //$total_hours = $sunday + $monday + $tuesday + $wednesday + $thursday + $friday + $saturday;
            
            echo "
    <div class=\"row\" style = \"margin:auto;\">
        <div class=\"col-12 col-md-6\">
            <h5>Date: " . date("l") . ", " . date("m/d/Y") . "</h5>
        </div>
        <div class=\"col-12 col-md-6\">
            <h5 style = \"text-align: right;\">Total Hours: " . number_format($row['Total_Hours'], '2', '.') . "</h5>
        </div>
    </div>
    ";


    if(isset($_SESSION['updated_timesheet'])){
        echo "<center><div style = \"width: 98%;\" class=\"alert alert-success\" role=\"alert\">Successfully Updated Timesheet!</div></center>";
        $_SESSION['updated_timesheet'] = null;
    }



    if(isset($_POST['submit'])){
        $sun = $_POST['sunday'];
        $mon = $_POST['monday'];
        $tues = $_POST['tuesday'];
        $wed = $_POST['wednesday'];
        $thurs = $_POST['thursday'];
        $fri = $_POST['friday'];
        $sat = $_POST['saturday'];


        /* INPUT VALIDATION */
        if(((float)$sun > 24) || ((float)$mon > 24) || ((float)$tues > 24) || ((float)$wed > 24) || ((float)$thurs > 24) || ((float)$fri > 24) || ((float)$sat > 24) ){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Input.<br>Please enter a number greater than or equal to 0</div></center>";
        }
        else if(((float)$sun < 0) || ((float)$mon < 0) || ((float)$tues < 0) || ((float)$wed < 0) || ((float)$thurs < 0) || ((float)$fri < 0) || ((float)$sat < 0) ){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Input.<br>Please enter a number less than or equal to 24</div></center>";
        }
        else if( (!General::validate_time((float)$sun)) || (!General::validate_time((float)$mon)) || (!General::validate_time((float)$tues)) || (!General::validate_time((float)$wed)) || (!General::validate_time((float)$thurs)) || (!General::validate_time((float)$fri)) || (!General::validate_time((float)$sat)) ){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Input.<br>Please only enter numbers in increments of 0.25 (IE 8.00, 8.25, 8.50, 8.75)</div></center>";
        }
        else{
            if(Database::update_timesheet($id, $sun, $mon, $tues, $wed, $thurs, $fri, $sat)){
                $_SESSION['updated_timesheet'] = true;
                header("Refresh:0");
            }
            else{
                echo "<center><div class=\"alert alert-danger\" role=\"alert\">Could Not Update Timesheet! Please Contact Level 2.</div></center>";
            }
        }

    }

    $top = Database::get_top_timesheet();
    $top_row = $top->fetch_assoc();    

    echo "
    <div class=\"row\" style = \"margin:auto;\">
        <div class=\"col-12 col-md-12\">

           
            <table class=\"table\">
                <thead class=\"thead-dark\">
                    <tr>
                        <th scope=\"col\"><center>User</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['sunday_date'])) . "<br>Sunday</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['monday_date'])) . "<br>Monday</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['tuesday_date'])) . "<br>Tuesday</center</th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['wednesday_date'])) . "<br>Wednesday</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['thursday_date'])) . "<br>Thursday</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['friday_date'])) . "<br>Friday</center></th>
                        <th scope=\"col\"><center>" . date('m/d/y', strtotime($top_row['saturday_date'])) . "<br>Saturday</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        

                        <form method = \"post\">
                            <th scope=\"row\"><center>" . $row['name'] . "</center></th>
                            <td><center><input class=\"form-control\" type = 'number' name = \"sunday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($sunday > 0){echo number_format((float)$sunday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"monday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($monday > 0){echo number_format((float)$monday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"tuesday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($tuesday > 0){echo number_format((float)$tuesday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"wednesday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($wednesday > 0){echo number_format((float)$wednesday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"thursday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($thursday > 0){echo number_format((float)$thursday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"friday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($friday > 0){echo number_format((float)$friday, '2', '.');} echo "\"></center></td>
                            <td><center><input class=\"form-control\" type = 'number' name = \"saturday\" placeholder = \"0.00\" step = \"0.01\" value = \""; if($saturday > 0){echo number_format((float)$saturday, '2', '.');} echo "\"></center></td>
                        
                    </tr>
                    
                </tbody>
                
            </table>
            <center>
                <button style = \"width: 16em; margin-bottom: 5%;\" class=\"btn btn-lg btn-primary btn-block\" name = \"submit\" type = \"submit\"><i class=\"fas fa-save\"></i> Save Time</button>
            </center>
            </form>
            
        </div>
    </div>
";


            }
            else{
                echo "Could not Find user: " . $id;
            }
            ?>


    <?php require 'footer.php'; ?>
</body>
</html>