<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $typ = $_POST['typ_kalkulacky'] ?? '';
    $vstup = $_POST['vstup'] ?? '';
    $vysledok = $_POST['vysledok'] ?? '';

    $stmt = $conn->prepare(
        "INSERT INTO historie (typ_kalkulacky, vstup, vysledok) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $typ, $vstup, $vysledok);
    $stmt->execute();
    $stmt->close();

    echo "OK";
}

$conn->close();
?>
