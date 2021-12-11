<?php

class General{

    public static function get_dates_for_week_sql(){
        // first day of week is sunday. Find sundays date.
        $today = date("l");
        $count = 0;
        while($today != "Sunday"){
            $count--;
            $today = date('l', strtotime("+" . $count . " days"));
        }

        // $count now becomes the number of days back that was the beginning of the week.
        $dates = array();
        array_push($dates, date('Y-m-d', strtotime("+" . $count . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 1 . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 2 . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 3 . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 4 . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 5 . " days")));
        array_push($dates, date('Y-m-d', strtotime("+" . $count + 6 . " days")));

        /*echo date('d/m/y', strtotime("+" . $count + 1 . " days")) . "<br>";
        echo date('d/m/y', strtotime("+" . $count + 2 . " days")) . "<br>";
        echo date('d/m/y', strtotime("+" . $count + 3 . " days")) . "<br>";
        echo date('d/m/y', strtotime("+" . $count + 4 . " days")) . "<br>";
        echo date('d/m/y', strtotime("+" . $count + 5 . " days")) . "<br>";
        echo date('d/m/y', strtotime("+" . $count + 6 . " days")) . "<br>";*/

        return $dates;
    }


    public static function validate_time($time){
        // generate array of correct time values
        $time_values = array();
        for($i = 0; $i <= 24; $i+= 0.25){
            array_push($time_values, $i);
        }
        // check time for correct values
        foreach($time_values as $value){
            if($time == $value){
                return true;
            }
        }

        return false;
    }
    
}

?>