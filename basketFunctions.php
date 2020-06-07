<?php

function addBookToBasket($name)
{
    if (empty($_SESSION['basket'][$name])) {
        $_SESSION['basket'][$name] = 1;
    } else {
        $_SESSION['basket'][$name]++;
    }
}

function bookQtyInBasket($name): int
{
    $name = str_replace(' ', '_', $name);
    foreach ($_SESSION['basket'] as $book => $qty) {
        if ($name === $book) {
            return ($qty);
        }
    }
    return (0);
}

function rmBookFromBasket($name)
{
    $name = str_replace(' ', '_', $name);
    if ($_SESSION['basket'][$name]) {
        $_SESSION['basket'][$name]--;
    }
}

function rmBooksFromBasket($name)
{
    $name = str_replace(' ', '_', $name);
    if ($_SESSION['basket'][$name]) {
        $_SESSION['basket'][$name] = 0;
    }
}

function basketToOrder($login)
{
    $orderFile = fopen(DATA_DIR . DS . ORDER_FILENAME, 'a+');
    fputcsv(
        $orderFile,
        array(rand(10000, 99999),
        $login,
        serialize($_SESSION['basket']))
    );
    fclose($orderFile);
    if (!empty($_SESSION['basket'])) {
        $_SESSION['basket'] = null;
    }
}

function getPrice($name, $qty): int
{
    $dbFile = fopen(DATA_DIR . DS . DB_FILENAME, 'r');
    if ($dbFile !== false) {
        while (($dbData = fgetcsv($dbFile)) !== false) {
            if ($name === $dbData[0]) {
                fclose($dbFile);
                return ($qty * $dbData[1]);
            }
        }
    }
    fclose($dbFile);
    return (0);
}
