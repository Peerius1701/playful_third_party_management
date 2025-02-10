# playful_third_party_management

### Programmierumgebung und Ausführungsumgebung
CodeIgniter 4 : wird bei Implementation benutzt  
MariaDB : DatenBank Unterstützung  
Apache: einen lokalen Sever erzeugen und das Projekt lokal ausführen

### CodeIgniter 4 Setup (Lokal)
Wir benötigen für den Setup unseres Projektes PHP und Composer.
Sofern diese Installiert sind, das Git-Repository auf PC herunterladen. Im heruntergeladenen Ordner nun das Terminal öffnen und  
`composer create-project codeigniter4/appstarter` eingeben.
Es wird das CodeIgniter 4 Framework heruntergeladen und im Ordner appstarter gespeichert.

Benenne die Datei `env` im Ordner appstarter zu `.env` um.
Nun innerhalb der `.env` Datei in Zeile 17 `# CI_ENVIRONMENT = production` ändern zu `CI_ENVIRONMENT = development` (auch # entfernen).

Navigiere im Terminal zum appstarter Ordner und führe `php spark serve` aus um den lokalen Server zu starten.
Im Browser nun `http://localhost:9012` als URL angeben um auf den Server zu gelangen.

Um den Port vom Server zu ändern, navigiere zur Datei Serve.php in `appstarter/vendor/codeigniter4/framework/system/Commands/Server`. Hier in Zeile 94 `$port = (int) (CLI::getOption('port') ?? 8080) + $this->portOffset;` ändern zu `$port = (int) (CLI::getOption('port') ?? 9012) + $this->portOffset;`. Somit startet der lokale Server immer mit `http://localhost:9012`. Falls nur temporär über Port 9012 der lokale Server gestartet werden soll (oder andere Server gleichzeitig laufen sollen), kann man auch `php spark serve --port 9012` ausführen.

Der Server `http://130.83.245.99:9012/` startet auf Port 9012, weswegen wir auch lokal auf Port 9012 arbeiten wollen, um so Fehler im Code zu vermeiden.

Um den Port vom Server zu ändern, navigiere zur Datei Serve.php in appstarter/vendor/codeigniter4/framework/system/Commands/Server. 
Hier in Zeile 94 $port = (int) (CLI::getOption('port') ?? 8080) + $this->portOffset; ändern zu $port = (int) (CLI::getOption('port') ?? 9012) + $this->portOffset;. 
Somit startet der lokale Server immer mit `http://localhost:9012`. 
Falls nur temporär über Port 9012 der lokale Server gestartet werden soll (oder andere Server gleichzeitig laufen sollen), kann man auch php spark serve --port 9012 ausführen.

Über `appstarter/app/Views`, `appstarter/app/Models` und `appstarter/app/Controllers` kann der lokale Server angepasst werden.

### Verbindung zwischen CodeIgnter 4 und MariaDB
In Datei `.env` sollen Zeile 42 bis Zeile 48 verändert werden. '#' muss entfernt werden und nach '=' sollen Datei von MariaDB eingegeben werden.
Beispiel auf Server:  

    database.default.hostname = localhost (The hostname of your database server. Often this is 'localhost'.)  
    database.default.database = bp23 (The name of the database you want to connect to.)  
    database.default.username = bp23 (The username used to connect to the database.)  
    database.default.password = RHfamLg8 (The password used to connect to the database.)  
    database.default.DBDriver = MySQLi (Database type. The case must match the driver name.) 
    database.default.DBPrefix = (An optional table prefix which will added to the table name when running Query Builder queries. This permits multiple CodeIgniter installations to share one database.)  
    database.default.port = 3306 (The database port number. Default port is '3306'.)

`appstarter/app/Config/Database.php` soll auch verändert werden. Von Zeile 34 bis Zeile 50 in der Method 'public $default' sollen wir Datei eingeben.  
Beispiel auf Server: 

    'DSN'      => '', (The DSN connect string.)    
    'hostname' => 'localhost',  
    'username' => 'bp23',  
    'password' => 'RHfamLg8',  
    'database' => 'bp23',  
    'DBDriver' => 'MySQLi',  
    'DBPrefix' => '',  
    'pConnect' => false, (true/false (boolean) - Whether to use a persistent connection.)  
    'DBDebug'  => (ENVIRONMENT !== 'production'), (true/false (boolean) - Whether database errors should be displayed.)  
    'charset'  => 'utf8', (The character set used in communicating with the database.)  
    'DBCollat' => 'utf8_general_ci', (The character collation used in communicating with the database (MySQLi only))  
    'swapPre'  => '', (A default table prefix that should be swapped with DBPrefix. This is useful for distributed applications where you might run manually written queries, and need the prefix to still be customizable by the end user.)  
    'encrypt'  => false, (Whether or not to use an encrypted connection.)  
    'compress' => false, (Whether or not to use client compression (MySQLi only).)  
    'strictOn' => false, (true/false (boolean) - Whether to force “Strict Mode” connections, good for ensuring strict SQL while developing an application.)  
    'failover' => [],
    'port'     => 3306,  

### Unit Tests

##### PHP Unit installieren
Navigiere mit dem Command Terminal in den `Appstarter` Verzeichnis. Führe dann `composer require --dev phpunit/phpunit` aus.
##### Datenbank Konfiguration anpassen
Passe in `Database.php` (siehe _Verbindung zwischen CodeIgnter 4 und MariaDB_) das Array `$tests` mit den Details der Testdatenbank an (die Testdatenbank kann auch die Datenbank sein, die im restlichen Projekt verwendet wird).
##### PHP Unit-Tests schreiben / bearbeiten
Die Unit-Tests befinden sich unter `appstarter/tests/app`. Details zum Schreiben von PHP-Unit Tests können hier: https://phpunit.readthedocs.io/en/9.5/writing-tests-for-phpunit.html oder hier: https://codeigniter.com/user_guide/testing/index.html gefunden werden.
Eine neue Klasse mit neuen Tests muss nach dem Schema `*Test.php` benannt sein (bzw. der Klassenname entsprechend `*Test`) 
##### PHP Unit-Tests ausführen
navigiere mit dem Command Terminal in das `Appstarter` Verzeichnis und führe `vendor\bin\phpunit` _(unter Windows)_ bzw `vendor/bin/phpunit` _(unter Linux)_ aus.


### PHP Extensions
Suche in deiner PHP Installation nach der Datei php.ini und entferne die ';' vor:

`;extension=curl
;extension=intl
;extension=mbstring
;extension=mysqli
;extension=openssl
;extension=zip`

### Projekt auf den Server deployen
1) **Dokumente auf den Server hochladen**  
Das Projekt soll erst aus Github heruntergeladen und entpackt werden. (https://github.com/janosch670/playful_third_party_management.git)
Danach sollen alle entpackten Dateien auf den Server hochgeladen werden.
2) **Datenbank einrichten**  
Auf dem Server soll MariaDB benutzt werden. Mit `sudo mysql` treten wir in das Interface von MariaDB ein.  
Zuerst erzeugen wir eine neue Datenbank 'bp23' mit `create database bp23;`. Dann muss ein neues Konto dafür erzeugt werden. `create user 'username'@'localhost' identified by 'password';` Danach geben wir dem Konto alle Rechte von Datenbank `bp23` mit `grant all on bp23.* to 'username'@'localhost';` .  
Jetzt erzeugen wir eine neue Tabellen. Mit `use bp23;` treten wir in die erzeugte Datenbank ein. Dort geben wir alle Befehle ein, die in Projektdatei `changelog_new.sql` und `views_changelong_1.sql` im Verzeichnis `playful_third_party_management/appstarter/app/Database/SQL/` stehen.  
Initiale Daten müssen in die Tabellen eingefügt werden. Dafür stehen die Befehle in Datei `data_2.sql` aus `playful_third_party_management/appstarter/app/Database/SQL/`.  
Wenn die Datenbank bereit ist, verbinden wir unser Projekt mit der Datenbank. Dafür verändern wir die Datei `Database.php` aus `playful_third_party_management/appstarter/app/Config/`. 
```php
 public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'username', //username von erzeugtem Konto bei MariaDB
        'password' => 'password', //password von erzeugtem Konto bei MariaDB
        'database' => 'bp23',   //Datenbank, die wir benutzen. Hier ist bp23
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
```
3) **Server einrichten**  
Jetzt müssen wir den Server konfigurieren. Dafür verwenden wir Nginx. Im Verzeichnis `.../nginx/sites-enabled/` erzeugen wir eine neue Datei mit der Endung `.vhost`. z.B. `selbstverwaltung.vhost`. Danach fügen wir die folgenden Befehle ein.
```

server {
  listen 9012; 
  listen [::]:9012; #wir nehmen port 9012
  server_name  45.83.106.91; #IP addresse von Server. Hier benutzen wir Server seriousgames-portal.org
  root /home/selbstverwaltung/playful_third_party_management-main/appstarter/public; #Wurzelverzeichnis. Soll immer .../playful_third_party_management-main/appstarter/public sein
  index index.php index.html;
  charset utf-8;

  location / {
    try_files $uri $uri/ /index.php;
}
  
 location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.1-fpm.sock; #Hier muss die PHP Version höher als 7.4 sein
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       
        include fastcgi_params;
    }

  location ~ /\.ht {
    deny  all;
  }

}

```
Achtung, das PHP muss Module `fpm` und `mysql` enthalten. Wenn die Module fehlen, kann man mit `sudo apt install php'php_version'-fpm` und `sudo apt install php'php_version'-mysql` installieren. (ersetze hier 'php_version' mit richtiger Zahl von der PHP Version)  

4) **Server aktivieren**  
Nach der Konfiguration prüfen wir zuerst mit Befehl `sudo nginx -t` auf Fehler. Wenn alles OK ist, führen wir `sudo service nginx reload` aus, um unseren Server zu aktivieren.  
Jetzt ist der Server bereit und kann mit `http://'IP-Address':9012/` erreicht werden, z.B. `http://45.83.106.91:9012/`.

### Rollenbasierte Zugriffskontrolle
Die Funktion ist durch Filter realisiert. Nach der Anmeldung werden User-Id und User-type in Session gespeichert, was nutzbar bei Prüfen des Benutzerzugriffs.
1) **Mein Filter erzeugen**  
Unter `appstarter/app/Filters` kann man Filters erzeugen.
Bei dieser Situation reicht ein Before-Filter schon. Der Besuch von unberechtigtem Benutzer wird blockiert und der Benutzer wird zur anderen Seite weiterleitet.
In method `before` sollen die Zugriff-Daten von aktuellem Benutzer abgeholt und geprüft.
```  
<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class MyFilter implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
   {
      // Do something here
   }
   
   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
      // Do something here
   }
}
```

2) **Filters konfigurieren**  
Nachdem wir unsere Filter erzeugt haben, müssen wir sie konfigurieren.  
Unter `appstarter/app/Config/Filters.php` kann man in `$aliases` array Filter-Regeln schreiben.  
Vor `=>` gibt man den Name der Regel und nach `=>` schreibt man Klasse von Filtern (kann eins oder mehr sein).
```
public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'noAuth'                      =>\App\Filters\NoAuth::class,
        'auth'                        =>\App\Filters\Auth::class,
        'permissionProfile'           =>[\App\Filters\NoAuth::class,\App\Filters\PermissionProfile::class,],
        'permissionEmployee'          =>[\App\Filters\NoAuth::class,\App\Filters\PermissionEmployee::class,],
]
```

3) **Regel anwenden**  
Am Ende müssen wir die Regeln anwenden.  
Unter `appstarter\app\Config\Routes.php` wenden wir die Regeln an. Man kann das einzeln aufstellen oder als Gruppe zusammen aufstellen.`['filter'=>'FilterRegelName']`
```
$routes->get('/logout', 'ProfileController::logout',['filter'=>'noAuth']);  
$routes->group('',['filter'=>'permissionPandoForm'],function ($routes) {
    $routes->get('/pando/form', 'PandoController::showPandoForm');
    $routes->get('/pando/edit_form', 'PandoController::editPandoForm');
    $routes->post('/pando/edit_form', 'PandoController::editPandoForm');
});
```

### ER-Modell
Die Struktur der Datenbank ist in ER-Modell.drawio festgehalten (erstellt mit https://www.diagrams.net/). 

### Access control
Die Rechte der Einzelnen Nutzer-/Rollen sind in user_permissions.xlsx festgehalten.

### Bekannte Probleme
In der Datei known_issues.md werden bekannte Probleme festgehalten und mit 'X' markiert, falls sie, ggf. in einem Sub-branch, behoben wurden.

### Anforderungen
Anforderugen von Dr. Göbel:

Ganz grob: es sollte ein Portal/dashboard geben mit den drei Bereichen "Benutzerverwaltung", "Formulare/Edit-Mode" und "Reports/Views" geben.

1) Benutzerverwaltung: es soll die drei Rollen "Leitung" (alle Rechte), "Mitarbeiter" (Rechte für Eingabe bestimmter Formulare und Einsicht bestimmter Reports, s. unten) und "Management" (nur lesend, manche Reports, s. unten) geben.

Alle Nutzer haben ein Login und Zugangscode.

1.1) Initial bekommt nur die Leitung einen Account (von euch, irgendwie mitgeteilt) und kann den Zugangscode dann selbst ändern, und die folgenden Daten eingeben/ändern:

    Login (Textfeld, 3 Buchstaben max. -> Kürzel der Person, bei mir "SG"), Zugangscode (...)
    Arbeitsgruppe / Fachgebiet / Funktionseinheit (Textfeld, bspw. AG Serious Games)
    Name, Vorname (2 Textfelder)
    Titel (Textfeld bspw. Dr.-Ing., Bachelor of Arts, ... wenn ihr eine Auswahlliste findet, umso besser)
    Personalnummer (Zahl)
    Beschäftigungsumfang (% Zahl)
    Eingruppierung / Stufe (Textfeld max. 4 Stellen; für Stufe Zahl, einstellig)
    entfristet: ja/nein
    Email-Adresse
    Telefon TUDa (16 - fünf Ziffern), mobil (Textfeld für Handynr.)
    Geburtsdatum (Datum)
    Vertragslaufzeit (Startdatum, Enddatum) und Feld "entfristet (ja/nein)
        bei Verlängerungen als neue Vertragslaufzeit für die Person eingeben
    h-index (Zahl, max. 3 Stellen)
    eingeworbene Drittmittel (EUR Wert)
    #Promotionen (Zahl, max. 3 Stellen)
    #Abschlussarbeiten (Zahl, max. 3 Stellen)

1.2) Die Leitung kann Mitarbeiter anlegen und ändern:

    Login (Textfeld 3 Buchstaben), ..(default Wert)
        WiMis können das dann ändern
    Name, Vorname (2 Textfelder)
    Titel (Textfeld bspw. Dr.-Ing., Bachelor of Arts, ... wenn ihr eine Auswahlliste findet, umso besser)
    Personalnummer (Zahl)
    Beschäftigungsumfang (% Zahl)
    Wimi: ja/nein
    ATM: ja/nein
    Eingruppierung / Stufe (Textfeld max. 4 Stellen; für Stufe Zahl, einstellig)
    entfristet: ja/nein
    Email-Adresse
    Telefon TUDa (16 - fünf Ziffern), mobil (Textfeld für Handynr.)
    Geburtsdatum (Datum)
    Vertragslaufzeit (Startdatum, Enddatum)
        bei Verlängerungen als neue Vertragslaufzeit für die Person eingeben
    h-index (Zahl, max. 3 Stellen)
    #Abschlussarbeiten (Zahl, max. 3 Stellen)

1.3) die Leitung kann Nutzer der Kategorie "Management" anlegen

    login, initiales ... (2 Textfelder)
    Name, Vorname
    Titel
    Funktionseinheit (Textfeld, max. 50 Zeichen)
    Email-Adresse
    Telefon TUDa (16 - fünf Ziffern), mobil (Textfeld für Handynr.)

1.4) Mitarbeiter können ihren Zugangscode ändern und Abschlussarbeiten und Publikationen anlegen, s. unten Bereich Formulare.

1.5) Management darf nur manche Reports einsehen, sonst nix.

2) "Formulare/Edit-Mode"

2.1) Formular "Publikationen"
.. dürfen Mitarbeiter und die Leitung anlegen/editieren:

    Titel (Textfeld, mehrzeilig, 3 default, notfalls zum Scrollen)
    Autoren (Textfeld)
    Erstautor (Kürzel und %-Angabe Beitrag), Zweitautor (Kürzel, %), Drittautor, ..
        dann checken ob in Summe 100% heraus kommt von Autoren
    Publikation/erschienen (Jahr)
    Konferenzname (Textfeld) und Impact Faktor (Textfeld, automatisch eingetragen)
    Journalname (Textfeld) und Impact Faktor (Textfeld, automatisch..)
    download (Textfeld mit URL), doi (Textfeld mit URL)

2.2) Formular "Abschlussarbeiten" ... darf nur die Leitung eintragen/editieren

    Name, Vorname (2 Textfelder)
    Matrikelnummer (Textfeld, 7 Stellen)
    FB (Zahl, 2 Stellen)
    Studiengang (Textfeld)
    Prüfungsordnung (Zahl, 4-stellig)
    extern (ja/nein) andere Hochschule (Textfeld)
    Vorgespräch (Datum)
    Titel der Arbeit (Textfeld)
    Betreuer (Kürzel vgl. login), Co-Betreuer (Kürzel), Betreuer extern (Textfeld)
    Start (Datum)
    Ende (Datum)
    Anmeldung (Datum), Lehrauftrag (Datum)
    Vortrag (Datum)
    Notenmeldung (Datum)
    Note (Zahl mit 1 Kommastelle)

2.3) Formular "Wissenschaftlicher Nachwuchs"

    Name, Vorname
    Thema Doktorarbeit / Habilitation
    Datum Promotion / Habilitation
    Jahr

2.4) Formular "Lehrleistungen"

    Modulnummer (Textfeld)
    Modultitel (Textfeld)
    Prüfer (default: Stefan Göbel)
    SWS (Zahl)
    Praktika (ja/nein)
    Semester (Textfeld mit Auswahlliste WiSe 2020/21, SoSe 2021, ....)
    Anzahl Prüfungen
    #Prüfungen Mitarbeiter (Kürzel)
    für alle Mitarbeiter, die im Semester mit betreuen

2.5) Formular "Studentische Hilfskräfte" .. darf nur die Leitung editieren

    Name, Vorname (2 Textfelder)
    Betreuung (Kürzel Mitarbeiter)
    Email
    Telefon/Handy (Textfeld)
    Geburtstag
    Vertragslaufzeit (Startdatum, End-Datum)
    Stunden pro Monat (Zahl)
    Stunden gesamt (für Vertragslaufzeit, Zahl)
    Ausgaben (für Vertragslaufzeit, EUR)
    Ausgaben Jahr 1 (Jahr), Jahr 2
        Verträge können jahresübergreifend sein, bspw. pro Semester
    Finanzierung (Auswahl Projektnamen, Auswahl Projektnummern)
    Aufgabe (Textfeld)
    Formulare an Sek (Datum)
    Anmerkung (Textfeld)

2.6) Formular "Invest" .. nur Leitung

    Rechnungsdatum (Datum)
    Jahr
    Posten (Textfeld)
    Kosten (EUR)
    Projekt (Projektname/Auswahlliste, Kontonummer/Auswahlliste)
    Auszahlung unbar (ja/nein), Vorlage (Personal Kürzel)
    eingereicht Verwaltung (Datum)
    Vorlage erhalten (Datum)

2.7) Formular "Reisen" .. nur Leitung

    Reise (Textfeld)
    Reisedatum (Datum), Reisezeitraum (Datum "von", Datum "bis")
    Person(en): Ein oder mehrere Kürzel von Mitarbeitern
    Dienstreiseantrag (Datum)
    Dienstreiseabrechnung eingereicht (Datum)
    Kosten (EUR)
    Projekt (Name und Kontonr.)
    Kostenerstattung (Datum)

2.8) Formular "Projekt" .. nur Leitung

    Kostenstelle (Textfeld), Projektkontonr. (Textfeld)
    Projektname/Akronym (Textfeld), Projekttitel (Textfeld)
    Förderkennzeichen (Textfeld)
    Laufzeit (von, Datum; bis, Datum)
    Projektkonto gültig bis (Datum)
    Fördersumme (EUR)
    Fördergeber (Textfeld), Projektträger (Textfeld)
    Ansprechpartner*in TUDa
    Zuwendungsbescheid
        Personal, E12-E15 (EUR)
        Personal, bis E11 (EUR)
        Studentische Hilfskräfte (EUR)
        Fremdaufträge (EUR)
        Invest > 800 EUR (EUR)
        Kleingeräte bis 800 EUR (EUR)
        Dienstreisen Inland (EUR)
        Dienstreisen Ausland (EUR)
        Summe Personalausgaben (EUR)
        Summe Sachausgaben (EUR)
        Gesamtausgaben (EUR)
        Projektpauschale (% Angabe und EUR)
        Gesamtfinanzierung (EUR)
    Gesamtfinanzierungsplan
        gleiche Kategorien wie bei Zuwendungsbescheid, für max. 4 Jahre (vgl. Laufzeit des Vorhabens)
        pro Jahr die ganzen Werte als "Plan Jahr.." eingeben
    Mittelabruf # (Zahl, durchlaufende Nr. für Projekt), Jahr (Zahl), eingereicht (Datum)
    (Erklärung: pro Projekt können mehrere Mittelabrufe getätigt werden)
        gleiche Kategorien wie bei Zuwendungsbescheid

2.9) Formular "Pando" .. nur Leitung

    Datum
    Jahr (Zahl)
    Faktor Drittmittel (Zahl mit 2 Nachkommastellen)
    Faktor Promotion (EUR)
    Faktor Lehrleistung (EUR)
    Faktor Abschlussarbeiten (EUR)
    Faktor Lehrevaluation (EUR)

2.10) Formular "Publikationen - Impact"
.. erweiterbare Liste, editierbar

    Konferenzname, Impact Faktor
    Journal, Impact Faktor

3 Reports/Views

3.1) Report "Konten" .. einsehbar nur für Leitung
.. alles generiert aus Projekten

    Kostenstelle (Textfeld)
    Projektname (Textfeld)
    Projektkontonr. (Textfeld)
    Laufzeit (von, Datum; bis, Datum)
    Projektkonto gültig bis (Datum)
    Fördersumme (EUR)
    Ansprechpartner*in TUDa (Textfeld)

3.2) Report "Projektübersicht" .. einsehbar für Leitung und Management
.. alles generiert aus Projekten

    Projektnamen
    Projektkonten
    Projektlaufzeiten
    Gesamtförderungen, bisher verbraucht, übrig (alles EUR)

3.3) Report "Einzelprojekt" .. einsehbar für Leitung und Management
.. hier erst ein Projekt auswählen, dann für dieses Vorhaben
.. generiert aus Projekten

    Projektname, Projektkonto, Projektlaufzeit
    und dann eine Tabelle mit Spalten für die ganzen Kategorien :
        Personal, E12-E15 (EUR)
        Personal, bis E11 (EUR)
        Studentische Hilfskräfte (EUR)
        Fremdaufträge (EUR)
        Invest > 800 EUR (EUR)
        Kleingeräte bis 800 EUR (EUR)
        Dienstreisen Inland (EUR)
        Dienstreisen Ausland (EUR)
        Summe Personalausgaben (EUR)
        Summe Sachausgaben (EUR)
        Gesamtausgaben (EUR)
        Projektpauschale (% Angabe und EUR)
        Gesamtfinanzierung (EUR)
    Als Spalten:
        Zuwendungsbescheid
        Plan Jahr (Jahreszahl)
        Mittelabrufe pro Jahr
        IST für Jahr (Summe aus Mittelabrufen in dem Jahr)
        Übertrag Rest (Zuwendungsbescheid - IST 1. jahr bzw. Rest 1.Jahr - Abrufe 2. Jahr, ..)
        Plan Jahr 2, Mittelabrufe Jahr 2, IST Jahr 2, Übertrag Rest (automatisch), ...
        Anmerkungen
            es können maximal 4 Mittelabrufe pro Jahr gestellt werden (üblich sind eher 3)
            in Summe können es max. 25 Spalten werden.
            (ist die schwierigste/aufwändigste Tabelle bzw. Report; zu überlegen wie das von der usability gemacht werden könnte)
            sollten wir uns mal im persönlichen Gespräch zusammen anschauen

3.4) Report "Pando" .. für Leitung und Mitarbeiter und Management

    Jahr
    Drittmittel (EUR)
        Formel: Summe über alle Projekte (jeweils Wert pro Jahr Drittmittel-Gesamtausgaben) * Faktor Drittmittel
    Wissenschaftlicher Nachwuchs (EUR)
        Formel: Summe von Promotionen/Habil in diesem Jahr * Faktor Promotion
    Lehrleistung (EUR), Summe aus..
        1 Zeile pro Lehrveranstaltung (iv: Vorlesung+Übung, Seminar, Praktikum und Projektpraktikum)
            Formel Praktikum und Projektpraktikum: Anzahl Prüfungen aus WiSe und SoSe davor * SWS * 2 * Faktor Lehrleistung
            Beispiel: für Pando Jahr 2022 zählen das WiSe 2020/21 und SoSe 2021
            Formel Seminar und Vorlesung: #Prüfungen aus WiSe und SoSe davor * SWS * 2 * Faktor Lehrleistung
        Abschlussarbeiten, FB 18
            Formel: #Abschlussarbeiten im Jahr zuvor (nur Personen aus FB18) * Faktor Abschlussarbeiten * Faktor Lehrleistung
        Abschlussarbeiten, sonst
            Formel: #Abschlussarbeiten im Jahr zuvor (Personen andere FB/Studiengänge) * Faktor Abschlussarbeiten / 2 * Faktor Lehrleistung
    Qualität der Lehre (EUR)
        Formel: kommt noch....
    FB Dienste (EUR)
        Formel: tbd bzw. per default "0" eintragen

3.5) Report "Pando Mitarbeiter" .. für Leitung und Mitarbeiter

    Jahre
        für jedes Jahr eine Spalte seit Eintrittsdatum
    Lehrleistung über die Jahre, nur für einen Mitarbeiter
        jeweils # Studierende betreut in LV und Abschlussarbeiten
    Publikationen über die Jahre, für MA (Kürzel)
        Anteile an Publikation und Impact Faktor für Konferenz/Journal beachten
    Drittmittel
        Formel: tbd Stefan

3.6) Report "Übersicht - Budget" .. für Leitung und Management

    Jahre .. 2021, 2022, 2023, .. jeweils
    Gehalt Leitung (EUR)
        muss Ltg. eingeben
    Gehälter Mitarbeiter (EUR)
        aus Projekten
    Löhne Studentische Hilfskräfte (EUR)
        aus Projekten und Studentische Hilfskräfte
    Sachkosten (EUR)
        aus Projekten und Formular Invest und Formular Reisen
    Gesamtausgaben .. Summe aus allem bis hierhin (EUR)
    Drittmittel - Personal
        s. Projekte
    Drittmittel - Sachkosten
        s. Projekte
    Projektpauschalen
        s. Projekte
    Pando
        s. Pando
    Jahresergebnis (EUR)
        Formel: Summe Einnahmen (Drittmittel... Pando) - Gesamtausgaben
    30% Pando (EUR)
        30% von Pando-Wert

[...]
Insbesondere zu den Projekten sollten wir sprechen; hier gibt es auch noch Spezialitäten für manche Projekttypen. Bin noch nicht im klaren ob das noch berücksichtigt werden soll oder dies nicht zu viel wird.

Gestaltungsspielraum ist bei der Usability von den ganzen Formularen und Reports sowie bei der Integration von Anreizsystemen speziell für Mitarbeiter, bspw. bestimmte Trophäen für #Punkte bei Publikationen oder betreuter Arbeiten/Lehrleistung, oder ... bitte/gerne hier Sachen überlegen.
