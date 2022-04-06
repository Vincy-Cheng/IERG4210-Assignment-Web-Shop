<?php
require __DIR__ . '/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$options = '';

// foreach ($res as $value) {
//     $options .= '<option value="' . $value["catid"] . '"> ' . $value["name"] . ' </option>';
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
        <a href="/" class="homepage">IERG4210 e shop <img src="admin/lib/images/logo.png" alt="logo"></a>
        <div>
           <a href="login.php" class="badge badge-warning bg-warning log mr-3">Login</a>
           <?php
            if (!empty($_COOKIE['auth'])) {
                
                ?>
                <a href="auth_process.php?action=logout" class="badge badge-danger bg-danger log">Logout</a>
                
                <?php
                
                $data = json_decode($_COOKIE['auth'], true);
                ?>
                <div id="User">
                <?php
                // echo htmlspecialchars($_COOKIE['auth']);
                echo htmlspecialchars($data["username"]) . " is logged in.";
            }
            else {
                ?>
                <div id="User">
                <?php
                echo htmlspecialchars("GUEST");
            }
            
           ?>
           </div>
        </div>
        
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
                <!-- <ul><a href="Categories/Food.html">Food</a></ul>
                <ul><a href="Categories/Cleaner.html">Cleaner</a></ul>
                <ul><a href="Categories/Drink.html">Drink</a></ul> -->
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
        <div class="mainpage">
            <h1 id="mainpage-topic">Welcome to IERG4210 e shop!</h1>
            <p>Click the category list to see what product we have.</p>
            <img src="admin/lib/images/shopping.jpg" alt="shopping">
        </div>
    </section>
    <?php echo $options; ?>
    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>
<script src="script.js"></script>

</html>