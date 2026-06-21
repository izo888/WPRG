MovieShelf - projekt PHP

Autor: Oskar Bielecki

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

Uwagi:
Hasła użytkowników są przechowywane w bazie w postaci zahashowanej przy użyciu password_hash().
Logowanie jest sprawdzane przez password_verify().