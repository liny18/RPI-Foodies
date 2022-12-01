<?php


// i just create a two time for the sample, for our website, we need to read in the user input time as the format below
$date1 = ("2022-12-01 08:15:00");

function calculate_time($date1){
    //get current time with the format y-m-d h:i:s with time zone America/New_York
    date_default_timezone_set('America/New_York');
    $date2 = (date("Y-m-d H:i:s"));

//get the difference between the two time
    $diff = abs(strtotime($date2) - strtotime($date1));

// if the difference is less than 1 hour, we will show the minutes
    if ($diff < 3600) {
        $diff = round($diff / 60);
        echo $diff . " minutes ago";
    } else {
        // if the difference is less than 24 hour, we will show the hours
        if ($diff < 86400) {
            $diff = round($diff / 3600);
            echo $diff . " hours ago";
        } else {
            // if the difference is less than 7 days, we will show the days
            if ($diff < 604800) {
                $diff = round($diff / 86400);
                echo $diff . " days ago";
            } else {
                // if the difference is less than 30 days, we will show the weeks
                if ($diff < 2592000) {
                    $diff = round($diff / 604800);
                    echo $diff . " weeks ago";
                } else {
                    // if the difference is less than 365 days, we will show the months
                    if ($diff < 31536000) {
                        $diff = round($diff / 2592000);
                        echo $diff . " months ago";
                    } else {
                        // if the difference is more than 365 days, we will show the years
                        $diff = round($diff / 31536000);
                        echo $diff . " years ago";
                    }
                }
            }
        }
    }
}

// test the function
calculate_time($date1);

?>
