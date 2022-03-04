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
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time();?>">
</head>

<body>
    <div class="topnav">
        <a href="/" class="homepage">IERG4210 e shop</a>
        <a href="admin/admin.php">Admin Panel</a>
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
                <!-- <ul><a href="Categories/Food.html">Food</a></ul>
                <ul><a href="Categories/Cleaner.html">Cleaner</a></ul>
                <ul><a href="Categories/Drink.html">Drink</a></ul> -->
                <?php 
                foreach ($res as $value) {
                    $catid = $value['CATID'];
                    $cat_name = $value['NAME'];
                    ?>
                    <ul><a href="categories.php?categories=<?php echo htmlspecialchars($catid)?>&Cname=<?php echo htmlspecialchars($cat_name)?>"><?php echo htmlspecialchars($cat_name); ?></a></ul>
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
                <?php echo $options;?>
    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>


</html>