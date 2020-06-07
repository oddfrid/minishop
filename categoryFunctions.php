<?php

function addCategory($newCategory)
{
    if (file_exists(DATA_DIR . DS . CATEGORY_FILENAME) === true) {
        $categories = explode(
            PHP_EOL,
            file_get_contents(DATA_DIR . DS . CATEGORY_FILENAME)
        );
        foreach ($categories as $category) {
            if ($category === $newCategory) {
                return;
            }
        }
    } else {
        file_put_contents(DATA_DIR . DS . CATEGORY_FILENAME, '');
    }
    file_put_contents(
        DATA_DIR . DS . CATEGORY_FILENAME,
        $newCategory . PHP_EOL,
        FILE_APPEND
    );
}

function isCategoryExists($category): bool
{
    if (file_exists(DATA_DIR . DS . CATEGORY_FILENAME) === true) {
        $categories = explode(
            PHP_EOL,
            file_get_contents(DATA_DIR . DS . CATEGORY_FILENAME)
        );
        foreach ($categories as $categoryExisted) {
            if ($categoryExisted === $category) {
                return true;
            }
        }
    }
    return false;
}

function rmCategory($category)
{
    $categoryFile = fopen(DATA_DIR . DS . CATEGORY_FILENAME, 'a+');
    if ($categoryFile !== false) {
        $categories = explode(
            PHP_EOL,
            fread($categoryFile, filesize(DATA_DIR . DS . CATEGORY_FILENAME))
        );
    }
    $newCategories = [];
    foreach ($categories as $oldCategory) {
        if ($oldCategory !== $category) {
            $newCategories[] = $oldCategory;
        }
    }
    ftruncate($categoryFile, 0);
    file_put_contents(
        DATA_DIR . DS . CATEGORY_FILENAME,
        implode(PHP_EOL, $newCategories) . PHP_EOL
    );
    fclose($categoryFile);
}
