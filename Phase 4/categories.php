<?php
require __DIR__ . '/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$cat_id = $_GET["categories"];
$Cname = $_GET["Cname"];
// foreach ($res as $value) {
//     $options .= '<option value="' . $value["catid"] . '"> ' . $value["name"] . ' </option>';
// }
// if (isset($_POST['add_to_cart'])) {
//     # code...
//     echo($_POST['produc_id']);
// }
?>

<html>

<head>
    <title>IERG 4210 Assignment 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/58775c08b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time(); ?>">

</head>

<body>
    <div class="topnav">
        <h1><a href="/" class="homepage">IERG4210 e shop <img src="admin/lib/images/logo.png" alt="logo"></a></h1>
        <div class="path"><a href="/">Home</a> > <a href="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>"><?php echo htmlspecialchars($Cname) ?></a></div>
        <div class="Shopping-List " id="list-total">
            <div class="text-end shopping-title"><i class='fa-solid fa-cart-shopping'></i> Shopping List $0.0</div>
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
                <div class="row mx-auto ">
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
            Click Page to access more product
            <div class="mx-5">
                Page:
                <?php

                $res_prod = ierg4210_prod_fetchall($cat_id);
                $page = (int)((count($res_prod) - 1) / 4);
                // echo htmlspecialchars(count($res_prod));
                // echo htmlspecialchars($page);
                // echo (int)(count($res_prod)/4);
                for ($i = 0; $i <= $page; $i++) {
                ?>
                    <button class="btn btn-secondary mx-auto page-btn my-3" type="button"><?php echo htmlspecialchars($i + 1) ?></button>
                <?php

                }
                ?>
            </div>
            <?php

            // echo (int)(count($res_prod)/4);

            for ($i = 0; $i <=  $page; $i++) {
            ?>

                <ul class="product-list 
                <?php if ($i !=0) {
                    echo htmlspecialchars(" d-none");
                }?>" id="product-list<?php echo htmlspecialchars($i + 1) ?>">

                    <?php
                    $count;
                    if (count($res_prod) - $i * 4 > 4) {
                        $count = 4;
                    } else {
                        $count = count($res_prod) - $i * 4;
                    }
                    ?>

                    <?php
                    for ($k = 0; $k < $count; $k++) {
                        $catid = $res_prod[$k + $i * 4]["CATID"];
                        $name = $res_prod[$k + $i * 4]["NAME"];
                        $price = $res_prod[$k + $i * 4]["PRICE"];
                        $desc = $res_prod[$k + $i * 4]["DESCRIPTION"];
                        $quantity = $res_prod[$k + $i * 4]["QUANTITY"];
                        $pid = $res_prod[$k + $i * 4]["PID"];
                    ?>
                        <li>
                            <a href="product.php?pid=<?php echo htmlspecialchars($pid) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                                <img src="admin/lib/images/<?php echo htmlspecialchars($pid) ?>.jpg" alt="photo"></a>
                            <br><a href="product.php?pid=<?php echo htmlspecialchars($pid) ?>&Cname=<?php echo htmlspecialchars($Cname) ?>">
                                <?php echo htmlspecialchars($name) ?></a>
                            <br>$<?php echo htmlspecialchars($price) ?><br>
                            <form action="categories.php?categories=<?php echo htmlspecialchars($cat_id) ?>&Cname=<?php echo htmlspecialchars($cat_name) ?>" method="POST">
                                <button class="add-cart-btn" type="button" name="add_to_cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                                <input type="hidden" name="produc_id" value="<?php echo htmlspecialchars($pid) ?>" class="cart-pid">
                            </form>
                        </li>
                    <?php
                    }
                    ?>

                </ul>

            <?php
            }
            ?>

        </div>

    </section>
    <footer>Designed by Cheng Wing Lam from CUHK</footer>
    <script src="script.js"></script>
</body>


</html>