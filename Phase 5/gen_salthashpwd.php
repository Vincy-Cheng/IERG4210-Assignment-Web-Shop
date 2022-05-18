<?php
$password = readline("Enter password:");
$salt = random_int(0,100000000000);//gen int instead
$salt += random_int(0,100000000000);//gen int instead
echo ($salt . "\n");
echo "\n333\n";
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = $salt;
fwrite($myfile, $txt);
fclose($myfile);
echo hash_hmac('sha256', $password, $salt);
?> 

