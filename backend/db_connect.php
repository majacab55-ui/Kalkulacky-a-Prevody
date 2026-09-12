<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kalkulacky";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Pripojenie k databáze zlyhalo: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
?>