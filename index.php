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

$sql_all_localities = "";
$sql_save_weatherdata="INSERT INTO pocasi_lokality VALUES (NULL, )";

function saveNewData($url, $filename){
    $dom = new DOMDocument();
    $dom -> load($url);
    $dom -> save($filename);
}



set_time_limit(60);
$sql = "select * from pocasi_lokality order by url_parameter ASC";
$res = mysqli_query($spojeni, $sql);

if (mysqli_num_rows($res) > 0) {
    while ($radek = mysqli_fetch_assoc($res)):
        $fName = $radek['filename'];
        $urlPar = $radek['url_parameter'];
        $url = "https://www.yr.no/place/Czech_Republic/URL_PARAMETER/forecast_hour_by_hour.xml";
        $url = str_replace("URL_PARAMETER", $urlPar, $url);
        $pos = strpos($urlPar, '/');
        $locality = substr($urlPar, $pos+1);
        $par = substr($fName, 0, -4);
        $locality_rep = str_replace("_", " ", $locality);
        echo "<a href='weatherdata.php?xml=$par&name=$locality_rep'>$locality_rep</a><br>";
    endwhile;
}
mysqli_close($spojeni);

?>
</body>

</html>
