# Projekt metryczki dla stron (JESZCZE W TRAKCIE FINALIZACJI)

### Wtyczka stworzona dla witryny bip.polsl.pl

### Instalacja

Pobierz ZIP, następnie w WordPress wybierz opcję **Wtyczki > Dodaj wtyczkę**, wybierz ZIP. 

Alternatywnie rozpakowany folder z wtyczką wrzuć w pliki serwera:  
*nazwa_wordpressa/wp-content/plugins*

**Technologie:** PHP, JavaScript

Wtyczka polega na stworzeniu odpowiedniej metryczki, dla każdego odnośnika spełniającego wprowadzone wymagania.

---

## Dokumentacja (JESZCZE SIĘ POZMIENIA)

### metryczki-dla-stron.php
Główny plik, dołączanie wymaganych technologii

Działanie na stronie - pobranie wszystkich danych z WordPressa dotyczących stworzenia i modyfikacji strony,
znalezienie elementu odpowiedzialnego za wyświetlenie liczby odwiedzin, pobranie wartości i zamiana elementu na tabelkę z tymi danymi.
