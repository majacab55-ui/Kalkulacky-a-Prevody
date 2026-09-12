<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Príjem vody</title>
    <link rel="stylesheet" href="kalkulacka.css">
</head>
<body>

    <h1>Príjem vody</h1>

    <div class="water-box">
        <div class="glass">
            <div class="water" id="water-fill" style="height: 0%;"></div>
            <div class="glass-label" id="glass-label">0 L</div>
        </div>

        <div class="water-form">

            <div class="water-row">
                <label class="bmi-radio">
                    <input type="radio" name="pohlavie" value="muz" checked>
                    <span>Muž</span>
                </label>
                <label class="bmi-radio">
                    <input type="radio" name="pohlavie" value="zena">
                    <span>Žena</span>
                </label>
            </div>

            <div class="water-row bmi-units">
                <label class="bmi-radio">
                    <input type="radio" name="jednotky" value="metricke" checked onchange="prepniJednotky()">
                    <span>Metrické</span>
                </label>
                <label class="bmi-radio">
                    <input type="radio" name="jednotky" value="imperialne" onchange="prepniJednotky()">
                    <span>Imperiálne</span>
                </label>
            </div>

            <div class="water-row">
                <label for="hmotnost">Hmotnosť *</label>
                <div class="bmi-input">
                    <input type="number" id="hmotnost" placeholder="0" step="0.1" min="1">
                    <span id="hmotnost-jednotka">kg</span>
                </div>
            </div>

            <div class="water-row">
                <label for="aktivita">Fyzická aktivita</label>
                <div class="bmi-input">
                    <select id="aktivita">
                        <option value="0">Žiadna (sedavý spôsob)</option>
                        <option value="300">Ľahká (1–2× týždenne)</option>
                        <option value="500" selected>Stredná (3–4× týždenne)</option>
                        <option value="800">Vysoká (5+× týždenne)</option>
                    </select>
                </div>
            </div>

            <div class="water-row">
                <label for="teplota">Teplota prostredia</label>
                <div class="bmi-input">
                    <select id="teplota">
                        <option value="0">Chladno (&lt; 15 °C)</option>
                        <option value="200" selected>Mierne (15–25 °C)</option>
                        <option value="400">Teplo (25–30 °C)</option>
                        <option value="600">Horúco (&gt; 30 °C)</option>
                    </select>
                </div>
            </div>

            <div class="water-row water-button-row">
                <button class="bmi-button" onclick="vypocitajVodu()">Vypočítať</button>
            </div>

            <div class="water-result" id="vysledok" style="display:none;">
                <div class="water-value" id="water-value">0 L</div>
                <div class="water-info" id="water-info"></div>
            </div>

        </div>

    </div>

    <a class="back-button" href="../menu.html">← Späť</a>

    <script>
        function prepniJednotky() {
            const jednotky = document.querySelector('input[name="jednotky"]:checked').value;
            document.getElementById('hmotnost-jednotka').textContent =
                jednotky === 'metricke' ? 'kg' : 'lb';
            document.getElementById('vysledok').style.display = 'none';
        }

        function vypocitajVodu() {
            let hmotnost = parseFloat(document.getElementById('hmotnost').value);
            const jednotky = document.querySelector('input[name="jednotky"]:checked').value;
            const pohlavie = document.querySelector('input[name="pohlavie"]:checked').value;
            const aktivita = parseFloat(document.getElementById('aktivita').value);
            const teplota = parseFloat(document.getElementById('teplota').value);

            if (isNaN(hmotnost) || hmotnost <= 0) {
                alert('Prosím, zadaj svoju hmotnosť.');
                return;
            }

            if (jednotky === 'imperialne') {
                hmotnost = hmotnost * 0.4536;
            }

            let ml = hmotnost * (pohlavie === 'muz' ? 30 : 28);
            ml += aktivita;
            ml += teplota;

            const litre = ml / 1000;

            document.getElementById('water-value').textContent = litre.toFixed(2) + ' L';

            const flOz = ml * 0.033814;
            const poharov = Math.round(ml / 250);
            document.getElementById('water-info').textContent =
                `To je približne ${poharov} pohárov (250 ml) denne. `
                + `(≈ ${flOz.toFixed(1)} fl oz)`;

            document.getElementById('vysledok').style.display = 'block';

            const percento = Math.min((litre / 4) * 100, 100);
            document.getElementById('water-fill').style.height = percento + '%';
            document.getElementById('glass-label').textContent = litre.toFixed(2) + ' L';

            const vstupText = `${pohlavie === 'muz' ? 'Muž' : 'Žena'}, `
                            + `Hmotnosť: ${document.getElementById('hmotnost').value} `
                            + `${jednotky === 'metricke' ? 'kg' : 'lb'}, `
                            + `Aktivita: ${document.getElementById('aktivita').selectedOptions[0].text}, `
                            + `Teplota: ${document.getElementById('teplota').selectedOptions[0].text}`;
            saveToHistory('Príjem vody', vstupText, litre.toFixed(2) + ' L');
        }

        function saveToHistory(typ, vstup, vysledok) {
            fetch('../backend/save_history.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'typ_kalkulacky=' + encodeURIComponent(typ)
                    + '&vstup=' + encodeURIComponent(vstup)
                    + '&vysledok=' + encodeURIComponent(vysledok)
            });
        }
    </script>
</body>
</html>