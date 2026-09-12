<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>História výpočtov</title>
    <link rel="stylesheet" href="design.css">
</head>

<body>

    <div class="history-box">

        <h2>História výpočtov</h2>
        <table class="history-table">
            <tr>
                <th>Kalkulačka</th>
                <th>Vstup</th>
                <th>Výsledok</th>
                <th>Dátum</th>
            </tr>

            <?php
                include 'backend/db_connect.php';

                $result = $conn->query(
                    "SELECT * FROM historie ORDER BY datum DESC"
                );

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['typ_kalkulacky']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vstup']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vysledok']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['datum']) . "</td>";
                    echo "</tr>";
                }
            ?>

        </table>

        <a class="back-button" href="menu.html">
            ← Späť
        </a>

    </div>

</body>
</html>