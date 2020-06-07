<?php
    require_once './card.php'
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
                    <?php
                        $connect = mysqli_connect('localhost', 'root', '', 'cart');
                        $query = 'SELECT * FROM products ORDER by id ASC';
                        $result = mysqli_query($connect, $query);

                        if ($result):
                            if (mysqli_num_rows($result) > 0):
                                while($product = mysqli_fetch_assoc($result)): 
                                ?>
                                <li class="list-elem">
                                    <form action="index.php?action=add&id=<?php echo $product['id']; ?>" method="post">
                                        <figure>
                                            <img src="<?php echo $product['image'];?>" alt="">
                                            <figcaption>
                                                <p class="book-name">
                                                    <?php echo $product['name'];?>
                                                </p>
                                                <p class="book-cost">Price: <?php echo $product['price'];?>$</p>
                                                <div class="main-btn-wrap">
                                                    <input class="qua-input" type="text" name="quantity" value="1">
                                                </div>
                                                <input type="hidden" name="name" value="<?php echo $product['name'];?>" />
                                                <input type="hidden" name="price" value="<?php echo $product['price'];?>" />
                                                <div class="main-btn-wrap">
                                                    <input type="submit" name="add_to_cart" class="add-to-basket-btn" value="ADD TO BACKET">
                                                </div>
                                                <!-- <div class="main-btn-wrap">
                                                    <input type="submit" class="add-to-basket-btn" value="ADD TO BACKET">
                                                </div> -->
                                            </figcaption>
                                        </figure>
                                    </form>
                                </li>
                                <?php 
                                endwhile;
                            endif;
                        endif; ?>
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