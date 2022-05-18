
<?php
include_once('admin/lib/db.inc.php');

$action = $_REQUEST['action'];


if ($action == "name") {
    $q = (int)$_REQUEST["q"];
    $prod = ierg4210_prod_fetchOne($q);
    echo $prod[0]["NAME"];
    # code...
} else if ($action == "price") {
    $q = (int)$_REQUEST["q"];
    $prod = ierg4210_prod_fetchOne($q);
    echo $prod[0]["PRICE"];
} else if ($action == "checkout") {
    // $q = $_POST;
    // $w = $_REQUEST;
    // $manage = json_decode($q[0], true);
     $myfile2 = fopen("testfile2.txt", "w") or die("Unable to open file!");
     fwrite($myfile2, "get in");
    // $myfile = fopen("testfile.txt", "w") or die("Unable to open file!");
    // $txt = $manage;
    // $txt = json_encode($_POST);
    //fwrite($myfile, $txt);

    // fwrite($myfile, $txt);
    // fwrite($myfile,json_encode($_POST[0]));
    // fwrite($myfile,json_encode($_POST["10"]));
    // fwrite($myfile,json_encode($_POST["2"]));

    // foreach loop
    // foreach($_POST as $x => $x_value) {
    //     $t =  "Key=" . ($x) . ", Value=" . ((int)$x_value);
    //     fwrite($myfile, $t);
    //   }
    // foreach ($_POST as $value) {
    //     fwrite($myfile, json_encode((int)$value));
    //   }

    // only POST 

    $product_list = [];
    foreach ($_POST as $x => $x_value) {
        array_push($product_list, ierg4210_prod_fetchOne($x));
    }
    //fwrite($myfile2, "\nget in 2");
    // fwrite($myfile, json_encode($product_list[0][0]["NAME"]));
    //fwrite($myfile, count($product_list));
    
    for ($i = 0; $i < count($product_list); $i++) {
        # code...
        if ($product_list[0][0]["QUANTITY"] < 0) {
            # code...
            throw new Exception("Payment failed", 1);
        }
    }
    //fwrite($myfile2, "\nget in 3");
    $currency = 'HKD';
    $email = 'sb-qhkn615552583@business.example.com';
    $salt = random_int(0,100000000000);//gen int instead
    $salt += random_int(0,100000000000);//gen int instead
    $prods = [];
    $total = 0;
    for ($i = 0; $i < count($product_list); $i++) {
        # code...
        $quantity_selected = $product_list[$i][0]["PID"]; 
        $p = array("PID" => $product_list[$i][0]["PID"], "QUANTITY" => $_POST[$quantity_selected], "PRICE" => $product_list[$i][0]["PRICE"]);
        $total += $product_list[$i][0]["PRICE"]*$_POST[$quantity_selected];
        array_push($prods, $p);
    }

    $total = number_format($total, 1, '.', '');
    //fwrite($myfile2, "\nget in 4");
    $prods = json_encode($prods);
    $all = $currency . '&' . $email . '&' . $prods . '&' . $total . '&' . $salt;
    fwrite($myfile2, $all . "\nall\n");
    $hashed = hash('sha256', $all);
    //fwrite($myfile2, "\nget in 5");
    $username = $_REQUEST["username"];
    global $db;
    $db = ierg4210_DB();
    // CREATE TABLE ORDERS (
    //     UUID INTEGER PRIMARY KEY,
    //     ORMSG TEXT,
    //     SALT TEXT,
    //     TXNID VARCHAR(20),
    //     PAYMENT_TYPE VARCHAR(30),
    //     PAYMENT_AMOUNT REAL,
    //     PAYMENT_STATUS VARCHAR(25),
    //     PRODUCT_LIST TEXT,
    //     USERNAME VARCHAR(20)
    //    );
    // $sql = "INSERT INTO PRODUCTS (CATID, NAME, PRICE, DESCRIPTION, QUANTITY) VALUES (?, ?, ?, ?, ?);";

    $sql = "INSERT INTO ORDERS (ORMSG, SALT, TXNID, PAYMENT_TYPE, PAYMENT_AMOUNT, PAYMENT_STATUS, PRODUCT_LIST, CURRENCY, USERNAME) VALUES (?, ?, NULL,NULL, ?, NULL, ?, NULL, ?);";
    $q = $db->prepare($sql);
    $q->bindParam(1, $hashed,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // ORMSG
    $q->bindParam(2, $salt,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // SALT
    $q->bindParam(3, $total); // payment amount
    $q->bindParam(4, $prods,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // product-list
    $q->bindParam(5, $username,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20); // username
    $q->execute();
    $lastId = $db->lastInsertId();
    $r = array("invoice"=>$lastId,"custom"=>$hashed);
    //$str = str_replace('\\', '', json_encode($prods));
    //fwrite($myfile, $str);
    //fwrite($myfile, "\n");
    // fwrite($myfile, ($prods));
    // fclose($myfile);
     fclose($myfile2);
    echo json_encode($r);
}elseif ($action =="loadorder") {
    # code...
    $order = ierg4210_order_fetchAllByInvoiceDigest($_POST["invoice"],$_POST["digest"]);
    // $file2 = fopen("test.txt", "w") or die("Unable to open file!");
    // fwrite($file2, json_encode($order));
    // fclose($file2);
    echo json_encode($order);
}


?>


