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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <a href="order.php" class="badge badge-light bg-secondary log">Order history</a>
                <?php

                $data = json_decode($_COOKIE['auth'], true);
                ?>
                <div id="User">
                <?php
                // echo htmlspecialchars($_COOKIE['auth']);
                echo htmlspecialchars($data["username"]) . " is logged in.";

            } else {
                ?>
                <a href="order.php" class="badge badge-light bg-secondary log">Order history</a>
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
                        <form action="/payment/payments.php" method="post" id="form1" onsubmit="return formsubmit(event)">
                            <input type="hidden" name="cmd" value="_cart" />
                            <input type="hidden" name="upload" value="1" />
                            <input type="hidden" name="business" value="sb-qhkn615552583@business.example.com" />
                            <input type="hidden" name="currency_code" value="HKD" />
                            <input type="hidden" name="charset" value="utf-8" />


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
                            <button class="btn btn-danger mx-2 my-2" id="check-out-btn" type="submit" form="form1" value="Submit">Check-out</button>
                            <div id="paypal-button-container"></div>
                        </form>

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
<script src='//code.jquery.com/jquery-latest.js'></script>

<!-- <script src="https://www.paypal.com/sdk/js?client-id=AfAL0GFbUvq3OPUfbVzuQw7Tse0pe7EOjnedPBHEQe2lPiyLQCEyop1hzEBVuZRRyC5mBmK-vDd2rIfx&currency=HKD"></script>
<script>paypal.Buttons({
    // Order is created on the server and the order id is returned
    createOrder: (data, actions) => {
      return fetch("/api/orders", {
        method: "post",
        // use the "body" param to optionally pass additional order information 
        // like product ids or amount
      })
      .then((response) => response.json())
      .then((order) => order.id);
    },
    // Finalize the transaction on the server after payer approval
    onApprove: (data, actions) => {
      return fetch(`/api/orders/${data.orderID}/capture`, {
        method: "post",
      })
      .then((response) => response.json())
      .then((orderData) => {
        // Successful capture! For dev/demo purposes:
        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
        const transaction = orderData.purchase_units[0].payments.captures[0];
        alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
        // When ready to go live, remove the alert and show a success message within this page. For example:
        // const element = document.getElementById('paypal-button-container');
        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
        // Or go to another URL:  actions.redirect('thank_you.html');
      });
    }
  }).render('#paypal-button-container');</script> -->

</html>