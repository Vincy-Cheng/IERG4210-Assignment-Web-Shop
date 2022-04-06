<?php
function ierg4210_DB()
{
    // connect to the database
    // TODO: change the following path if needed
    // Warning: NEVER put your db in a publicly accessible location
    $db = new PDO('sqlite:/var/www/cart.db');

    // enable foreign key support
    $db->query('PRAGMA foreign_keys = ON;');

    // FETCH_ASSOC:
    // Specifies that the fetch method shall return each row as an
    // array indexed by column name as returned in the corresponding
    // result set. If the result set contains multiple columns with
    // the same name, PDO::FETCH_ASSOC returns only a single value
    // per column name.
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $db;
}

function ierg4210_cat_fetchall()
{
    //ok
    // DB manipulation
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

// Since this form will take file upload, we use the tranditional (simpler) rather than AJAX form submission.
// Therefore, after handling the request (DB insert and file copy), this function then redirects back to admin.html
function ierg4210_prod_insert()
{
    // input validation or sanitization
    //ok
    // DB manipulation
    global $db;
    $db = ierg4210_DB();

    // TODO: complete the rest of the INSERT command
    if (!preg_match('/^\d*$/', $_POST['catid']))
        throw new Exception("invalid-catid");
    $_POST['catid'] = (int) $_POST['catid'];
    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
        throw new Exception("invalid-name");
    if (!preg_match('/^[\d\.]+$/', $_POST['price']))
        throw new Exception("invalid-price");
    if (!preg_match('/^[\w\-\. ]+$/', $_POST['description']))
        throw new Exception("invalid-text");
    if (!preg_match('/^\d*$/', $_POST['quantity']))
        throw new Exception("invalid-quantity");

    $sql = "INSERT INTO products (catid, name, price, description) VALUES (?, ?, ?, ?)";
    $q = $db->prepare($sql);

    // Copy the uploaded file to a folder which can be publicly accessible at incl/img/[pid].jpg
    if (
        $_FILES["file"]["error"] == 0
        && $_FILES["file"]["type"] == "image/jpeg"
        && mime_content_type($_FILES["file"]["tmp_name"]) == "image/jpeg"
        && $_FILES["file"]["size"] < 5000000
    ) {


        $catid = $_POST["catid"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $desc = $_POST["description"];
        $quantity = $_POST["quantity"];
        $sql = "INSERT INTO PRODUCTS (CATID, NAME, PRICE, DESCRIPTION, QUANTITY) VALUES (?, ?, ?, ?, ?);";
        $q = $db->prepare($sql);
        $q->bindParam(1, $catid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
        $q->bindParam(2, $name,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 100);
        $q->bindParam(3, $price);
        $q->bindParam(4, $desc,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 300);
        $q->bindParam(5, $quantity,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 5);
        $q->execute();
        $lastId = $db->lastInsertId();
        // $lastId = $db->lastInsertId();
        // Note: Take care of the permission of destination folder (hints: current user is apache)
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/admin/lib/images/" . $lastId . ".jpg")) {
            // redirect back to original page; you may comment it during debug
            header('Location: admin.php');
            exit();
        }
    }
    // Only an invalid file will result in the execution below
    // To replace the content-type header which was json and output an error message
    header('Content-Type: text/html; charset=utf-8');
    echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
    exit();
}

// TODO: add other functions here to make the whole application complete
function ierg4210_cat_insert()
{
    //ok
    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^[\w\- ]+$/', $_POST['name'])) {
        throw new Exception('invalid-name <br/><a href="javascript:history.back();">Back to admin panel.</a>');
    }


    $sql = "INSERT INTO CATEGORIES (NAME) VALUES (?);";
    $q = $db->prepare($sql);
    $name = $_POST["name"];
    $q->bindParam(1, $name,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 100);
    $q->execute();
    // Only an invalid file will result in the execution below
    // To replace the content-type header which was json and output an error message
    header('Location: admin.php');
    exit();
}
function ierg4210_cat_edit()
{
    // 
    global $db;
    $db = ierg4210_DB();
    if (!preg_match('/^\d*$/', $_POST['catid']))
        throw new Exception("invalid-catid");
    if (!preg_match('/^[\w\- ]+$/', $_POST['name'])) {
        throw new Exception('invalid-name <br/><a href="javascript:history.back();">Back to admin panel.</a>');
    }
    $catid = $_POST["catid"];
    $name = $_POST["name"];
    $sql = "UPDATE CATEGORIES SET NAME=? WHERE CATID=?;";
    $q = $db->prepare($sql);
    $q->bindParam(1, $name,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 100);
    $q->bindParam(2, $catid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    $q->execute();
    header('Location: admin.php');
    exit();
}
function ierg4210_cat_delete()
{
    global $db;
    $db = ierg4210_DB();
    $catid = $_POST["catid"];
    $sql = "DELETE FROM CATEGORIES WHERE CATID=?;";

    $q = $db->prepare($sql);
    $q->bindParam(1, $catid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    $q->execute();
    // echo $catid;
    header('Location: admin.php');
    exit();
}
function ierg4210_prod_delete_by_catid()
{
    // Delete all product under that category
    global $db;
    $db = ierg4210_DB();
    if (!preg_match('/^\d*$/', $_POST['catid']))
        throw new Exception("invalid-catid");
    $catid = $_POST["catid"];
    $sql = "DELETE FROM PRODUCTS WHERE CATID=?;";
    $q = $db->prepare($sql);
    $q->bindParam(1, $catid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    $q->execute();
    header('Location: admin.php');
    exit();
}
function ierg4210_prod_fetchAll($catid)
{
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products WHERE CATID=?;");
    $q->bindParam(1, $catid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    if ($q->execute())
        return $q->fetchAll();
}
function ierg4210_prod_fetchOne($pid)
{
    global $db;
    $db = ierg4210_DB();
    // $pid = $_GET["pid"];
    // $name = $_GET["name"];
    $q = $db->prepare("SELECT * FROM products WHERE PID=?;");
    $q->bindParam(1, $pid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    if ($q->execute())
        return $q->fetchAll();
}
function ierg4210_prod_edit()
{
    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^\d*$/', $_POST['pid']))
        throw new Exception("invalid-catid");
    $_POST['catid'] = (int) $_POST['catid'];
    if (!preg_match('/^[\w\-\]+$/', $_POST['name']))
        throw new Exception("invalid-name");
    if (!preg_match('/^[\d\.]+$/', $_POST['price']))
        throw new Exception("invalid-price");
    if (!preg_match('/^[\w\-\. ]+$/', $_POST['description']))
        throw new Exception("invalid-textt");
    if (!preg_match('/^\d*$/', $_POST['quantity']))
        throw new Exception("invalid-quantity");


    if (
        $_FILES["file"]["error"] == 0
        && $_FILES["file"]["type"] == "image/jpeg"
        && mime_content_type($_FILES["file"]["tmp_name"]) == "image/jpeg"
        && $_FILES["file"]["size"] < 5000000
    ) {

        $pid = $_POST["pid"];
        $name = $_POST["name"];
        $quan = $_POST["quantity"];
        $price = $_POST["price"];
        $desc = $_POST["description"];
        $q = $db->prepare("UPDATE PRODUCTS SET NAME=?, PRICE=?, DESCRIPTION=? , QUANTITY=?  WHERE PID=?;");
        $q->bindParam(1, $name,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 100);
        $q->bindParam(2, $price);
        $q->bindParam(3, $desc,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 300);
        $q->bindParam(4, $quan,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 5);
        $q->bindParam(5, $pid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
        $q->execute();
        $lastId = $pid;
        // $lastId = $db->lastInsertId();
        // Note: Take care of the permission of destination folder (hints: current user is apache)
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/admin/lib/images/" . $lastId . ".jpg")) {
            // redirect back to original page; you may comment it during debug
            header('Location: admin.php');
            exit();
        }
    }
    // Only an invalid file will result in the execution below
    // To replace the content-type header which was json and output an error message
    header('Content-Type: text/html; charset=utf-8');
    echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
    exit();
}
function ierg4210_prod_delete()
{
    //ok
    global $db;
    $db = ierg4210_DB();
    if (!preg_match('/^\d*$/', $_POST['pid']))
        throw new Exception("invalid-pid");
    $pid = $_POST["pid"];
    $sql = "DELETE FROM PRODUCTS WHERE PID=?;";
    $q = $db->prepare($sql);
    $q->bindParam(1, $pid,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 3);
    $q->execute();
    header('Location: admin.php');
    exit();
}
