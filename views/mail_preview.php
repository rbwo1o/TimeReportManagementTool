<?php

//Flight::redirect("https://www.google.com/search?q=composer+ignore+platform+reqs&rlz=1C1ONGR_enUS932US932&oq=composer+ignro&aqs=chrome.1.69i57j0i13l9.3577j0j7&sourceid=chrome&ie=UTF-8");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
$mail = new PHPMailer();


$top = Database::get_top_timesheet();
$top_row = $top->fetch_assoc();
$result = Database::preview_timesheet();



try {
    $mail->SMTPDebug = 2;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'mail.blomand.net;';                  
    $mail->SMTPAuth   = true;                             
    $mail->Username   = USERNAME; // !!!                 
    $mail->Password   = PASSWORD; // !!!                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  
  
    $mail->setFrom(USERNAME, USERNAME); // !!!           

    $mail->addAddress(SEND_TO, NAME); // !!!
    
       
    $mail->isHTML(true);                                  
    $mail->Subject = 'Timesheet Preview (Test)';
    $mail->Body    = "
    <style>

    table, td, th {  
        border: 1px solid #ddd;
        text-align: left;
      }
      
      table {
        border-collapse: collapse;
        width: 100%;
      }
      
      th, td {
        padding: 15px;
      }
    
      tr:nth-child(even) {background-color: #f2f2f2;}
    
    </style>
    
    
    
    
    <img src = \"https://benlomandconnect.com/wp-content/uploads/logo-1.svg\" align=\"center\">
    <br>
    <br>
    <h3 align = \"center\" style = \"font-family: calibri; text-decoration: underline; font-weight: normal;\">Time Report <b>Preview</b></h3>
    <br>
    
    
    
    <table autosize = \"1\" style = \"width: 100%;\">
                <thead class=\"thead-dark\">
                        <tr style = \"border: 1px solid gray; background-color: rgb(32,117,183);\">
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">Employee Names</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['sunday_date'])) . "<br>Sunday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['monday_date'])) . "<br>Monday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['tuesday_date'])) . "<br>Tuesday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['wednesday_date'])) . "<br>Wednesday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['thursday_date'])) . "<br>Thursday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['friday_date'])) . "<br>Friday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">" . date('m/d/y', strtotime($top_row['saturday_date'])) . "<br>Saturday</h5></th>
                        <th scope=\"col\"><h5 style = \"color: white; font-family: calibri;\">Total Hours</h5></th>
                        </tr>
                    
                </thead>
            
    
                <tbody>
                
                ";


                while( ($row = $result->fetch_assoc()) ){
                            
                    $mail->Body = $mail->Body . "
                    <tr style = \"margin-top: 50px;\">
                    <th><h6 style = \"font-weight: normal;\">" . $row['name'] . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Sunday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Monday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Tuesday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Wednesday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Thursday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Friday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Saturday'], '2', '.') . "</h6></th>
                    <th><h6 style = \"font-weight: normal;\"><span style = \"color: red;\">"; if(!$row['Total_Hours']){$mail->Body = $mail->Body .  "0.00";}else{$mail->Body = $mail->Body . number_format((float)$row['Total_Hours'], '2', '.');} $mail->Body = $mail->Body . "</span></h6></th>
                    </tr>";
}



$mail->Body = $mail->Body . " </tbody>
    </table>
    
    ";  

    //$mail->Body = $mail->Body . " <br> A new line";
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
    $_SESSION['mail_preview'] = true;
    Flight::redirect("/report");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>