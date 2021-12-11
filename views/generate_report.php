<?php


use Mpdf\Mpdf;

if(isset($_SESSION['generate_report'])){

// reference the Dompdf namespace


$mpdf = new Mpdf();
$result = Database::preview_timesheet();

$top = Database::get_top_timesheet();
$top_row = $top->fetch_assoc();

$mpdf->SetTitle('Time Report');
$data = "

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
<h3 align = \"center\" style = \"font-family: calibri; text-decoration: underline; font-weight: normal;\">Time Report</h3>
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
                            
                            $data = $data . "
                            <tr style = \"margin-top: 50px;\">
                            <th><h6 style = \"font-weight: normal;\">" . $row['name'] . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Sunday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Monday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Tuesday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Wednesday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Thursday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Friday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\">" . number_format((float)$row['Saturday'], '2', '.') . "</h6></th>
                            <th><h6 style = \"font-weight: normal;\"><span style = \"color: red;\">"; if(!$row['Total_Hours']){$data = $data .  "0.00";}else{$data = $data . number_format((float)$row['Total_Hours'], '2', '.');} $data = $data . "</span></h6></th>
                            </tr>";
}



$data = $data . " </tbody>
            </table>
            
            <br>
            <br>
            <br>
            <h4 style = \"font-family:calibri; width: 100%; border-bottom: solid 1px black;\">Supervisor Signature:</h4>
            ";       


$mpdf->WriteHTML($data);
$mpdf->Output('report.pdf', 'D');




// save to history
$result3 = Database::preview_timesheet();
$d = General::get_dates_for_week_sql();
$report_id = md5($d[0] . $d[6] . time()); // gets the unique report ID 


while(($row = $result3->fetch_assoc())){
    Database::add_history($row['id'], $report_id, $row['Sunday'], $row['Monday'], $row['Tuesday'], $row['Wednesday'], $row['Thursday'], $row['Friday'], $row['Saturday'], $row['Total_Hours'], $row['sunday_date'], $row['monday_date'], $row['tuesday_date'], $row['wednesday_date'], $row['thursday_date'], $row['friday_date'], $row['saturday_date'], $row['name']); 
}




$result2 = Database::preview_timesheet();
while(($row = $result2->fetch_assoc())){
    Database::update_timesheet_and_dates($row['id'], 0, 0, 0, 0, 0, 0, 0, $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6]);
}

$_SESSION['generate_report'] = null;
}
else{
  Flight::redirect("/report");
}

?>