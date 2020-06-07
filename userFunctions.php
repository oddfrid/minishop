<?php

function isUserExists($login): bool
{
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
    if ($userFile !== false) {
        while (($userData = fgetcsv($userFile)) !== false) {
            if ($userData[0] === $login) {
                fclose($userFile);
                return true;
            }
        }
    }
    fclose($userFile);
    return false;
}

function createUser($login, $passwd, $level)
{
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'a+');
    if ($userFile !== false) {
        $userData = array($login, hash('sha256', $passwd), $level);
        fputcsv($userFile, $userData);
    }
    fclose($userFile);
}

function rmMyAccount()
{
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
    $tmpFile = fopen(DATA_DIR . DS . TMP_FILENAME, 'a+');
    if ($userFile !== false) {
        while (($userData = fgetcsv($userFile)) !== false) {
            if ($userData[0] !== $_SESSION['loggued_on_user']) {
                fputcsv($tmpFile, $userData);
            }
        }
    }
    fclose($tmpFile);
    fclose($userFile);
    rename(DATA_DIR . DS . TMP_FILENAME, DATA_DIR . DS . USER_FILENAME);
}

function rmUser($login): int
{
    $return_v = 0;
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
    $tmpFile = fopen(DATA_DIR . DS . TMP_FILENAME, 'a+');
    if ($userFile !== false) {
        while (($userData = fgetcsv($userFile)) !== false) {
            if ($userData[0] !== $login) {
                fputcsv($tmpFile, $userData);
            } else {
                if ($userData[2] === $_SESSION['level']
                    || ($_SESSION['level'] === 'admin' && $userData[2] === 'root')
                ) {
                    return (2);
                }
                $return_v = 1;
            }
        }
    }
    fclose($tmpFile);
    fclose($userFile);
    rename(DATA_DIR . DS . TMP_FILENAME, DATA_DIR . DS . USER_FILENAME);
    return ($return_v);
}

function modifAdminPasswd($login, $newpw, $adminLevel): int
{
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
    if ($userFile !== false) {
        while (($userData = fgetcsv($userFile)) !== false) {
            if ($userData[0] === $login) {
                if ($adminLevel === 'admin') {
                    if ($userData[2] === 'admin' || $userData[2] === 'root')
                        return (2);
                } else if ($adminLevel === 'root') {
                    if ($userData[2] === 'root') {
                        return (2);
                    }
                }
                fclose($userFile);
                rmUser($login);
                createUser($login, $newpw, $userData[2]);
                return (1);
            }
        }
    }
    fclose($userFile);
    return (0);
}

function modifPasswd($login, $oldpw, $newpw): int
{
    $userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
    if ($userFile !== false) {
        while (($userData = fgetcsv($userFile)) !== false) {
            if ($userData[0] === $login) {
                if ($userData[1] !== hash('sha256', $oldpw)) {
                    return (1);
                }
                fclose($userFile);
                rmMyAccount();
                createUser($login, $newpw, $userData[2]);
                return (0);
            }
        }
    }
    fclose($userFile);
}
