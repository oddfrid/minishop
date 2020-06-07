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
    <?php
        require_once './header.php'
    ?>
    <main>
        <section class="main-wrap">
            <article class="all">
                <h2>CLASSIC BOOKS</h2>
                <div class="all-content">
                    <ul class="list">
                    <?php
                        $connect = mysqli_connect('localhost', 'root', '', 'cart');
                        $query = 'SELECT * FROM products ORDER by id ASC';
                        $result = mysqli_query($connect, $query);
                        if ($result):
                            if (mysqli_num_rows($result) > 0):
                                while($product = mysqli_fetch_assoc($result)): 
                                    if ($product['type'] == 'classic'):
                                ?>
                                <li class="list-elem">
                                    <form action="classic.php?action=add&id=<?php echo $product['id']; ?>" method="post">
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
                                                <input type="hidden" name="type" value="<?php echo $product['type'];?>" />
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
                                endif;
                                endwhile;
                            endif;
                        endif; ?>
                    </ul>
                </div>
            </article>
        </section>
    </main>
    <?php
        require_once './footer.php'
    ?>
</body>
</html>