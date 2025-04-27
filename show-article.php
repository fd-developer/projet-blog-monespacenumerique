<?php
require __DIR__ . '/database/database.php';
require_once './includes/functions.php';
$authDB = require_once __DIR__ . '/database/models/security.php';
$currentUser = $authDB->isLoggedIn();

$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if (!$id) {
    fct_header('index.php');
} else {
    $article = $articleDB->fetchOne($id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once './includes/head.php' ?>
    <link rel="stylesheet" href="./public/css/show-article.css">
    <title>Article</title>
</head>

<body>
    <div class="container">
        <?php require_once './includes/header.php' ?>
        <div class="content">
            <div class="article-container">
                <a href="/" class="article-back ">Retour à la liste des articles</a>
                <div class="article-cover-image" style="background-image: url('<?= $article['image'] ?>')"></div>
                <h1 class="article-title"><?= $article['title'] ?></h1>
                <div class="separator"></div>
                <p class="article-content"><?= $article['content'] ?></p>

                <?php if ($article['author']) : ?>
                    <div class="article-author">
                        <p><?= $article['firstname'] . ' ' . $article['lastname'] ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($currentUser && $currentUser['id'] === $article['author']) : ?>
                    <div class="action">
                        <a class="btn btn-secondary" href="/delete-article.php?id=<?= $article['id'] ?>">Supprimer</a>
                        <a class="btn btn-primary" href="/form-article.php?id=<?= $article['id'] ?>">Editer l'article</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php require_once './includes/footer.php' ?>
</body>

</html>