<?php
require('functions.php');
include_once('admin/lib/db.inc.php');
// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// Database settings. Change these for your database configuration.
/*$dbConfig = [
    'host' => 'localhost',
    'username' => 'user',
    'password' => 'secret',
    'name' => 'example_database'
];*/

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    //'email' => 'user@example.com',
    'return_url' => 'https://secure.s19.ierg4210.ie.cuhk.edu.hk/',
    'cancel_url' => 'https://secure.s19.ierg4210.ie.cuhk.edu.hk/payment/payment-cancelled.html',
    'notify_url' => 'https://secure.s19.ierg4210.ie.cuhk.edu.hk/payment/payments.php'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

    // Grab the post data so that we can set up the query string for PayPal.
    // Ideally we'd use a whitelist here to check nothing is being injected into
    // our post data.
    $data = [];
    foreach ($_POST as $key => $value) {
        $data[$key] = stripslashes($value);
    }

    // Set the PayPal account.
    //$data['business'] = $paypalConfig['email'];

    // Set the PayPal return addresses.
    $data['return'] = stripslashes($paypalConfig['return_url']);
    $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
    $data['notify_url'] = stripslashes($paypalConfig['notify_url']);

    // Set the details about the product being purchased, including the amount and currency so that these aren't overridden by the form data.
    //$data['item_name'] = $itemName;
    //$data['amount'] = $itemAmount;
    //$data['currency_code'] = 'GBP';

    // Add any custom fields for the query string.
    //$data['custom'] = USERID;

    // Build the query string from the data.
    $queryString = http_build_query($data);

    // Redirect to paypal IPN
    header('location:' . $paypalUrl . '?' . $queryString);
    exit();
} else {
    // Handle the PayPal response.

    // Create a connection to the database.
    //$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

    // Assign posted variables to local data array.
    //error_log(print_r($_POST,true));
    // $data = [
    //     'item_name_1' => $_POST['item_name_1'],
    //     'quantity_1' => $_POST['quantity_1'],
    //     'item_name_2' => $_POST['item_name_2'],
    //     'quantity_2' => $_POST['quantity_2'],
    //     'payment_status' => $_POST['payment_status'],
    //     'payment_amount' => $_POST['mc_gross'],
    //     'payment_currency' => $_POST['mc_currency'],
    //     'txn_id' => $_POST['txn_id'],
    //     'receiver_email' => $_POST['receiver_email'],
    //     'custom' => $_POST['custom'],
    // ];


    $itemNum = 0;
    $file = fopen("count.txt", "w") or die("Unable to open file!");
    // $file2 = fopen("count2.txt", "w") or die("Unable to open file!");
    // fwrite($file, "opened");
    // fwrite($file, "\n");
    //$store =[];
    // $d = [
    //     'item_name_1' => "Elephant-Rice",
    //     'item_name_2' => "Push",
    // ];
    fwrite($file, "opened");
    fwrite($file, "\n");
    //fwrite($file, json_encode($data));
    //fwrite($file, "\n");
    // if (strpos(strval($_POST['item_name1']), 'item_name') != false) {
    //     # code...
    //     fwrite($file, "catch\n");
    // }
    // else {
    //     # code...
    //     fwrite($file, "not catch\n");
    // }
    foreach ($_POST as $key => $value) {
        $n = strval($key);
        if (strpos($n, 'item_name') !== false) {
            # code...
            $itemNum++;
            //fwrite($file, "catch\n");
        }
        // else {
        //     # code...
        //     fwrite($file, "not catch\n");
        // }
        //$store += array($key => $value);

        //fwrite($file, "Key =" . $n . ", Value=" . $value);
        //fwrite($file, "\n");
    }
    // foreach ($store as $key => $value) {
    //     if (str_contains($key, 'item_name')) {
    //         # code...
    //         $itemNum++;
    //     }
    // }
    //fwrite($file, $itemNum . "\n");
    //fwrite($file, "checkpoint1\n");
    $item = []; // product list
    for ($i = 1; $i <= $itemNum; $i++) {
        # code...
        //fwrite($file, "checkpoint1.0\n");
        $name = "item_name" . $i;
        $quantity = "quantity" . $i;
        
        $it = getitemppid($_POST[$name]);
        //$price = $it[0]["PRICE"];
        //fwrite($file, "checkpoint1.1\n");  // number_format($_POST[$price], 1, '.', '')
        $p = array("PID" => $it[0]["PID"], "QUANTITY" => $_POST[$quantity], "PRICE" => $it[0]["PRICE"]);
        //fwrite($file, "checkpoint1.2\n");
        array_push($item, $p);
        //fwrite($file, "test =" . $i);
        //fwrite($file, "\n");
    }
    usort($item, 'sortByPID');
    $item = json_encode($item);

    $payment_status   = $_POST['payment_status'];
    $payment_amount   = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id           = $_POST['txn_id'];
    $receiver_email   = $_POST['receiver_email'];
    $payer_email      = $_POST['payer_email'];
    $record_id         = $_POST['custom'];
    $t = $_POST['txn_type'];

    $payment_amount = number_format($payment_amount, 1, '.', '');

    fwrite($file, $txn_id);
    fwrite($file, "\n");
    fwrite($file, "check\n");
    fwrite($file, $payment_status);
    fwrite($file, "\n");
    fwrite($file, "check\n");
    fwrite($file, $payment_amount);
    fwrite($file, "\n");
    fwrite($file, "check\n");
    fwrite($file, $record_id);
    fwrite($file, "\n");
    fwrite($file, "check\n");
    $s = getsalt($record_id);
    //fwrite($file, "get salt\n");
    // $yy = [
    //     "UUID" => 1,
    //     "ORMSG" => "0200f724da7bf29931fabe977a141e2cfbc9b6178a8bd57e0e6d464937a5a9dc",
    //     "SALT" => 'aa',
    //     "TXNID" => NULL,
    //     "PAYMENT_TYPE" => NULL,
    //     "PAYMENT_AMOUNT" => 100,
    //     "PAYMENT_STATUS" => NULL,
    //     "PRODUCT_LIST" => '[{"PID":"11","QUANTITY":"57","PRICE":"55.0"}]',
    //     "USERNAME" => "GUEST"

    // ];
    // $salt = $yy["SALT"];
    if ($s == false) {
        # code...
        $salt = 0;
        //throw new Exception("Can't find salt", 1);

    } else
        $salt = $s[0]["SALT"];
    fwrite($file, "pro salt\n");
    $all = $payment_currency . '&' . $receiver_email . '&' . $item . '&' . $payment_amount . '&' . $salt;
    fwrite($file, $all);
    fwrite($file, "\n");
    $hashed = hash('sha256', $all);
    if (!isset($txn_id)) {
        # code...
        fwrite($file, "not existed");
        fwrite($file, "\n");
    }

    fwrite($file, $hashed);
    fwrite($file, "\n");
    fwrite($file, "check\n");

    fwrite($file, $item);

    // We need to verify the transaction comes from PayPal and check we've not
    // already processed the transaction before adding the payment to our
    // database.
    if (verifyTransaction($_POST) ) {
        if ($_POST['txn_type'] == "cart") {
            # code...
            fwrite($file, "ok cart\n");
            if ($hashed == $record_id) {
            fwrite($file, "ok hashed\n");
            # code...
            if (checkTxnid($txn_id)) {
                # code...
                fwrite($file, "ok txtid\n");
                if (addPayment($txn_id, $t, $payment_status, $hashed, $payment_currency) !== false) {
                    // Payment successfully added into db.
                    fwrite($file, "sucess\n");
                }
            }
        }
        }
        


        fwrite($file, "failed inside\n");
    } else {
        //Payment failed

        fwrite($file, "failed\n");
    }
    fclose($file);
}


function getitemppid($name)
{
    global $db;
    $db = ierg4210_DB();
    // $pid = $_GET["pid"];
    // $name = $_GET["name"];
    $q = $db->prepare("SELECT * FROM PRODUCTS WHERE NAME=?;");
    $q->bindParam(1, $name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    if ($q->execute())
        return $q->fetchAll();
}

function getsalt($digest)
{
    global $db;
    $db = ierg4210_DB();
    // $pid = $_GET["pid"];
    // $name = $_GET["name"];
    $q = $db->prepare("SELECT * FROM ORDERS WHERE ORMSG=?;");
    $q->bindParam(1, $digest, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    if ($q->execute())
        return $q->fetchAll();
    return false;
}

function sortByPID($a, $b)
{
    $a = $a['PID'];
    $b = $b['PID'];

    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}


