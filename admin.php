<?php
session_start();

require_once 'config.php';

if (empty($_SESSION['login'])
    || $_SESSION['level'] === 'basic'
    || $_SESSION['level'] === 'guest'
) {
    die(header('location:index.php'));
}

if ($_POST['rmUser'] === 'Delete this account') {
    if (empty($_POST['userToDelete'])) {
        header('location:admin.php?rmUserFailed=true&reason=empty');
    }
    $rmUserStatus = rmUser($_POST['userToDelete']);
    if ($rmUserStatus === 0) {
        header('location:admin.php?rmUserFailed=true&reason=notexist');
    } else if ($rmUserStatus === 2) {
        header('location:admin.php?rmUserFailed=true&reason=rights');
    }
} else if ($_POST['addBook'] === 'Add this book') {
    if (empty($_POST['name'])
        || empty($_POST['category'])
        || empty($_POST['price'])
        || empty($_POST['url'])
    ) {
        die(header('location:admin.php?addBookFailed=true&reason=empty'));
    }
    if (!isBookExists($_POST['name'], $_POST['category'])) {
        addBook($_POST['name'], $_POST['price'], $_POST['category'], $_POST['url']);
    } else {
        die(header('location:admin.php?addBookFailed=true&reason=exist'));
    }
} else if ($_POST['rmBook'] === 'Delete this book') {
    if (empty($_POST['name']) || empty($_POST['category'])) {
        die(header('location:admin.php?rmBookFailed=true&reason=empty'));
    }
    if (isBookExists($_POST['name'], $_POST['category'])) {
        rmBook($_POST['name'], $_POST['category']);
    } else {
        die(header('location:admin.php?rmBookFailed=true&reason=notexist'));
    }
} else if ($_POST['addCategory'] === 'Add this category') {
    if (empty($_POST['category'])) {
        die(header('location:admin.php?addCategoryFailed=true&reason=empty'));
    }
    if (isCategoryExists($_POST['category'])) {
        die(header('location:admin.php?addCategoryFailed=true&reason=exist'));
    }
} else if ($_POST['rmCategory'] === 'Delete this category') {
    if (empty($_POST['category'])) {
        die(header('location:admin.php?rmCategoryFailed=true&reason=empty'));
    }
    if (isCategoryExists($_POST['category'])) {
        die(header('location:admin.php?rmCategoryFailed=true&reason=notexist'));
    }
} else if ($_POST['modifPasswd'] === 'Edit the password') {
    if (empty($_POST['login'])
        || empty($_POST['newpw'])
        || empty($_SESSION['level'])
    ) {
        die(header('location:admin.php?modifPasswdFailed=true&reason=empty'));
    }
    $modifPasswdStatus = modifAdminPasswd($_POST['login'], $_POST['newpw'], $_SESSION['level']);
    if ($modifPasswdStatus === 0) {
        die(header('location:account.php?modifPasswdFailed=true&reason=notfound'));
    } else if ($modifPasswdStatus === 2) {
        die(header('location:admin.php?modifPasswdFailed=true&reason=rights'));
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Minishop - Administration</title>
        <meta name='Language' content='ru' />
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <link rel='stylesheet' type='text/css' href='./css/style.css'>
        <link rel='stylesheet' type='text/css' href='./css/admin.css'>
        <style>
            #container, #container1, #container2, #container3, #container3 {margin-top: 25px; width: 100%;}
            #container form {width: 565px!important; margin: 0 auto!important; display: block; }
            #container1 form {width: 590px!important; margin: 0 auto 30px!important; display: block; }
            #container2 form {width: 598px!important; margin: 0 auto 35px!important; display: block; }
            #container3 form {width: 620px!important; margin: 0 auto 35px!important; display: block; }
            #container4 form {width: 620px!important; margin: 0 auto 30px!important; display: block; }
            #container5 form {width: 590px!important; margin: 0 auto 30px!important; display: block; }
            #container { padding-left: 10px; }
            #container2 { margin-left: -10px; }
            #container4 { display: flex; }
            #container5 { height: 185px; margin-left: -20px; }
            #container1 { height: 210px; margin-left: -20px; }
            .elem input { width: 400px!important; }
            #container4 .elem { float: right; }
            #container4 .elem1 { float: right; }
            #container5 .elem { float: right; }
            #container1 .elem { float: right; }
            #container4 {margin-left: -50px;}
            .checkbox-css { width: 20px!important; margin-left: 15px!important; float: left; }
        </style>
    </head>
    <body>
        <header>
            <div id='top-bar'>
                <div id='top-bar-content'>
<?php
echo "<div id='login-element' style='padding-top: 15px; width: 365px;'>";
echo "<a id='admin' href='./admin.php' title='Administration' style='background-color: #a8a8a8;'>Administration</a><a id='orders' href='./orders.php' title='Orders'>Orders</a>";
echo "<a id='my-account' href='./account.php' title='Account' >My account</a><a id='logout' href='./logout.php' title='Logout'>Logout</a>";
echo "</div>";
?>
                </div>
            </div>
            <div id='nav-bar'>
                <div id='logo'>
                    <a href='./index.php' alt='Homepage' title='Home'>
                        <img src='./assets/images/logo.png' />
                    </a>
                </div>
                <div id='nav-menu'>
                    <nav>
                        <ul>
                            <li style='margin-left: 20px;'><a href='./index.php'>Home</a></li>
<?php
$categoryFile = fopen(DATA_DIR . DS . CATEGORY_FILENAME, 'c+');
if ($categoryFile !== false) {
    $categories = explode(
        PHP_EOL,
        fread($categoryFile, filesize(DATA_DIR . DS . CATEGORY_FILENAME))
    );
}
$categories = array_filter($categories);
foreach ($categories as $category) {
    if ($category !== 'Home') {
        echo "<li><a href='./index.php?cat=true&name=' . $elem . ''>' . $elem . '</a></li>";
    }
}
fclose($categoryFile);
?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div id='content'>
            <div id='left-panel'>
                <h3 style='margin-bottom: 30px;'>Active categories :</h3>
<?php
$categoryFile = fopen(DATA_DIR . DS . CATEGORY_FILENAME, 'r');
if ($categoryFile !== false) {
    $categories = explode(
        PHP_EOL,
        fread($categoryFile, filesize(DATA_DIR . DS . CATEGORY_FILENAME))
    );
}
$categories = array_filter($categories);
foreach ($categories as $category) {
    echo "<div class='infos'><p>' . $category . '</p></div>";
}
fclose($categoryFile);
?>
                <div class='delimiter2'></div>
                <h3 style='margin-bottom: 30px;'>list of users :</h3>
<?php
$userFile = fopen(DATA_DIR . DS . USER_FILENAME, 'r');
if ($userFile !== false) {
    while (($userData = fgetcsv($userFile)) !== false) {
        echo "<div class='infos'><p>' . $userData[0] . '</p></div>";
    }
}
fclose($userFile);
?>
                <div class='delimiter2'></div>
            </div>
            <div id='main-panel'>
                <h2>Administration</h2>
                <div class='delimiter'></div>
                <h4>Add a book</h4>
<?php
$reasons = array('exist' => 'Book already exists!');
if ($_GET['addBookFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
                <div id='container4'>
                    <form action='admin.php' method='post'>
                        <span class='elem'><label for='name'>Book name:</label>
                        <input type='name' name='id' /><br /></span>
                        <span class='elem'><label for='name'>Price:</label>
                        <input type='name' name='price' /><br /></span>
                        <span class='elem1' style='width: 558px;'><label for='name' style='float: left; margin-top: 7px;'>Categories:</label>
                        <div style='margin-left: 89px; margin-bottom: 15px'>
<?php
if (file_exists(DATA_DIR . DS . CATEGORY_FILENAME) === true) {
    $categories = explode(
        PHP_EOL,
        file_get_contents(DATA_DIR . DS . CATEGORY_FILENAME)
    );
    $categories = array_filter($categories);
    foreach ($categories as $category) {
        echo "<input type='checkbox' class='checkbox-css' name='category[]' value='.$category.' /><br />";
        echo "<p class='categories-checkbox'>'.$category.'</p>";
    }
}
?></div></span>
                        <span class='elem'><label for='name'>URL Image:</label>
                        <input type='name' name='url' /><br /></span>
                        <input type='submit' name='addBook' value='Add this book' />
                    </form>
                </div>
                <h4>Delete a book</h4>
<?php
$reasons = array('notexist' => "Boook doesn't exist!", 'empty' => 'One or more fields was left empty.');
if ($_GET['rmBookFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
    <div id='container1'>
    <form action='admin.php' method='post'>
    <span class='elem'><label for='name'>Book name:</label>
    <input type='name' name='id' /><br /></span>
    <span class='elem'><label for='name'>Book category:</label>
    <input type='name' name='category' /><br /></span>
    <input type='submit' name='rmBook' value='Delete this book' />
    </form>
    </div>
    <div class='delimiter'></div>
    <h4>Add a category</h4>
<?php
$reasons = array('exist' => 'Category already exist!', 'empty' => 'One or more fields was left empty.');
if ($_GET['addCategoryFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
    <div id='container2'>
    <form action='admin.php' method='post'>
    <label for='name'>Category name:</label>
    <input type='name' name='id' />
    <input type='submit' name='addCategory' value='Add this category' />
    </form>
    </div>
    <h4>Delete a category</h4>
<?php
$reasons = array('notexist' => "Category doesn't exist!", 'empty' => 'One or more fields was left empty.');
if ($_GET['rmCategoryFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
                <div id='container3'>
                    <form action='admin.php' method='post'>
                        <label for='name'>Category name:</label>
                        <input type='name' name='id' />
                        <input type='submit' name='rmCategory' value='Delete this category' />
                    </form>
                </div>
                <div class='delimiter'></div>
                <h4>Delete An Account</h4>
<?php
$reasons = array('notexist' => "This User doesn't exist.",
    'rights' => "You don't have the rights to do that!",
    'empty' => "One or more fields was left empty.");
if ($_GET['rmUserFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
                <div id='container'>
                    <form action='admin.php' method='post'>
                        <label for='name'>login:</label>
                        <input type='name' name='userToDelete' />
                        <input type='submit' name='rmUser' value='Delete this account' />
                    </form>
                </div>
                <h4 style='margin-top: 35px;'>Change password of an Account</h4>
<?php
$reasons = array('notexist' => "This User doesn't exist.",
    'rights' => "You don't have the rights to do that!",
    'empty' => 'One or more fields was left empty.');
if ($_GET['modifPasswdFailed']) {
    echo "<div id='login-failed'><center><p>";
    echo $reasons[$_GET['reason']];
    echo "</p></center></div>";
}
?>
                <div id='container5'>
                    <form action='admin.php' method='post'>
                        <span class='elem'><label for='name'>login:</label>
                        <input type='name' name='login' /><br /></span>
                        <span class='elem'><label for='name'>New Password:</label>
                        <input type='password' name='new_pw' /><br /></span>
                        <input type='submit' name='modifPasswd' value='Edit the password' />
                    </form>
                </div><br /><br />
            </div>
        </div>
        <footer>
            <p>&copy; blord, rjeraldi 2020</p>
        </footer>
    </body>
</html>
