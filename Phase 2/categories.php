<?php
require __DIR__ . '/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$cat_id = $_GET["categories"];
$Cname = $_GET["Cname"];
// foreach ($res as $value) {
//     $options .= '<option value="' . $value["catid"] . '"> ' . $value["name"] . ' </option>';
// }

?>

<html>

<head>
    <title>IERG 4210 Assignment 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time();?>">
</head>

<body>
    <div class="topnav">
        <h1><a href="/" class="homepage">IERG4210 e shop</a></h1>
        <div class="path"><a href="/">Home</a> > <a href="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>"><?php echo htmlspecialchars($Cname) ?></a></div>
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
            <ul class="product-list">
                <?php
                $res_prod = ierg4210_prod_fetchall($cat_id);
                foreach ($res_prod as $value) {
                    $catid = $value["CATID"];
                    $name = $value["NAME"];
                    $price = $value["PRICE"];
                    $desc = $value["DESCRIPTION"];
                    $quantity = $value["QUANTITY"];
                    $pid = $value["PID"];
                ?>
                    <li>
                        <a href="product.php?pid=<?php echo htmlspecialchars($pid) ?>&categories=<?php echo htmlspecialchars($catid) ?>&name=<?php echo htmlspecialchars($name) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                            <img src="admin/lib/images/<?php echo htmlspecialchars($pid) ?>.jpg" alt="photo"></a>
                        <br><a href="product.php?pid=<?php echo htmlspecialchars($pid) ?>&categories=<?php echo htmlspecialchars($catid) ?>&name=<?php echo htmlspecialchars($name) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                            <?php echo htmlspecialchars($name) ?></a>
                        <br>$<?php echo htmlspecialchars($price) ?><br>
                        <button>Add to Cart</button>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

    </section>
    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>

</html>