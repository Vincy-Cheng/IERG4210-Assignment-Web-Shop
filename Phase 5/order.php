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
        <h1><a href="/" class="homepage">IERG4210 e shop <img src="admin/lib/images/logo.png" alt="logo"></a></h1>
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
            } else {
                ?>
                    <div id="User">
                    <?php
                    echo htmlspecialchars("GUEST");
                }

                    ?>
                    </div>
                </div>
        </div>

    </div>

    <div class="d-flex flex-column justify-content-center mt-4">
        <div>
            <h2 id="order_title">Order history</h2>
            <ul class="order_reminder">
                <li>
                    If user is logged in, this page will auto display the most recent 5 orders. (It will be nothing if no order record)
                </li>
                <li>
                    User or Guest can also use the load function to load the order record by the invoice number and the digest.
                </li>
                <li>
                    Make Sure you have entered the correct invoice number and digest. Otherwise, nothing is found.
                </li>
            </ul>
        </div>
        <div id="order_table">


            <form id="loadorder" onsubmit="return loadorder(event)">
                <div>
                    <label for="email">Invoice Number:</label>

                    <input id="order_invoice" type="number" class="form-control" name="invoice" require>
                </div>
                <div>
                    <label for="email">Digest:</label>

                    <input id="order_digest" type="text" class="form-control" name="digest" require>
                </div>
                <button type="submit" class="btn btn-primary my-2">Load data</button>
            </form>


            <?php

            $user = json_decode($_COOKIE['auth'], true);
            $data = ierg4210_order_fetchAllByUsername($user["username"]);
            ?>
            </table>
            <table id="show_order_record" class="my-4">
                <tr>
                    <th>Invoice numuber</th>
                    <th>TXN ID</th>
                    <!-- <th>Digested order message</th> -->
                    <!-- <th>Salt</th> -->
                    <th>Payment Currency</th>
                    <th>Payment Type</th>
                    <th>Payment Status</th>
                    <th>Product List</th>
                    <th>Total</th>
                    <th>Customer</th>
                </tr>
                <?php
                //echo count($order);
                foreach ($data as $o) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($o["UUID"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["TXNID"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["CURRENCY"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["PAYMENT_TYPE"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["PAYMENT_STATUS"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["PRODUCT_LIST"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["PAYMENT_AMOUNT"]);   ?></td>
                        <td><?php echo htmlspecialchars($o["USERNAME"]);   ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>

    </div>

    </div>

    <footer>Designed by Cheng Wing Lam from CUHK</footer>
</body>
<script src="script.js"></script>
<script src='//code.jquery.com/jquery-latest.js'></script>

</html>