<?php

class Database{
    // used on a localhost SQL database
    private static $servername = "localhost";
    private static $username = "root";
    private static $pass = "";
    private static $db_name = "timeline";

    public static function auth($email, $password){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);

        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }
        $password = md5($password);
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ? AND `password` = ?");
        if(!$stmt){
            echo "Bad statement";
        }

        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $conn->close();

            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['access_level'] = $row['access_level'];
            $_SESSION['id'] = $row['id'];
            
            return true;
        }
        else{
            $conn->close();
            return false;
        }
    }



    public static function get_users(){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `users`";
        $result = $conn->query($stmt);

        $conn->close();
        return $result;
    }



    public static function add_user($email, $password, $name, $access_level){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);

        echo $email . "<br>" . $name . "<br>" . $password . "<br>" . $access_level;

        $password = md5($password);
        $stmt = $conn->prepare("INSERT INTO `users`(`email`, `password`, `name`, `access_level`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $email, $password, $name, $access_level);
        $stmt->execute();
    
        if($stmt->affected_rows > 0){
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }    
    }



    public static function delete_user($email, $access_level, $id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);

        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = $conn->prepare("DELETE FROM `users` WHERE email = ?");
        $stmt->bind_param('s', $email); 
        $stmt->execute();
        if($stmt->affected_rows == 0){
            $conn->close();
            return false;
        }
        if($access_level != "2"){
            $stmt2 = $conn->prepare("DELETE FROM `timesheet` WHERE id = ?");
            $stmt2->bind_param('s', $id); 
            $stmt2->execute();
            if($stmt2->affected_rows > 0){
                $conn->close();
                return true;
            }
            else{
                $conn->close();
                return false;
            }
        }
        

    }


    public static function edit_user($user, $email, $name, $password, $access_level){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $password = md5($password);
        $stmt = $conn->prepare("UPDATE `users` SET `email`= ?,`password`= ?,`name`= ?,`access_level`= ? WHERE email = ?");
        $stmt->bind_param('sssss', $email, $password, $name, $access_level, $user);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }
    }


    public static function change_password($email, $password){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = $conn->prepare("UPDATE `users` SET `password`= ? WHERE email = ?");
        $stmt->bind_param('ss', $password, $email);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }
    }


    public static function get_user($email){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $result = $conn->query("SELECT * FROM `users` WHERE email = '$email'");

        if(mysqli_num_rows($result) > 0){
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }
    }


    



    /* --------------- Timesheet -------------------- */
    public static function add_timesheet($email){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `users` WHERE email = '" . $email . "'";
        $result = $conn->query($stmt);
        $row = $result->fetch_assoc();

        $d = General::get_dates_for_week_sql();
        $insert = "INSERT INTO `timesheet`(`id`, `Sunday`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Total_Hours`, `sunday_date`, `monday_date`, `tuesday_date`, `wednesday_date`, `thursday_date`, `friday_date`, `saturday_date`) VALUES ('" . $row['id'] . "','0.00','0.00','0.00','0.00','0.00','0.00','0.00', '0.00', '$d[0]', '$d[1]', '$d[2]', '$d[3]', '$d[4]', '$d[5]', '$d[6]')";
        $conn->query($insert);
        $conn->close();
    }


    public static function get_timesheet($id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `timesheet` WHERE id = '" . $id . "'";
        $result = $conn->query($stmt);
        
        if(mysqli_num_rows($result) > 0){
            $conn->close();
            return $result;
        }
        else{
            $conn->close();
            return false;
        }
        
    }

    public static function get_top_timesheet(){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `timesheet`";
        $result = $conn->query($stmt);
        
        if(mysqli_num_rows($result) > 0){
            $conn->close();
            return $result;
        }
        else{
            $conn->close();
            return false;
        }

        return $result;
        
    }


    public static function update_timesheet($id, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $total = (float)$sunday + (float)$monday + (float)$tuesday + (float)$wednesday + (float)$thursday + (float)$friday + (float)$saturday;

        if(($stmt = $conn->prepare("UPDATE `timesheet` SET `Sunday` = ?, `Monday` = ?, `Tuesday` = ?, `Wednesday` = ?, `Thursday` = ?, `Friday` = ?, `Saturday` = ?, `Total_Hours` = ? WHERE `id` = ?") ) and  ($stmt->bind_param('sssssssss', $sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $total, $id)) ){
            $stmt->execute();
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }
       
                
    }



    public static function update_timesheet_and_dates($id, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday_date, $monday_date, $tuesday_date, $wednesday_date, $thursday_date, $friday_date, $saturday_date){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $total = (float)$sunday + (float)$monday + (float)$tuesday + (float)$wednesday + (float)$thursday + (float)$friday + (float)$saturday;

        if(($stmt = $conn->prepare("UPDATE `timesheet` SET `sunday_date` = ?, `monday_date` = ?, `tuesday_date` = ?, `wednesday_date` = ?, `thursday_date` = ?, `friday_date` = ?, `saturday_date` = ?, `Sunday` = ?, `Monday` = ?, `Tuesday` = ?, `Wednesday` = ?, `Thursday` = ?, `Friday` = ?, `Saturday` = ?, `Total_Hours` = ? WHERE `id` = ?") ) and  ($stmt->bind_param('ssssssssssssssss', $sunday_date, $monday_date, $tuesday_date, $wednesday_date, $thursday_date, $friday_date, $saturday_date, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $total, $id)) ){
            $stmt->execute();
            $conn->close();
            return true;
        }
        else{
            $conn->close();
            return false;
        }
       
                
    }



    public static function preview_timesheet(){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `users` INNER JOIN `timesheet` ON users.id = timesheet.id";
        if(($result = $conn->query($stmt))){
            $conn->close();
            return $result;
        }
        else{
            return false;
        }
    }


    public static function get_user_time($id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `users` INNER JOIN `timesheet` ON users.id = timesheet.id AND users.id = '" . $id . "'";
        $result = $conn->query($stmt);
        
        if(mysqli_num_rows($result) > 0){
            $conn->close();
            return $result;
        }
        else{
            $conn->close();
            return false;
        }
    }







    /* History */
    public static function add_history($id, $report_id, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $total, $sunday_date, $monday_date, $tuesday_date, $wednesday_date, $thursday_date, $friday_date, $saturday_date, $name){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        date_default_timezone_set('America/Chicago');
        $time = date("l (m-d-y), h:ia");
        $conn->query("INSERT INTO `history`(`id`, `report_id`, `Sunday`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Total_Hours`, `sunday_date`, `monday_date`, `tuesday_date`, `wednesday_date`, `thursday_date`, `friday_date`, `saturday_date`, `name`, `time` ) VALUES ($id,'" . $report_id . "',$sunday,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday, $total, '" . $sunday_date . "','" . $monday_date . "','" . $tuesday_date . "','" . $wednesday_date . "','" . $thursday_date . "','" . $friday_date . "','" . $saturday_date . "','" . $name . "', '" . $time . "')");

        $conn->close();
    }




    public static function get_history($id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `history` WHERE id = '" . $id . "' ORDER BY history_id DESC";
        if(($result = $conn->query($stmt))){
            $conn->close();
            return $result;
        }
        else{
            return false;
        }
        
    }


    public static function get_history_by_date($id, $date){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

       $stmt = "SELECT * FROM `history` WHERE (`sunday_date` = '$date' AND `id` = '$id') OR (`monday_date` = '$date' AND `id` = '$id') OR (`tuesday_date` = '$date' AND `id` = '$id') OR (`wednesday_date` = '$date' AND `id` = '$id') OR (`thursday_date` = '$date' AND `id` = '$id') OR (`friday_date` = '$date' AND `id` = '$id') OR (`saturday_date` = '$date' AND `id` = '$id')";
       //$stmt->bind_param('s', $id);
       $result = $conn->query($stmt);
       $conn->close();
       return $result;


        
    }


    public static function get_reports(){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT DISTINCT `report_id`, `sunday_date`, `saturday_date`, `time` FROM `history` WHERE 1 ORDER BY history_id DESC";
        $result = $conn->query($stmt);
        $conn->close();
        return $result;
    }

    public static function get_report_by_date($date){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT DISTINCT `report_id`, `sunday_date`, `saturday_date`, `time` FROM `history` WHERE (`sunday_date` = '$date') OR (`monday_date` = '$date') OR (`tuesday_date` = '$date') OR (`wednesday_date` = '$date') OR (`thursday_date` = '$date') OR (`friday_date` = '$date') OR (`saturday_date` = '$date') ORDER BY history_id DESC";
        $result = $conn->query($stmt);
        $conn->close();
        return $result;
    }

    public static function get_report_by_id($report_id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "SELECT * FROM `history` WHERE `report_id` = '$report_id'";
        $result = $conn->query($stmt);

        if(mysqli_num_rows($result) > 0){
            $conn->close();
            return $result;
        }
        else{
            $conn->close();
            return false;
        }
    }

    public static function delete_report($id){
        $conn = new mysqli(Database::$servername, Database::$username, Database::$pass, Database::$db_name);
        // check connection
        if(!$conn){
            die("Connection Failed: " . $conn->connection_error);
        }

        $stmt = "DELETE FROM `history` WHERE `report_id` = '" . $id . "'";
        $conn->query($stmt);

    }

}

?>