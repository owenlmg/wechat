<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-13
 * Time: 10:07
 */
//phpinfo();
$username = 'root';
$password = 'root';
$pwd = strtolower($username) . $password;
for ($i = 0; $i < 1023; $i++) {
    $pwd = sha1($pwd, true);
}
$pwd = sha1($pwd);
//$pwd = 'x';
$hash = password_hash($pwd, PASSWORD_DEFAULT);
$password = '$2a$10$ruoTiCH0mXTZ8bFhI4fsA.2fWaDP4PL32Tn.ntNbO6AoNktpEpk7m';
var_dump(password_verify($pwd, str_replace('$2a$10', '$2y$10', $password)));
