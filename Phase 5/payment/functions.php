<?php
include_once('../admin/lib/db.inc.php');

function checkTxnid($txnid)
{
    //TO BE IMPLEMENTED - check whether we've not already processed the transaction before
    //Sample code from the reference

    /*global $db;

    $txnid = $db->real_escape_string($txnid);
    $results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

    return ! $results->num_rows;*/

    //since it is the demo only
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare('SELECT * FROM ORDERS WHERE TXNID =?');
    $q->bindParam(1, $txnid); // ORMSG
    $q->execute();
    if ($q->rowCount() > 0)
        return false;


    return true;
}

function addPayment($txnID, $type, $status, $msg,$currency)
{
    //TO BE IMPLEMENTED - adding payment record into db
    //Sample code from the reference


    /*global $db;

    if (is_array($data)) {
        $stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'sdsss',
            $data['txn_id'],
            $data['payment_amount'],
            $data['payment_status'],
            $data['item_number'],
            date('Y-m-d H:i:s')
        );
        $stmt->execute();
        $stmt->close();

        return $db->insert_id;
    }

    return false;*/



    //code...
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("UPDATE ORDERS SET TXNID=?, PAYMENT_TYPE=?,PAYMENT_STATUS=?,CURRENCY=? WHERE ORMSG=?;");
    $q->bindParam(1, $txnID,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // TXNID
    $q->bindParam(2, $type,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // type
    $q->bindParam(3, $status,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // status
    $q->bindParam(4, $currency,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,3); // currency
    $q->bindParam(5, $msg,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT); // digest

    if ($q->execute()) {
        # code...
        return $db->insert_id;
    }


    //since it is the demo only
    return false;
}


function verifyTransaction($data)
{
    global $paypalUrl;

    $req = 'cmd=_notify-validate';
    foreach ($data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypalUrl);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);

    if (!$res) {
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL error: [$errno] $errstr");
    }

    $info = curl_getinfo($ch);

    // Check the http response
    $httpCode = $info['http_code'];
    if ($httpCode != 200) {
        throw new Exception("PayPal responded with http code $httpCode");
    }

    curl_close($ch);

    return $res === 'VERIFIED';
}


?>

<!-- https://developer.paypal.com/docs/checkout/standard/integrate/ -->