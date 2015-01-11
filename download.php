<?php

// this page makes admin download the CSV file, with time bounds specified in previous form
// yeah, it's mysql instead of mysqli/pdo. Mysql is simple!
include_once 'includes/connect.php';
            // functions
function buildcsv(){
    $start = $_POST['start'];
    $end = $_POST['end'];
    $result = mysql_query('SELECT fullname, institution, email, timestamp, responsesJSON
        FROM `members` WHERE timestamp BETWEEN "'.$start.'" AND "'.$end.'"');
    if (!$result) die('Couldn\'t fetch records');
    ob_start();
    $fp = fopen('php://output', 'a');
    if ($fp && $result) {
        $headertitles = array('fullname', 'instituition', 'email', 'timestamp');
        $scoretitles = range(1, 200);
        fputcsv($fp, array_merge($headertitles, $scoretitles));
        
        while ($row = mysql_fetch_assoc($result)) {
            $personal = array($row['fullname'], $row['institution'], $row['email'], $row['timestamp']);
            $scores = json_decode($row['responsesJSON'], true);
            fputcsv($fp, array_merge($personal, $scores));
        }
        fclose($fp);
        return ob_get_clean();
    }else{
        $error = "Error. Either there is no data or invalid date.";
        return $error;
    }

}

            function download_send_headers($filename) {
                // disable caching
                $now = gmdate("D, d M Y H:i:s");
                header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
                header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
                header("Last-Modified: {$now} GMT");
                // force download  
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");
                // disposition / encoding on response body
                header("Content-Disposition: attachment;filename={$filename}");
                header("Content-Transfer-Encoding: binary");
            }
            
            if (isset($_POST['start']) && isset($_POST['end'])){ // force download
                download_send_headers("data_export_" . date("Y-m-d") . ".csv");
                echo buildcsv(); // these headers must be standalone on a pure php page to work
                die();
            }
?>

