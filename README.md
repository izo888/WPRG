MovieShelf - projekt PHP

Autor: Oskar Bielecki

Repozytorium GitHub:
https://github.com/izo888/WPRG

Opis projektu:
MovieShelf to aplikacja webowa napisana w PHP, pozwalająca na zarządzanie listą filmów.
Aplikacja umożliwia rejestrację i logowanie użytkowników, dodawanie filmów, edycję, usuwanie,
wyświetlanie szczegółów oraz przypisywanie filmów do kategorii.

Wykorzystane technologie:
- PHP
- MySQL
- PDO
- HTML
- CSS
- XAMPP
- phpMyAdmin

Główne funkcje:
- rejestracja użytkownika
- logowanie i wylogowanie
- zabezpieczenie stron przez sesję
- CRUD filmów
- CRUD kategorii
- relacja movies -> categories
- upload plakatu filmu
- usuwanie plakatu po usunięciu filmu
- walidacja formularzy po stronie serwera
- komunikaty jednorazowe przez sesję
- zapamiętanie motywu jasny/ciemny przez cookies
- panel podsumowania
- wyszukiwarka filmów

Baza danych:
Nazwa bazy: movie_project

Tabele:
1. users
- id
- username
- email
- password
- created_at

2. categories
- id
- name

3. movies
- id
- title
- director
- release_year
- description
- category_id
- poster
- created_at

Instrukcja uruchomienia:
1. Uruchomić Apache i MySQL w XAMPP.
2. Skopiować folder movie_project do C:\xampp\htdocs.
3. Utworzyć bazę danych movie_project w phpMyAdmin.
4. Zaimportować plik SQL z bazą danych.
5. Sprawdzić dane połączenia w config/database.php.
6. Wejść w przeglądarce na adres:
   http://localhost/movie_project
7. Zarejestrować konto lub zalogować się na konto testowe.

Dane testowe:
email: admin@test.pl
hasło: 123456

Uwagi:
Hasła użytkowników są przechowywane w bazie w postaci zahashowanej przy użyciu password_hash().
Logowanie jest sprawdzane przez password_verify().

Struktura projektu:
- config/database.php — połączenie z bazą danych
- init.php — sesja, załadowanie klas i funkcje pomocnicze
- classes/Movie.php — operacje na filmach
- classes/Category.php — operacje na kategoriach
- classes/User.php — operacje na użytkownikach
- auth/ — logowanie, rejestracja i wylogowanie
- movies/ — CRUD filmów
- categories/ — CRUD kategorii
- public/style.css — wygląd aplikacji
- uploads/posters/ — przesłane plakaty filmów
