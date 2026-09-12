<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Základná kalkulačka</title>
    <link rel="stylesheet" href="kalkulacka.css">
</head>
<body>

    <h1>Základná kalkulačka</h1>

    <div class="calc">
        <div class="display">
            <div class="display-history" id="history"></div>
            <div class="display-current" id="current">0</div>
        </div>

        <div class="keys">
            <button class="key key-clear" onclick="clearAll()">C</button>
            <button class="key key-op" onclick="appendOp('/')">÷</button>
            <button class="key key-op" onclick="appendOp('*')">×</button>
            <button class="key key-op" onclick="appendOp('-')">−</button>

            <button class="key" onclick="appendNum('7')">7</button>
            <button class="key" onclick="appendNum('8')">8</button>
            <button class="key" onclick="appendNum('9')">9</button>
            <button class="key key-op" onclick="appendOp('+')">+</button>

            <button class="key" onclick="appendNum('4')">4</button>
            <button class="key" onclick="appendNum('5')">5</button>
            <button class="key" onclick="appendNum('6')">6</button>
            <button class="key key-equals" onclick="calculate()">=</button>

            <button class="key" onclick="appendNum('1')">1</button>
            <button class="key" onclick="appendNum('2')">2</button>
            <button class="key" onclick="appendNum('3')">3</button>
            <button class="key key-op" onclick="appendOp('.')">.</button>

            <button class="key key-zero" onclick="appendNum('0')">0</button>
        </div>
    </div>

    <a class="back-button" href="../menu.html">← Späť</a>

    <script>
        let current = "0";
        let history = "";
        let justCalculated = false;

        const currentEl = document.getElementById("current");
        const historyEl = document.getElementById("history");

        function updateDisplay() {
            currentEl.textContent = current;
            historyEl.textContent = history;
        }

        function appendNum(num) {
            if (justCalculated) {
                current = "0";
                justCalculated = false;
            }
            if (current === "0" && num !== ".") {
                current = num;
            } else {
                current += num;
            }
            updateDisplay();
        }

        function appendOp(op) {
            if (justCalculated) {
                history = current;
                justCalculated = false;
            }

            if (op === ".") {
                if (!current.includes(".")) {
                    current += ".";
                }
                updateDisplay();
                return;
            }

            if (current === "" && history !== "") {
                history = history.slice(0, -1) + op;
            } else {
                history += current + op;
                current = "";
            }
            updateDisplay();
        }

        function calculate() {
            if (history === "" || current === "") return;

            const expression = history + current;
            let result;

            try {
                // Bezpečný výpočet – len čísla a operátory
                if (!/^[0-9+\-*/.() ]+$/.test(expression)) {
                    throw new Error("Neplatný výraz");
                }
                result = eval(expression);
                if (!isFinite(result)) throw new Error("Delenie nulou");
            } catch (e) {
                currentEl.textContent = "Chyba";
                historyEl.textContent = "";
                current = "0";
                history = "";
                justCalculated = true;
                return;
            }

            // Zobraz výsledok
            historyEl.textContent = expression + " =";
            currentEl.textContent = result;
            current = String(result);
            history = "";
            justCalculated = true;

            // Ulož do DB
            saveToHistory("Základná", expression, result);
        }

        function clearAll() {
            current = "0";
            history = "";
            justCalculated = false;
            updateDisplay();
        }

        function saveToHistory(typ, vstup, vysledok) {
            fetch("../backend/save_history.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "typ_kalkulacky=" + encodeURIComponent(typ)
                    + "&vstup=" + encodeURIComponent(vstup)
                    + "&vysledok=" + encodeURIComponent(vysledok)
            });
        }

        document.addEventListener("keydown", (e) => {
            if (/^[0-9]$/.test(e.key)) appendNum(e.key);
            else if (e.key === ".") appendOp(".");
            else if (["+", "-", "*", "/"].includes(e.key)) appendOp(e.key);
            else if (e.key === "Enter" || e.key === "=") calculate();
            else if (e.key === "Escape" || e.key === "c") clearAll();
            else if (e.key === "Backspace") {
                current = current.length > 1 ? current.slice(0, -1) : "0";
                updateDisplay();
            }
        });

        updateDisplay();
    </script>

</body>
</html>
