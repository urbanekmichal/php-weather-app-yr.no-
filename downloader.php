<?php
require("connect.php");

function recoverLastUpdate($connection){
    $sql_recover = "UPDATE `pocasi_lokality` SET `last_update`='2020-01-01 00:00:00' WHERE 1";
    $result = mysqli_query($connection, $sql_recover);
    if ($result) {
        echo "Last updates was updated";
    }
}

function saveHourData($url, $filename, $connection)
{
    $dom = new DOMDocument();
    $dom->load($url);
    $dom->save("./download-hour/$filename");
    $now = date("Y-m-d H:i:s");
    $sql_update_change = "UPDATE pocasi_lokality SET last_update = '" . $now . "' where filename = '" . $filename . "'";
    $result = mysqli_query($connection, $sql_update_change);
    if ($result) {
        echo $filename." downloaded";
        mysqli_close($connection);
    }
}

function checkHourData($connection)
{
    $yest = new DateTime();
    $yest->add(DateInterval::createFromDateString('yesterday'));
    $yest_sql = date("Y-m-d H:i:s", $yest->getTimestamp());
    $sql_select = "SELECT url_parameter, filename FROM pocasi_lokality where last_update < '$yest_sql'";
    $result = mysqli_query($connection, $sql_select);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)):
            $filename = $row['filename'];
            $urlLocality = $row['url_parameter'];
            $url = "https://www.yr.no/place/Czech_Republic/URL_PARAMETER/forecast_hour_by_hour.xml";
            $url = str_replace("URL_PARAMETER", $urlLocality, $url);
            saveHourData($url, $filename, $connection);
            break;
        endwhile;
    }
}


checkHourData($connection);
//recoverLastUpdate($connection);

?>