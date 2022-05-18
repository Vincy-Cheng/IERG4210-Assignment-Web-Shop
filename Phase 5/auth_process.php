<?php
include_once('admin/lib/db.inc.php');
include_once('auth.php');
session_start();

function ierg4210_login()
{
	$login_success = false;
	// echo json_encode("email:". $_POST["email"] . "  password:" . $_POST["password"]);
	// if (empty($_POST['email']) || empty($_POST['password'])){
	// 	throw new Exception('empty');
	// } 
	// if (!preg_match("/^[\w\-\/][\w\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/",$_POST["email"])) {
	// 	# code...
	// 	throw new Exception('email wrong');
	// } 
	// if (!preg_match("/^[\w@#$%\^\&\*\-]+$/",$_POST["password"])) {
	// 	throw new Exception('pass wrong');
	// 	# code...
	// }

	if (
		empty($_POST['email']) || empty($_POST['password'])
		|| !preg_match("/^[\w\-\/][\w\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST["email"])
		|| !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["password"])
	) {
		# code...
		throw new Exception('Wrong Format');
	}
	// {
	// 	throw new Exception('Wrong Credentials');
	// }

	global $db;
	$db = ierg4210_DB();
	$sql = "SELECT SALT, SHPWD, ADMINFLAG, USERNAME FROM USERS WHERE EMAIL = ?";
	$q = $db->prepare($sql);

	// $q->bindParam(1, $_POST['email']);
	// $q->execute();
	// $r = $q->fetch();
	// echo $r["SALT"];
	// echo strlen($r["SALT"]) . "\n";
	if (
		$q->execute(array($_POST['email'])) && ($r = $q->fetch())
		&& $r['SHPWD'] == hash_hmac(
			'sha256',
			$_POST['password'],
			intval($r['SALT'])
		)
	) {
		// echo "exectut";
		$exp = time() + 3600 * 24 * 3; // 3days
		$token = array('email' => $_POST['email'], 'exp' => $exp, 'k' => hash_hmac('sha256', $exp . $r['SHPWD'], $r['SALT']), 'username' => $r['USERNAME']);
		// create the cookie
		setcookie('auth', json_encode($token), $exp, '', '', true, true);
		// put it also in $_SESSION
		$_SESSION['auth'] = $token;
		// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		// $txt = $r['EMAIL'];
		// $txt += $r['SHPWD'];
		// $txt += "testing";
		// fwrite($myfile, $txt);
		// fclose($myfile);
		// change the PHPSESSID after login
		session_regenerate_id();
		$login_success =  true;
		// echo "\n flag" . $r['ADMINFLAG'] . "hellow";
	} else {
		echo "fail";
	}
	// // echo json_decode("email:" . $_POST["email"] . "  password:" . $_POST["password"]);

	// echo $login_success . "login flag";
	// echo "\n test" . $r['ADMINFLAG'] . "Flag";
	// echo json_encode("salt:" . intval($r['SALT']) . "  hashedpassword:" . hash_hmac(
	// 	'sha256',
	// 	$_POST['password'],
	// 	intval($r['SALT'])
	// ));

	if ($login_success) {
		if ($r['ADMINFLAG'] == 1) {
			header('Location: admin/admin.php', true, 302);
			exit();
		} else {
			header('Location: index.php', true, 302);
			exit();
		}
	} else {
		throw new Exception("Wrong Credentials");
	}

	// echo json_encode("email:" . $_POST["email"] . "  password:" . $_POST["password"]);

	// 1. insert record to USERS table
	// 2. call db
	// 3. select salt, email, and salted and hashed password
	// 4. compare
	// 5. whether admin
	// 6. point to different place
	// 7. save SESSION p.31 tutorial 7
	// return true change it to login_success = true
	// copy the rest of sample code
	// 8. logout function button in admin.php and main.php
}

function ierg4210_signup()
{
	if (
		empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['conpassword'])
		|| !preg_match("/^[\w\-\/][\w\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST["email"])
		|| !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["username"])
		|| !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["password"])
		|| !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["conpassword"])
	) {
		# code...
		throw new Exception('Wrong Format');
	}
	global $db;
	$db = ierg4210_DB();
	$sql = "INSERT INTO USERS VALUES (NULL, ?, ?, ? , ?, 0);";
	$q = $db->prepare($sql);
	// CREATE TABLE USERS (
	// 	USERID INTEGER PRIMARY KEY,
	// 	USERNAME VARCHAR(20),
	// 	EMAIL VARCHAR(100),
	// 	SALT TEXT,
	// 	SHPWD TEXT,
	// 	ADMINFLAG INTEGER
	//    );
	$q->bindParam(1, $_POST['username'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
	$q->bindParam(2, $_POST['email'], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 100);
	$salt = random_int(0, 100000000000); //gen int instead
	$salt += random_int(0, 100000000000); //gen int instead
	$q->bindParam(3, $salt, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
	$pwd = hash_hmac('sha256', $_POST['password'], $salt);
	$q->bindParam(4, $pwd, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
	$q->execute();
	header('Location: index.php');
    exit();
}

function ierg4210_logout()
{
	session_destroy();
	setcookie('auth', '', time() - (3600 * 24 * 3), '', '', true, true);
	header('Location:login.php', true, 302);
	exit();
}

function ierg4210_changepwd()
{
	if (
		empty($_POST['inputemail']) || empty($_POST['oldpassword']) || empty($_POST['newpassword'])
		|| !preg_match("/^[\w\-\/][\w\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST["inputemail"])
		|| !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["oldpassword"]) || !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["newpassword"])
	) {
		# code...
		throw new Exception('Wrong Format');
	}

	global $db;
	$db = ierg4210_DB();
	$sql = "SELECT * FROM USERS WHERE EMAIL = ?";
	$q = $db->prepare($sql);
	if (
		$q->execute(array($_POST['inputemail'])) && ($r = $q->fetch())
		&& $r['SHPWD'] == hash_hmac(
			'sha256',
			$_POST['oldpassword'],
			intval($r['SALT'])
		)
	) {
		$pwd = hash_hmac('sha256', $_POST['newpassword'], $r['SALT']);
		$sql = "UPDATE USERS SET SHPWD = ? WHERE EMAIL = ?";
		$q2 = $db->prepare($sql);
		$q2->bindParam(1, $pwd,PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
		$q2->bindParam(2, $_POST['inputemail'],PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
		$q2->execute();
		// header('Content-Type: text/html; charset=utf-8');
		// echo 'Password updated. <br/><a href="javascript:history.back();">Back to login page.</a>';
		// exit();
		return ierg4210_logout();
	}
	header('Content-Type: text/html; charset=utf-8');
	echo 'Invalid Old Password detected. <br/><a href="javascript:history.back();">Back to login page.</a>';
	exit();
}




header('Content-Type: application/json');

// input validation
if (empty($_REQUEST['action']) || !preg_match('/^\w+$/', $_REQUEST['action'])) {
	echo json_encode(array('failed' => 'undefined'));
	exit();
}

// The following calls the appropriate function based to the request parameter $_REQUEST['action'],
//   (e.g. When $_REQUEST['action'] is 'cat_insert', the function ierg4210_cat_insert() is called)
// the return values of the functions are then encoded in JSON format and used as output
try {



	if (($returnVal = call_user_func('ierg4210_' . $_REQUEST['action'])) === false) {
		if ($db && $db->errorCode())
			error_log(print_r($db->errorInfo(), true));
		echo json_encode(array('failed' => '1'));
	}
	ierg4210_csrf_verifyNonce($_REQUEST['action'], $_POST['nonce']);
	echo 'while(1);' . json_encode(array('success' => $returnVal));
} catch (PDOException $e) {
	error_log($e->getMessage());
	echo json_encode(array('failed' => 'error-db'));
} catch (Exception $e) {
	echo 'while(1);' . json_encode(array('failed' => $e->getMessage()));
}
