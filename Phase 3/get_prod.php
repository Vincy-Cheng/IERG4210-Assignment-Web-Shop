
<?php
include_once('admin/lib/db.inc.php');
$q = (int)$_REQUEST["q"];
$action = $_REQUEST['action'];
$prod = ierg4210_prod_fetchOne($q);

if ($action == "name") {
    echo $prod[0]["NAME"];
    # code...
}
else if ($action == "price"){
    echo $prod[0]["PRICE"];
}


?>
