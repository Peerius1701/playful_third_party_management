# Bekannte Fehler
#### *Die Fehler sind unterteilt nach den jeweiligen Funktionalitäts-Kategorien*
###### Unbehobene Fehler sind als nicht abgehakte Checkbox markiert. Behobene Fehler sind als abgehakte Checkbox markiert

### Homepage
-[X] "Get Started" Button hat keine Funktion

### Mitarbeiter
-[X] Einfügen eines Tooltips für Beschäftigungsumfang

-[X] Falls Kürzel nicht eindeutig ist, wird es nicht als falsche Eingabe markieren -> Speichern/Editieren

### Management
-[X] Fehler bei der Eingabe, auch bei sinnvollen Daten wurden die Werte nicht gespeichert

-[X] Falls Kürzel nicht eindeutig ist, wird es nicht als falsche Eingabe markieren -> Speichern/Editieren

### Projekt
-[X] Button "Eigene Reise anzeigen" anstelle von Projekten

-[X] Unknown column "year" Fehler, bei show_single Ansicht

-[X] Unknown column "year" Fehler, beim Erstellen eines Projektes -> Daten werden witzigerweise trotzdem in die Datenbank übernommen

-[X] Unknown column "year" Fehler, beim Bearbeiten eines Projektes -> Daten werden witzigerweise trotzdem in die Datenbank übernommen

-[X] In der show_all Ansicht wird bei der Ansicht aller Projekte das Förderkennzeichen statt der Kostenstelle angezeigt. Bei dem Wechsel zu "Eigene Projekte" wird Kostenstelle angezeigt -> Nachfrage erforderlich, was gewünscht ist!

### Invest
-[X] Projektkontonummer nicht in Tabelle angezeigt, lediglich der Spaltenkopf

### Studentische Hilfskraft
-[X] Bei Projekt. ist in den Zeileneinträgen "TODO" 
-[ ] Aufteilung auf Jahre unklar

-[X] Die View "Eigene Hilfskräfte anzeigen" funktioniert nicht ordnungsgemäß. Eigene Einträge werden in der "Alle Anzeigen"-Ansicht doppelt aufgelistet und bei der eigenen Ansicht gar nicht mehr

### Lehrleistung
-[X] Kein Auswahllisten-Dialog zum Wählen des Kürzels eines:r Mitarbeiter:in, auch wenn Einträge von Kürzeln ohne Eintrag in der Datenbank nicht übernommen werden

### Abschlussarbeit
-[X] Es ist möglich, für Betreuungsperson und Co-Betreuungsperson die gleiche Person auszuwählen

-[X] Evtl. Titel-Feld vergrößern? Siehe Publikation

### Profil - Ansicht der personenbezogenen Daten
-[X] Personalnummer wurde weder angezeigt, noch ließ sich ein Eintrag dafür speichern (in der Datenbank wurde NULL gespeichert), getestet mit sgo als User

### Gesamtfinanzierungsplan
-[ ] Bisher keine Sicherheitsabfragen und Summenchecks vorhanden

### Reise
-[ ] Datums-Checks
