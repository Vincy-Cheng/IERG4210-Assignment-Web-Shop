<?php
include_once('admin/lib/db.inc.php');

session_start();
function auth()
{

    if (!empty($_SESSION['auth'])) {
        # code...
        // return $_SESSION['auth']['email'];
        // echo "session not empty";
        // return true;

        if (!empty($_COOKIE['auth'])) {
            # code...
            // echo "not empty";
            $t = json_decode(($_COOKIE['auth']), true);
            //echo $t["email"];
            if ($t) {
                # code...
                if (time() > $t['exp']) {
                    # code...
                    return false;
                }
                global $db;
                $db = ierg4210_DB();
                $q = $db->prepare('SELECT * FROM USERS WHERE EMAIL =?');
                $q->bindParam(1, $t['email']);

                $q->execute();
                $r = $q->fetch();
                //echo $r["ADMINFLAG"];
                // echo count($r);
                // echo $t["exp"];
                //echo $t["email"];
                //echo $r['ADMINFLAG'] . "rrr";
                //echo count($r). "lengthbefire";

                if (isset($r)) {
                    

                        # code...
                        // echo $t["exp"];
                        $realk = hash_hmac('sha256', $t["exp"] . $r['SHPWD'], $r['SALT']);
                        //echo $realk;
                        if ($realk == $t["k"]) {
                            # code...
                            //echo "same";
                            $_SESSION['auth'] = $t;
                            $test = "session set";
                            if ($r['ADMINFLAG'] == 1)
                                return true;
                            
                        }
                    
                    
                    
                }
            }
        }

    }
    return false;
}
function ierg4210_csrf_getNonce($action){
	$nonce = mt_rand() . mt_rand();

	if (!isset($_SESSION['csrf_nonce'])) {
		# code...
		$_SESSION['csrf_nonce'] = array();
	}
	$_SESSION['csrf_nonce'][$action] = $nonce;

	return $nonce;
}

function ierg4210_csrf_verifyNonce($action,$receivedNonce){

	if (isset($receivedNonce)&& $_SESSION['csrf_nonce'][$action] == $receivedNonce) {
		# code...
		if ($_SESSION['auth']==null) {
			# code...
			unset($_SESSION['csrf_nonce'][$action]);
		}
		return true;
	}
	throw new Exception("csrf-attack");
	
}