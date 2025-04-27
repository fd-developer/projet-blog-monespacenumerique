<?php
require __DIR__ . '/database/database.php';
require_once './includes/functions.php';
$authDB = require_once __DIR__ . '/database/models/security.php';
$currentUser = $authDB->isLoggedIn();

if (!$currentUser) {
    fct_header('auth-login.php');
}

$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';
if ($id) {
    $article = $articleDB->fetchOne($id);

    if ($article['author'] === $currentUser['id']) {
        $articleDB->deleteOne($id);
    }
}

fct_header('index.php');
