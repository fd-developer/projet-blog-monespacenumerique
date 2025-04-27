<?php

$dns = 'mysql:host=127.0.0.1;dbname=blog';
$user = 'vboxuser';
$pwd = '10CB49c!25';
$dbConnectOk = false;

try {
    $pdo = new PDO($dns, $user, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    $connectOk = true;
} catch (PDOException $e) {
    //echo "error : " . $e->getMessage();
    throw new Exception($e->getMessage());
}

return $pdo;
