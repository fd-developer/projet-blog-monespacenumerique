<?php
require_once './includes/functions.php';
$pdo = require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/models/security.php';

$sessionId = $_COOKIE['session'];
if ($sessionId) {
    $authDB->logout($sessionId);
    fct_header('auth-login.php');
}
