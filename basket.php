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
            <h2>Order details</h2>
            <table>
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if (!empty($_SESSION['shopping_cart'])):
                        $total = 0;
                        foreach($_SESSION['shopping_cart'] as $key=>$product):
                    ?>
                    <tr>
                        <td width="40%"><?php echo $product['name']; ?></td>
                        <td width="10%" class="table-center"><?php echo $product['quantity']; ?></td>
                        <td width="10%" class="table-center"><?php echo $product['price']; ?>$</td>
                        <td width="20%" class="table-center"><?php echo number_format($product['quantity'] * $product['price'], 2); ?>$</td>
                        <td width="20%" class="table-center">
                            <a href="basket.php?action=delete&id=<?php echo $product['id'];?>">
                                <button class="remove-btn">Remove</button>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <?php 
                            $total = $total + ($product['quantity'] * $product['price']);
                        endforeach;
                    ?>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="total">Total</td>
                            <td colspan="1"></td>
                            <td colspan="1" class="total price"><?php echo number_format($total, 2); ?>$</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="checkout-btn-wrap">
                                <?php 
                                    if (isset($_SESSION['shopping_cart'])) :
                                    if (isset($_SESSION['shopping_cart']) > 0) :
                                ?>
                                    <a href="#" class="checkout" >Checkout</a>
                                <?php endif; endif; ?>
                            </td>
                        </tr>
                        <?php
                        endif;
                        ?>
                    </tfoot>
                </table>
        </section>
    </main>
    <?php
        require_once './footer.php'
    ?>
</body>
</html>