<?php
//require ("downloader.php");
function drawTableHeader()
{
    echo "<table width='1000' border='1' style='border-collapse: collapse'>";
    echo "<th>Platnost</th>";
    echo "<th>Teplota</th>";
    echo "<th>Rychlost větru</th>";
//    echo "<th>Název</th>";
    echo "<th>Směr větru</th>";
    echo "<th>Srážky</th>";

//
}

function drawTableData($timeFrom, $timeTo, $temp, $windSpeed, $windDir, $prec)
{
    echo "<tr align='center' height='50px'><td>" . $timeFrom . " - " . $timeTo . "</td>";
    echo "<td>$temp °C</td>";
    echo "<td>$windSpeed m/s</td>";
//    echo "<td>$windSpeedName</td>";
    echo "<td>$windDir</td>";
    echo "<td>$prec mm</td></tr>";
}

function drawTableBottom()
{
    echo "</table>";
}

//refactor to SQL query
//function loadXml($filename)
//{
//    drawTableHeader();
//    $date = new DateTime();
//    date_sub($date, date_interval_create_from_date_string('1 hour'));
//    $actual = date_format($date, 'Y-m-d\TH:m:s');
//    for ($i = 0; $i < $length; $i++) {
//        if ($actual >= $timeFrom) continue;
//        $timeFromTable = substr($timeFrom, 11, 5);
//        $timeToTable = substr($timeTo, 11, 5);
//        $actDay = date("d.m.Y", strtotime($timeTo));
////        echo $actDay;
//        if($actDay>"14.02.2020") break;
//        drawTableData($timeFromTable, $timeToTable, $temp, $windSpeed, $windDir, $prec);
//    }
//    drawTableBottom();
//}


function getWeather($filename)
{


}

$xmlFilename = $_GET['xml'];
//drawTable();
//loadXml($xmlFilename);
echo "<p>Data pro předpověď získána z webu <a href='https://www.yr.no' target='_blank'>yr.no</a></p>";

?>