# 🧮 Portfolio kalkulačiek

Webová aplikácia vytvorená ako projekt na precvičenie práce s **HTML, CSS, JavaScriptom, PHP a MySQL**.

Aplikácia obsahuje viacero kalkulačiek, ktoré umožňujú používateľovi vykonávať rôzne výpočty. Výsledok sa zobrazí okamžite pomocou JavaScriptu a vybrané výpočty sa zároveň ukladajú do databázy.

## ✨ Funkcie

Projekt obsahuje tieto kalkulačky:

* ➕ **Základná kalkulačka** – sčítanie, odčítanie a ďalšie základné matematické operácie
* ⚖️ **BMI kalkulačka** – výpočet indexu telesnej hmotnosti
* 💧 **Kalkulačka príjmu vody** – odporúčaný denný príjem vody
* 📏 **Prevod jednotiek** – prevod medzi rôznymi jednotkami

### História výpočtov

Výsledky výpočtov sa odosielajú pomocou JavaScriptu na PHP backend, ktorý ich uloží do MySQL databázy.

Na hlavnej stránke sa následne zobrazujú posledné výpočty.

## 🛠️ Použité technológie

* **HTML** – štruktúra webových stránok
* **CSS** – vzhľad a dizajn aplikácie
* **JavaScript** – výpočty a komunikácia so serverom bez obnovovania stránky
* **PHP** – backend a ukladanie údajov
* **MySQL** – databáza pre históriu výpočtov
* **AJAX / Fetch API** – odosielanie údajov medzi JavaScriptom a PHP

## 📁 Štruktúra projektu

```text
pouzivatelske-menu/
│
├── index.php
├── style.css
├── script.js
│
├── kalkulacky/
│   ├── basic.php
│   ├── bmi.php
│   ├── voda.php
│   └── jednotky.php
│
└── backend/
    ├── db_connect.php
    └── save_history.php
```

## 🚀 Spustenie projektu

Na spustenie projektu je potrebné mať lokálny server, napríklad **XAMPP**.

### 1. Nainštalovanie XAMPP

Nainštalujte si XAMPP a spustite:

* Apache
* MySQL

### 2. Umiestnenie projektu

Celý priečinok projektu vložte do:

```text
C:\xampp\htdocs\
```

Napríklad:

```text
C:\xampp\htdocs\pouzivatelske-menu\
```

### 3. Vytvorenie databázy

Otvorte phpMyAdmin a vytvorte databázu, napríklad:

```text
kalkulacky
```

Následne vytvorte tabuľku:

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

V súbore:

```text
backend/db_connect.php
```

nastavte údaje potrebné na pripojenie k MySQL databáze.

Príklad:

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

### 5. Spustenie aplikácie

Po zapnutí Apache a MySQL otvorte v prehliadači:

```text
http://localhost/pouzivatelske-menu/
```

## 🔄 Ako aplikácia funguje

Proces výpočtu prebieha nasledovne:

1. Používateľ zadá údaje do formulára.
2. Klikne na tlačidlo pre výpočet.
3. JavaScript spracuje zadané hodnoty.
4. Výsledok sa okamžite zobrazí na stránke.
5. JavaScript odošle údaje pomocou `fetch()` na PHP backend.
6. PHP prijme údaje a uloží ich do MySQL databázy.
7. História výpočtov sa môže zobraziť na hlavnej stránke.

Vďaka JavaScriptu nie je pri samotnom výpočte potrebné obnovovať celú stránku.

## 🎯 Cieľ projektu

Cieľom projektu je vytvoriť jednoduchú webovú aplikáciu, na ktorej si môžem precvičiť:

* tvorbu webových stránok,
* prácu s JavaScriptom,
* komunikáciu frontend ↔ backend,
* prácu s PHP,
* pripojenie k MySQL databáze,
* ukladanie a zobrazovanie údajov z databázy.

## 🔮 Možné vylepšenia

Do budúcnosti je možné pridať:

* prihlasovanie používateľov,
* samostatnú históriu pre každého používateľa,
* mazanie histórie,
* ďalšie typy kalkulačiek,
* responzívnejší dizajn pre mobilné zariadenia,
* validáciu vstupných údajov,
* tmavý režim,
* filtrovanie a vyhľadávanie v histórii.

## 👩‍💻 Autor

**[Tvoje meno]**

Školský projekt / osobné portfólio.

