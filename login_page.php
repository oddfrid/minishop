<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php
        require_once './header.php'
    ?>
    <main class="form-wrap-out">
        <form action="" method="get">
            <h2>Log in</h2>
            <div class="form-wrap-in">
                <div class="form-elem-cell">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email" required>                    
                </div>
                <div class="form-elem-cell">
                    <label for="passwd">Password</label>
                    <input type="password" name="passwd" placeholder="" minlength="6" required>                    
                </div> 
                <div class="form-elem-cell btn">
                    <button type="submit" class="form-btn" value="Continue">Continue</button>                         
                </div>
            </div>
        </form>
    </main>
    <?php
        require_once './footer.php'
    ?>
</body>
</html>