<?php
require("connect.php");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Počasí</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
<?php

//$getAllLocalities = "";
//$saveWeatherdata = "";

function saveNewData($url, $filename, $connection){
    $dom = new DOMDocument();
    $dom -> load($url);
    $dom -> save($filename);
    $now = date("Y-m-d H:i:s");
    $sql_update_change = "UPDATE pocasi_lokality SET last_update = '".$now."' where filename = '".$filename."'";
    $result = mysqli_query($connection, $sql_update_change);
//    if($result) ...
}



set_time_limit(60);
$sql = "select * from pocasi_lokality order by url_parameter ASC";
$res = mysqli_query($connection, $sql);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)):
        $filename = $row['filename'];
        $urlLocality = $row['url_parameter'];
        $localityName = $row['name_cz'];
        $lastUpdate = $row['last_update'];

        $url = "https://www.yr.no/place/Czech_Republic/URL_PARAMETER/forecast_hour_by_hour.xml";
        $url = str_replace("URL_PARAMETER", $urlLocality, $url);

        if(strlen($localityName)>0) {
            echo "<a href='weatherdata.php?xml=$filename'>$localityName</a><br>";
//            $actual = new DateTime();
//            date_sub($actual, date_interval_create_from_date_string('1 day'));
//            COMPARING DATE WHEN DATA ARE OLDER THAN 1 DAY, CALLING saveNewData();
//            if(){
//                saveNewData($url, $filename, $spojeni);
//            }
        }
    endwhile;
}
mysqli_close($connection);

?>
</body>

</html>
