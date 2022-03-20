<?php
require __DIR__ . '/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();

$prod_id = $_GET["pid"];

$Cname = $_GET["Cname"];

$prod = ierg4210_prod_fetchOne($prod_id);
$prod_name = $prod[0]["NAME"];
$cat_id = $prod[0]["CATID"];

?>
<!DOCTYPE html>
<html>

<head>
    <title>IERG 4210 Assignment 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/58775c08b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="topnav">
        <h1><a href="/" class="homepage">IERG4210 e shop</a></h1>
        <div class="path"><a href="/">Home</a> >
            <a href="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>"><?php echo htmlspecialchars($Cname) ?></a> >
            <a href="product.php?pid=<?php echo htmlspecialchars($prod_id) ?>&categories=<?php echo htmlspecialchars($catid) ?>&name=<?php echo htmlspecialchars($prod_name) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                <?php echo htmlspecialchars($prod_name) ?></a>
        </div>
        <div class="Shopping-List " id="list-total">
            <div class="text-end shopping-title"></div>
            <div class="shopping-detail">
                <div class="bg-primary" id="cart-title">Cart detail:</div>
                <div class="row mx-auto text-dark font-weight-bold cart-head">
                    <div class="col-5">Item</div>
                    <div class="col-3">Price</div>
                    <div class="col-4">Quantity</div>
                </div>
                <!-- <div class="row mx-auto my-2 cart-product">
                    <div class="col-5 cart-detail">Item-1</div>
                    <div class="col-3 cart-detail">Price-1</div>
                    <div class="col-4 cart-detail">
                        <input type='number' class='cart-prod-quan' value=2 min=1>
                        <button type='button' class='cart-remove-btn btn text-danger mx-2 my-auto'><i class='fa-solid fa-trash-can'></i></button>
                    </div>
                </div> -->
                <div class="row mx-auto">
                    <div class="col-12 text-right text-danger cart-total">Total: $0.0</div>
                </div>
                <button type="button" class="btn btn-danger mx-2 my-2" id="check-out-btn">Check-out</button>


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
                    <form action="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($cat_name) ?>" method="POST">
                            <button class="add-cart-btn" type="button" name="add_to_cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                            <input type="hidden" name="produc_id" value="<?php echo htmlspecialchars($prod[0]["PID"]) ?>" class="cart-pid">
                        </form>
                    <br>
                    <div> Quantity: <?php echo htmlspecialchars($prod[0]["QUANTITY"]) ?></div><br><?php echo htmlspecialchars($prod[0]["DESCRIPTION"]) ?>
                </li>

            </ul>
        </div>

    </section>

    </div>

    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>
<script src="script.js"></script>
</html>