<?php

session_start();

require_once "config.php";

if (!file_exists("DATA_DIR")) {
    mkdir("DATA_DIR");
}

if (!file_exists("private/database.csv")) {
    addBook("Код: тайный язык информатики", "1510", array("Home", "Science", "Best", "New"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/37/20637/1.00x-thumb.png");
    addBook("Nudge. Архитектура выбора", "1100", array("Home", "Science", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/81/18481/2.00x-thumb.png");
    addBook("Удовольствие от x", "1360", array("Home", "Science", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/92/7392/2.00x-thumb.png");
    addBook("Притяжение сверхмарафона", "945", array("Home", "Health", "New"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/05/20205/2.00x-thumb.png");
    addBook("Еда и мозг", "985", array("Home", "Health", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/93/11693/1.00x-thumb.png");
    addBook("Китайское исследование", "1045", array("Home", "Health", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/73/10073/1.00x-thumb.png");
    addBook("Робким мечтам здесь не место", "1010", array("Home", "Interest", "New"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/33/23933/1.00x-thumb.png");
    addBook("Гении и аутсайдеры", "1035", array("Home", "Interest", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/06/3606/1.00x-thumb.png");
    addBook("Одураченные случайностью", "1035", array("Home", "Interest", "Best"), "https://www.mann-ivanov-ferber.ru/assets/images/covers/17/2917/1.00x-thumb.png");
}
if (!userExists("root")) {
    create_user("root", "root");
}
if (!userExists("guest")) {
    create_user("guest", "");
}
