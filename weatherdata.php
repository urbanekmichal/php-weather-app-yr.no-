<?php
function getWeather($filename)
{
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($filename);
    $date = new DateTime();
    date_sub($date, date_interval_create_from_date_string('1 hour'));
    $new = date_format($date, 'Y-m-d\TH:m:s');
    $searchNode = $xmlDoc->getElementsByTagName("tabular");
    foreach ($searchNode as $searchNode) {
        $length = $searchNode->getElementsByTagName("time")->length;
        echo "<table width='1000' border='1' style='border-collapse: collapse'>";
        echo "<th>Platnost</th>";
        echo "<th>Teplota</th>";
        echo "<th>Rychlost větru</th>";
//        echo "<th>Název</th>";
        echo "<th>Směr větru</th>";
        echo "<th>Srážky</th>";
        for ($i = 0; $i < $length; $i++) {

            $timeFrom = $searchNode->getElementsByTagName("time")->item($i)->getAttribute("from");
            if ($new >= $timeFrom) continue;
            $timeTo = $searchNode->getElementsByTagName("time")->item($i)->getAttribute("to");
            $temp = $searchNode->getElementsByTagName("temperature")->item($i)->getAttribute("value");
            $prec = $searchNode->getElementsByTagName("precipitation")->item($i)->getAttribute("value");
            $windDir = $searchNode->getElementsByTagName("windDirection")->item($i)->getAttribute("code");
            $windSpeed = $searchNode->getElementsByTagName("windSpeed")->item($i)->getAttribute("mps");
//            $windSpeedName = $searchNode->getElementsByTagName("windSpeed")->item($i)->getAttribute("name");
            $timeFrom = substr($timeFrom, 11, 5);
            $timeTo = substr($timeTo, 11, 5);
            echo "<tr align='center' height='50px'><td>" . $timeFrom . " - " . $timeTo . "</td>";
            echo "<td>$temp °C</td>";
            echo "<td>$windSpeed m/s</td>";
//            echo "<td>$windSpeedName</td>";
            echo "<td>$windDir</td>";
            echo "<td>$prec mm</td></tr>";

        }
        echo "</table><br>";
    }
}

$xmlFilename = $_GET['xml'];
getWeather($xmlFilename);
echo "<p>Data pro předpověď získána z webu <a href='https://www.yr.no' target='_blank'>yr.no</a></p>";

?>