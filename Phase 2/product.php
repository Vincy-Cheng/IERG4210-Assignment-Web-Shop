<?php
require __DIR__ . '/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$cat_id = $_GET["categories"];
$prod_id = $_GET["pid"];
$prod_name = $_GET["name"];
$Cname = $_GET["Cname"];

$prod = ierg4210_prod_fetchOne($prod_id);

?>
<!DOCTYPE html>
<html>

<head>
    <title>IERG 4210 Assignment 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time();?>">
</head>

<body>
    <div class="topnav">
        <h1><a href="/" class="homepage">IERG4210 e shop</a></h1>
        <div class="path"><a href="/">Home</a> >
            <a href="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>"><?php echo htmlspecialchars($Cname) ?></a> >
            <a href="product.php?pid=<?php echo htmlspecialchars($prod_id) ?>&categories=<?php echo htmlspecialchars($catid) ?>&name=<?php echo htmlspecialchars($prod_name) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                <?php echo htmlspecialchars($prod_name) ?></a>
        </div>
        <div class="Shopping-List" id="list-total">Shopping List $ 15
            <div class="shopping-detail">
                <div class="shopping-title">
                    <ul>Shopping List Total : $ 15</ul>
                </div>

                <ul>Water - $10<input type="text"></ul>
                <ul>Potato chips - $5<input type="text"></ul>
                <button class="checkout">Check-Out</button>
            </div>
        </div>
    </div>
    <section>
        <nav class="categories">
            <h3>Categories</h3>
            <div class="categories-ul">
                <?php

                foreach ($res as $value) {
                    $catid = $value['CATID'];
                    $cat_name = $value['NAME'];
                ?>
                    <ul><a href="categories.php?categories=<?php echo htmlspecialchars($catid) ?>&Cname=<?php echo htmlspecialchars($cat_name) ?>"><?php echo htmlspecialchars($cat_name); ?></a></ul>
                <?php
                }
                ?>
            </div>

        </nav>
        <div>
            
            <ul class="product-detail">
                <li><img src="admin/lib/images/<?php echo htmlspecialchars($prod[0]["PID"]) ?>.jpg" alt="photo">
                </li>
                <li> <b><?php echo htmlspecialchars($prod[0]["NAME"]) ?></b>
                    <br>$<?php echo htmlspecialchars($prod[0]["PRICE"]) ?> 
                    <br>
                    <button id="chip">Add to Cart</button>
                    <br>
                    <div> Quantity: <?php echo htmlspecialchars($prod[0]["QUANTITY"]) ?></div><br><?php echo htmlspecialchars($prod[0]["DESCRIPTION"]) ?>
                </li>

            </ul>
        </div>

    </section>

    </div>
    
    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>

</html>