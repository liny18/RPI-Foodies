<?php
        if (isset($_SESSION['Banned'])) {
            header("Location: ../errorPage/banned.php");
        }
function calculate_time($date1) {
    //get current time with the format y-m-d h:i:s with time zone America/New_York
    date_default_timezone_set('America/New_York');
    $date2 = (date("Y-m-d H:i:s"));
    //get the difference between the two time
    $diff = abs(strtotime($date2) - strtotime($date1));
    $unit = "second";
    if ($diff >= 31536000) {
        $diff = round($diff / 31536000);
        $diff > 1 ? $unit = "years" : $unit = "year";
    } else if ($diff >= 2592000) {
        $diff = round($diff / 2592000);
        $diff > 1 ? $unit = "months" : $unit = "month";
    } else if ($diff >= 604800) {
        $diff = round($diff / 604800);
        $diff > 1 ? $unit = "weeks" : $unit = "week";
    } else if ($diff >= 86400) {
        $diff = round($diff / 86400);
        $diff > 1 ? $unit = "days" : $unit = "day";
    } else if ($diff >= 3600) {
        $diff = round($diff / 3600);
        $diff > 1 ? $unit = "hours" : $unit = "hour";
    } else if ($diff >= 60) {
        $diff = round($diff / 60);
        $diff > 1 ? $unit = "minutes" : $unit = "minute";
    } else {
        // seconds will count as just now
        $diff = "Just Now";
        return $diff;
    }
    return $diff . " " . $unit . " ago";
}
?>