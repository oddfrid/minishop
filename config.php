<?php

session_start();

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("DATA_DIR") ? null : define("DATA_DIR", __DIR__ . DS . "data");
defined("USER_FILENAME") ? null : define("USER_FILENAME", "passwd.csv");
defined("CATEGORY_FILENAME") ? null : define("CATEGORY_FILENAME", "category");

require_once "functions.php";
