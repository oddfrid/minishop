<?php

function addBook($name, $price, $category, $url)
{
    $bookCategoryExisted = 0;
    if (file_exists(DATA_DIR . DS . CATEGORY_FILENAME) === true) {
        $categories = explode(PHP_EOL, file_get_contents(DATA_DIR . DS . CATEGORY_FILENAME));
        foreach ($categories as $categoryExisted) {
            foreach ($category as $bookCategory) {
                if ($bookCategory === $categoryExisted) {
                    $bookCategoryExisted++;
                }
            }
        }
    } else {
        file_put_contents(DATA_DIR . DS . CATEGORY_FILENAME, '');
    }
    if ($bookCategoryExisted === 0) {
        file_put_contents(
            DATA_DIR . DS . CATEGORY_FILENAME,
            implode(PHP_EOL, $category) . PHP_EOL,
            FILE_APPEND
        );
    }
    $dbFile = fopen(DATA_DIR . DS . DB_FILENAME, 'a+');
    if ($dbFile !== false) {
        fputcsv($dbFile, array($name, $price, serialize($category), $url));
    }
    fclose($dbFile);
}

function isBookExists($name, $category): bool
{
    $dbFile = fopen(DATA_DIR . DS . DB_FILENAME, 'r');
    if ($dbFile !== false) {
        while (($dbData = fgetcsv($dbFile)) !== false) {
            if ($dbData[0] === $name && $dbData[2] === $category) {
                fclose($dbFile);
                return true;
            }
        }
    }
    fclose($dbFile);
    return false;
}

function rmBook($name)
{
    $dbFile = fopen(DATA_DIR . DS . DB_FILENAME, 'r');
    $tmpFile = fopen(DATA_DIR . DS . TMP_FILENAME, 'a+');
    if ($dbFile !== false) {
        while (($dbData = fgetcsv($dbFile)) !== false) {
            if ($dbData[0] !== $name) {
                fputcsv($tmpFile, $dbData);
            }
        }
    }
    fclose($tmpFile);
    fclose($dbFile);
    rename(DATA_DIR . DS . TMP_FILENAME, DATA_DIR . DS . DB_FILENAME);
}
