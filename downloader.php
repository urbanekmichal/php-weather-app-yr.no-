<?php
require("connect.php");
global $connection;
$download_dir = "./download-hour/";

/**
 * testing function
 */
function recoverLastUpdate()
{
    global $connection;
    $sql_recover = "UPDATE pocasi_lokality SET last_update='2020-01-01 00:00:00' WHERE 1";
    $result = mysqli_query($connection, $sql_recover);
    if ($result) {
        echo "Last updates was updated";
    }
}

function deleteOldData()
{
//TODO - smazání starých dat z DB
// insert nových dat ze souboru
// OR
// případně stažení souboru a následný insert
}

/**
 * @param $url - source url for download XML
 * @param $path - saving file location
 *
 * saving XML file from yrno on server
 */
function saveXmlHour($url, $path)
{
    $dom = new DOMDocument();
    $dom->load($url);
    $dom->save($path);
}

/**
 * @param $dir - scanned directory for getting files to parse
 *
 * parse XML file
 */
function parseXmlHour($dir)
{
    global $connection;
    $locality_id = -1;
    $res = scandir("./$dir");
    array_shift($res);
    array_shift($res);
    chdir($dir);
    foreach ($res as $file) {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($file);
        $sql_get_locality_id = "SELECT id FROM pocasi_lokality where filename='$file'";
        $result = mysqli_query($connection, $sql_get_locality_id);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $locality_id = $row['id'];
        }
        $searchNode = $xmlDoc->getElementsByTagName("tabular")->item(0);
        $length = $searchNode->getElementsByTagName("time")->length;
        for ($i = 0; $i < $length; $i++) {
            $timeFrom = $searchNode->getElementsByTagName("time")->item($i)->getAttribute("from");
            $timeTo = $searchNode->getElementsByTagName("time")->item($i)->getAttribute("to");
            $temp = $searchNode->getElementsByTagName("temperature")->item($i)->getAttribute("value");
            $prec = $searchNode->getElementsByTagName("precipitation")->item($i)->getAttribute("value");
            $windDir = $searchNode->getElementsByTagName("windDirection")->item($i)->getAttribute("code");
            $windSpeed = $searchNode->getElementsByTagName("windSpeed")->item($i)->getAttribute("mps");
            $windSpeedName = $searchNode->getElementsByTagName("windSpeed")->item($i)->getAttribute("name");
            $sql_insert = "INSERT INTO pocasi_predpoved VALUES (NULL, '$timeFrom','$timeTo','$temp','$windDir','$windSpeed','$windSpeedName','$prec', '$locality_id')";
            storeXmlHour($sql_insert);
        }
        $now = date("Y-m-d H:i:s");
        $sql_update_change = "UPDATE pocasi_lokality SET last_update = '" . $now . "' where filename = '" . $file . "'";
        echo $sql_update_change;
        $result = mysqli_query($connection, $sql_update_change);
        if ($result) {
            ;
        }
    }
}

/**
 * @param $sql - SQL query for insert
 *
 * save row from XML file to DB
 */
function storeXmlHour($sql)
{
    global $connection;
    $result = mysqli_query($connection, $sql);
    if ($result) {
    } else {
        echo mysqli_error($connection);
    }
    return;
}

/**
 * @param $filename
 */
function checkHourData($filename)
{
    global $download_dir, $connection;
    try {
        $yest = new DateTime();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
    $yest->add(DateInterval::createFromDateString('yesterday'));
    $yest_sql = date("Y-m-d H:i:s", $yest->getTimestamp());
    $sql_old_data = "SELECT url_parameter FROM pocasi_lokality where last_update < '$yest_sql' AND filename = '$filename'";
    $result = mysqli_query($connection, $sql_old_data);
    if (mysqli_num_rows($result)>0) {
        echo "Pro tuto lokalitu nemáme aktuální data! ";
        $row = mysqli_fetch_assoc($result);
        $path = $download_dir . $filename;
        echo $filename."<br>";
        $urlLocality = $row['url_parameter'];
        $url = "https://www.yr.no/place/Czech_Republic/URL_PARAMETER/forecast_hour_by_hour.xml";
        $url = str_replace("URL_PARAMETER", $urlLocality, $url);
        echo $url;
        saveXmlHour($url, $path);
    }
}


$file = $_GET['xml'];
checkHourData($file);
parseXmlHour($download_dir);


//recoverLastUpdate($connection);

?>