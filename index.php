<?php
require("connect.php");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Počasí</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body>
<?php

$getAllLocalities = "SELECT name_cz, filename FROM pocasi_lokality ORDER BY name_cz ASC";
$res = mysqli_query($connection, $getAllLocalities);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)):
        $filename = $row['filename'];
        $localityName = $row['name_cz'];
        if (strlen($localityName) > 0) {
            echo "<a href='weatherdata.php?xml=$filename'>$localityName</a><br>";
        }
    endwhile;
}
mysqli_close($connection);

?>
</body>

</html>
