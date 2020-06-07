<?php

require_once "./php/products.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minishop</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <section class="header-wrap">
            <section class="header-top">
                <div class="logo">
                    <img src="" alt="">
                </div>
                <h1>Minishop</h1>
                <div class="header__user-actions">
                    <div class="user-action user-login">
                        <a href="http://" class="action-link" target="_blank" rel="noopener noreferrer">Log in</a>
                    </div>
                    <div class="user-action user-signin">
                        <a href="http://" class="action-link" target="_blank" rel="noopener noreferrer">Sign up</a>
                    </div>
                    <div class="user-action user-basket">
                        <a href="http://" class="action-link" target="_blank" rel="noopener noreferrer">Cart</a>
                    </div>
                </div>
            </section>
            <section class="header-nav">
                <ul class="meni-list">
                    <li class="menu-list-elem">
                        <a href="" class="menu-link">BOOKS</a>
                    </li>
                    <li class="menu-list-elem">
                        <a href="" class="menu-link">BOOKS</a>
                    </li>
                    <li class="menu-list-elem">
                        <a href="" class="menu-link">BOOKS</a>
                    </li>
                    <li class="menu-list-elem">
                        <a href="" class="menu-link">BOOKS</a>
                    </li>
                    <li class="menu-list-elem">
                        <a href="" class="menu-link">BOOKS</a>
                    </li>
                </ul>
            </section>
        </section>
    </header>
    <main>
        <section class="main-wrap">
            <article class="all">
                <h2>ALL BOOKS</h2>
                <div class="all-content">
                    <ul class="list">
                        <?php foreach($products as $product):?>
                        <li class="list-elem">
                            <figure>
                                <img src="<?php echo $product['img-src'];?>" alt="">
                                <figcaption>
                                    <p class="book-name">
                                        <?php echo $product['name'];?>
                                    </p>
                                    <p class="book-cost">Cost: <?php echo $product['cost'];?>$</p>
                                    <div class="main-btn-wrap">
                                        <button href="http://" class="add-to-basket-btn">ADD TO BACKET</button>
                                    </div>
                                </figcaption>
                            </figure>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </article>
        </section>
    </main>
    <footer>
        <section class="footer-wrap">
            <div></div>
        </section>
    </footer>
</body>
</html>