# Projekt metryczki dla stron

### Wtyczka stworzona dla witryny bip.polsl.pl

**Technologie:** PHP, JavaScript, AJAX, jQuery

Wtyczka generuje odpowiednią metryczkę na dole każdej strony zawartej na witrynie, a dokładniej w elemencie o klasie mn-bip-elementor.
Każda metryczka jest w większości modyfikowalna, czyli w ustawieniach wtyczki da się ustawić jej wygląd i ustawić alternatywne klasy.

### Instalacja

Pobierz ZIP, następnie w WordPress wybierz opcję **Wtyczki > Dodaj wtyczkę**, wybierz ZIP. 

Alternatywnie rozpakowany folder z wtyczką wrzuć w pliki serwera:  
*nazwa_wordpressa/wp-content/plugins*

## Kolejno co w kodzie
- domyślne wartości css
- dodanie akcji wordpress
- zawarcie potrzebnych technologii
- strona ustawień:
  - pole i przycisk do wyglądu
  - pole na klasy
  - checkbox i pole na ewentualną zmianę lokalizacji metryczki
  - podgląd zmian w stylu na żywo
- główna funkcja
  - wczytywanie danych o stronie z bazy wordpress i znalezienie pozycji zawierającej pole z liczbą wizyt na stronę (.mn-mn)
  - usunięcie danych z .mn-mn
  - skrypt wykorzystujący jQuery do wstawienia tych danych do tabelki na końcu elementu domyślnie .mn-bip-elementor, lub innego wprowadzonego.
