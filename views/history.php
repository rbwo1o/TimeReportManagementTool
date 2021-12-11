<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <title>History</title>
    <link rel = "stylesheet" type = "text/css" href = "css/history.css">
</head>
<body>
    <?php require 'nav.php'; ?>
    
    

    <div class="row" style = "margin:auto;">
        
        <div class="col-12 col-md-12">
            <center>
            <h3 style = "font-family: calibri;"><?php echo $_SESSION['name'] ?>'s <b>History <i class="fas fa-history"></i></b></h3>
            </center>
        </div>
    </div>
    
<br>



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



    <div class="row" style = "margin:auto;">
        
        <div class="col-12 col-md-12">
        
            <center>
                <table class="table table-striped">
            <thead class="thead-dark">
                <?php


                
                echo "
                    <tr>
                    <th scope=\"col\"><center>Start Date</center></th>
                    <th scope=\"col\"><center>End Date</center></th>
                    <th scope=\"col\"><center>Sunday</center></th>
                    <th scope=\"col\"><center>Monday</center></th>
                    <th scope=\"col\"><center>Tuesday</center></th>
                    <th scope=\"col\"><center>Wednesday</center></th>
                    <th scope=\"col\"><center>Thursday</center></th>
                    <th scope=\"col\"><center>Friday</center></th>
                    <th scope=\"col\"><center>Saturday</center></th>
                    <th scope=\"col\"><center>Total Hours</center></th>
                    </tr>
                ";
                ?>
                
            </thead>
            <tbody>
                <?php

    
                if(isset($_POST['submit'])){
                    $date = $_POST['date'];
                    $result = Database::get_history_by_date($_SESSION['id'], $date);
                    while(($row = $result->fetch_assoc())){
                        echo "
                            <tr>
                            <th><center>". $row['sunday_date'] . "</center></th>
                            <th><center>". $row['saturday_date'] . "</center></th>
                            <th><center>" . number_format((float)$row['Sunday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Monday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Tuesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Wednesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Thursday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Friday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Saturday'], '2', '.') . "</center></th>
                            <th><center><span style = \"color: red;\">"; if(!$row['Total_Hours']){echo "0.00";}else{echo number_format((float)$row['Total_Hours'], '2', '.');} echo "</span></center></th>
                            </tr>
                        ";

                      //echo $row['Total_Hours'] . "<br>";
                    }
                    //echo $date;
                }


                else if( ($result = Database::get_history($_SESSION['id'])) ){
                    while( ($row = $result->fetch_assoc()) ){
                        echo "
                            <tr>
                            <th><center>". $row['sunday_date'] . "</center></th>
                            <th><center>". $row['saturday_date'] . "</center></th>
                            <th><center>" . number_format((float)$row['Sunday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Monday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Tuesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Wednesday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Thursday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Friday'], '2', '.') . "</center></th>
                            <th><center>" . number_format((float)$row['Saturday'], '2', '.') . "</center></th>
                            <th><center><span style = \"color: red;\">"; if(!$row['Total_Hours']){echo "0.00";}else{echo number_format((float)$row['Total_Hours'], '2', '.');} echo "</span></center></th>
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