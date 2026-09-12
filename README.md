# Kalkulačky a prevody

Webová aplikácia vytvorená ako školský projekt na precvičenie práce s **HTML, CSS, JavaScriptom, PHP a MySQL**.

Aplikácia obsahuje viacero kalkulačiek, ktoré umožňujú používateľovi vykonávať rôzne výpočty. Výsledok sa zobrazí okamžite pomocou JavaScriptu a vybrané výpočty sa zároveň ukladajú do databázy.

---

## Funkcie

Projekt obsahuje tieto kalkulačky:

- **Základná kalkulačka** – sčítanie, odčítanie a ďalšie základné matematické operácie
- **BMI kalkulačka** – výpočet indexu telesnej hmotnosti
- **Kalkulačka príjmu vody** – odporúčaný denný príjem vody
- **Prevod jednotiek** – prevod medzi rôznymi jednotkami

### História výpočtov

Výsledky výpočtov sa odosielajú pomocou JavaScriptu (`fetch`) na PHP backend, ktorý ich uloží do MySQL databázy.

Na samostatnej stránke `historia.php` sa následne zobrazujú všetky uložené výpočty.

---

## Použité technológie

- **HTML** – štruktúra webových stránok
- **CSS** – vzhľad a dizajn aplikácie
- **JavaScript** – výpočty a komunikácia so serverom bez obnovovania stránky
- **PHP** – backend a ukladanie údajov
- **MySQL** – databáza pre históriu výpočtov
- **AJAX / Fetch API** – odosielanie údajov medzi JavaScriptom a PHP

---

## Štruktúra projektu

```text
Kalkulacky-a-Prevody/
│
├── menu.html              # Hlavná stránka s výberom kalkulačiek
├── historia.php           # Stránka s históriou výpočtov (číta z DB)
├── design.css             # Spoločný CSS štýl pre celý projekt
├── README.md              # Tento súbor
│
├── kalkulacky/
│   ├── basic.php          # Základná kalkulačka
│   ├── bmi.php            # BMI kalkulačka
│   ├── voda.php           # Kalkulačka príjmu vody
│   └── jednotky.php       # Prevod jednotiek
│
└── backend/
    ├── db_connect.php     # Pripojenie k MySQL databáze
    └── save_history.php   # Uloženie výpočtu do DB (volané cez fetch)
```

---

## Spustenie projektu

Na spustenie projektu je potrebný lokálny server **XAMPP** (Apache + MySQL + PHP).

### 1. Inštalácia XAMPP

Stiahni a nainštaluj [XAMPP](https://www.apachefriends.org/).

Spusti **XAMPP Control Panel** a zapni:

- **Apache**
- **MySQL**

> **Dôležité:** Ak máš na Windows zapnutý **IIS** (Internet Information Services), môže blokovať port 80. V takom prípade buď IIS vypni, alebo v XAMPP nastav Apache na iný port (napr. `81`).

### 2. Umiestnenie projektu

Celý priečinok projektu vlož do:

```text
C:\xampp\htdocs\Kalkulacky-a-Prevody\
```

### 3. Vytvorenie databázy

Otvor v prehliadači phpMyAdmin:

```text
http://localhost:81/phpmyadmin
```

(Ak máš Apache na porte 80, použi `http://localhost/phpmyadmin`.)

Vytvor novú databázu s názvom:

```text
kalkulacky
```

Následne v tejto databáze spusti tento SQL príkaz (záložka **SQL**):

```sql
CREATE TABLE historie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    typ_kalkulacky VARCHAR(50),
    vstup VARCHAR(255),
    vysledok VARCHAR(255),
    datum DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### 4. Nastavenie pripojenia k databáze

V súbore `backend/db_connect.php` nastav údaje potrebné na pripojenie k MySQL:

```php
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
```

> Predvolené XAMPP údaje sú `root` / prázdne heslo. Ak máš iné, uprav ich.

### 5. Spustenie aplikácie

Po zapnutí Apache a MySQL otvor v prehliadači:

```text
http://localhost:81/Kalkulacky-a-Prevody/menu.html
```

> Ak máš Apache na porte 80, použi `http://localhost/Kalkulacky-a-Prevody/menu.html`.

---

## Ako to funguje

Proces výpočtu prebieha nasledovne:

1. Používateľ zadá údaje do formulára v niektorej kalkulačke.
2. Klikne na tlačidlo pre výpočet.
3. JavaScript spracuje zadané hodnoty.
4. Výsledok sa okamžite zobrazí na stránke (bez obnovenia).
5. JavaScript odošle údaje pomocou `fetch()` na `backend/save_history.php`.
6. PHP prijme údaje a uloží ich do MySQL tabuľky `historie`.
7. História výpočtov sa zobrazí na stránke `historia.php`.

Vďaka JavaScriptu nie je pri samotnom výpočte potrebné obnovovať celú stránku.

---

## Časté problémy

### Vidím holý PHP kód namiesto stránky

Súbor otváraš cez `file:///...` – musíš ho otvoriť cez `http://localhost:81/...`. PHP sa vykonáva len na serveri.

### `404 Not Found` alebo `IIS Web Core` chyba

Na porte 80 ti beží **IIS**, nie Apache. Vypni IIS alebo zmeň port Apache na 81.

### `Warning: include(backend/db_connect.php): Failed to open stream`

Súbor `backend/db_connect.php` neexistuje alebo je na zlom mieste. Skontroluj štruktúru priečinkov.

### `Access denied for user 'root'@'localhost'`

Zlé prihlasovacie údaje v `db_connect.php`. Predvolené pre XAMPP sú `root` a prázdne heslo.

### Tabuľka je prázdna

História sa naplní až po tom, čo použiješ niektorú z kalkulačiek (a tá musí mať kód, ktorý ukladá výsledok do DB).

---

## Cieľ projektu

Cieľom projektu je vytvoriť jednoduchú webovú aplikáciu, na ktorej si možno precvičiť:

- tvorbu webových stránok,
- prácu s JavaScriptom,
- komunikáciu frontend ↔ backend,
- prácu s PHP,
- pripojenie k MySQL databáze,
- ukladanie a zobrazovanie údajov z databázy.

---

## Možné vylepšenia

Do budúcnosti je možné pridať:

- prihlasovanie používateľov,
- samostatnú históriu pre každého používateľa,
- mazanie histórie,
- ďalšie typy kalkulačiek,
- responzívnejší dizajn pre mobilné zariadenia,
- validáciu vstupných údajov,
- tmavý režim,
- filtrovanie a vyhľadávanie v histórii.

---

## Autor

**Mária**

Osobné portfólio.
