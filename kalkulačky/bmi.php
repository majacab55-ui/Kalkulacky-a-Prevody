<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI kalkulačka</title>
    <link rel="stylesheet" href="kalkulacka.css">
</head>
<body>

    <h1>BMI kalkulačka</h1>

    <div class="bmi-box">

        <div class="bmi-row">
            <label class="bmi-radio">
                <input type="radio" name="pohlavie" value="muz" checked>
                <span>Muž</span>
            </label>
            <label class="bmi-radio">
                <input type="radio" name="pohlavie" value="zena">
                <span>Žena</span>
            </label>
        </div>

        <div class="bmi-row" id="vyska-metricka">
            <label for="vyska-cm">Výška *</label>
            <div class="bmi-input">
                <input type="number" id="vyska-cm" placeholder="0" step="0.1">
                <span>cm</span>
            </div>
        </div>

        <div class="bmi-row" id="vyska-imperialna" style="display:none;">
            <label>Výška *</label>
            <div class="bmi-input-group">
                <div class="bmi-input">
                    <input type="number" id="vyska-ft" placeholder="0" step="1" min="0">
                    <span>ft</span>
                </div>
                <div class="bmi-input">
                    <input type="number" id="vyska-in" placeholder="0" step="1" min="0" max="11">
                    <span>in</span>
                </div>
            </div>
        </div>

        <div class="bmi-row">
            <label for="hmotnost">Hmotnosť *</label>
            <div class="bmi-input">
                <input type="number" id="hmotnost" placeholder="0" step="0.1">
                <span id="hmotnost-jednotka">kg</span>
            </div>
        </div>

        <div class="bmi-row">
            <label for="vek">Vek (1 rok alebo viac) *</label>
            <div class="bmi-input">
                <input type="number" id="vek" placeholder="0" step="1">
                <span>roky</span>
            </div>
        </div>

        <div class="bmi-row bmi-units">
            <label class="bmi-radio">
                <input type="radio" name="jednotky" value="metricke" checked onchange="prepniJednotky()">
                <span>Metrické</span>
            </label>
            <label class="bmi-radio">
                <input type="radio" name="jednotky" value="imperialne" onchange="prepniJednotky()">
                <span>Imperiálne</span>
            </label>
        </div>

        <div class="bmi-row bmi-button-row">
            <button class="bmi-button" onclick="vypocitajBMI()">Vypočítať</button>
        </div>

        <div class="bmi-result" id="vysledok" style="display:none;">
            <div class="bmi-value" id="bmi-hodnota">0</div>
            <div class="bmi-category" id="bmi-kategoria"></div>
        </div>

    </div>

    <a class="back-button" href="../menu.html">← Späť</a>

    <script>
        function prepniJednotky() {
            const jednotky = document.querySelector('input[name="jednotky"]:checked').value;
            const vyskaMetr = document.getElementById('vyska-metricka');
            const vyskaImp  = document.getElementById('vyska-imperialna');
            const hmotnostJed = document.getElementById('hmotnost-jednotka');

            if (jednotky === 'metricke') {
                vyskaMetr.style.display = 'block';
                vyskaImp.style.display = 'none';
                hmotnostJed.textContent = 'kg';
            } else {
                vyskaMetr.style.display = 'none';
                vyskaImp.style.display = 'block';
                hmotnostJed.textContent = 'lb';
            }

            document.getElementById('vysledok').style.display = 'none';
        }

        function vypocitajBMI() {
            const jednotky = document.querySelector('input[name="jednotky"]:checked').value;
            const hmotnost = parseFloat(document.getElementById('hmotnost').value);
            const vek = parseInt(document.getElementById('vek').value);

            let vyskaCm = 0;
            let vstupText = '';

            if (jednotky === 'metricke') {
                vyskaCm = parseFloat(document.getElementById('vyska-cm').value);

                if (isNaN(vyskaCm) || isNaN(hmotnost) || isNaN(vek)
                    || vyskaCm <= 0 || hmotnost <= 0 || vek <= 0) {
                    alert('Prosím, vyplň všetky polia správne.');
                    return;
                }

                vstupText = `Výška: ${vyskaCm} cm, Hmotnosť: ${hmotnost} kg, Vek: ${vek}`;
            } else {
                const ft = parseFloat(document.getElementById('vyska-ft').value) || 0;
                const inch = parseFloat(document.getElementById('vyska-in').value) || 0;

                if ((ft <= 0 && inch <= 0) || isNaN(hmotnost) || isNaN(vek)
                    || hmotnost <= 0 || vek <= 0) {
                    alert('Prosím, vyplň všetky polia správne.');
                    return;
                }

                vyskaCm = (ft * 30.48) + (inch * 2.54);

                vstupText = `Výška: ${ft} ft ${inch} in, Hmotnosť: ${hmotnost} lb, Vek: ${vek}`;
            }

            let hmotnostKg = hmotnost;
            if (jednotky === 'imperialne') {
                hmotnostKg = hmotnost * 0.4536;
            }

            const vyskaMetre = vyskaCm / 100;
            const bmi = hmotnostKg / (vyskaMetre * vyskaMetre);

            let kategoria = '';
            let farba = '';
            if (bmi < 18.5) {
                kategoria = 'Podváha';
                farba = '#F5C542';
            } else if (bmi < 25) {
                kategoria = 'Normálna hmotnosť';
                farba = '#7CB342';
            } else if (bmi < 30) {
                kategoria = 'Nadváha';
                farba = '#F5A96B';
            } else {
                kategoria = 'Obezita';
                farba = '#E74C3C';
            }

            const vysledokBox = document.getElementById('vysledok');
            const bmiHodnota = document.getElementById('bmi-hodnota');
            const bmiKategoria = document.getElementById('bmi-kategoria');

            bmiHodnota.textContent = bmi.toFixed(1);
            bmiHodnota.style.color = farba;
            bmiKategoria.textContent = kategoria;
            bmiKategoria.style.color = farba;
            vysledokBox.style.display = 'block';

            saveToHistory('BMI', vstupText, bmi.toFixed(1) + ' (' + kategoria + ')');
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