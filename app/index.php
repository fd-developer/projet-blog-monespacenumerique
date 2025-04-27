<?php
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/models/security.php';
$currentUser = $authDB->isLoggedIn();

require_once './includes/functions.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$articles = $articleDB->fetchAll();

$categories = [];
$selectedcat = '';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedcat = $_GET['cat'] ?? '';

if (count($articles)) {
    $cattmp = array_map(fn($a) => $a['category'], $articles);
    $categories = array_reduce($cattmp, function ($acc, $cat) {
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);

    $articlePerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article['category']])) {
            $acc[$article['category']] = [...$acc[$article['category']], $article];
        } else {
            $acc[$article['category']] = [$article];
        }
        return $acc;
    }, []);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once './includes/head.php' ?>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once './includes/header.php' ?>
        <div class="content">
            <div class="newsfeed-container">
                <ul class="category-container">
                    <li class=<?= $selectedcat ? '' : 'cat-active' ?>><a href="/">tous les articles <span class="small">(<?= count($articles) ?>)</span>
                            <?php foreach ($categories as $catname => $catnum) : ?>
                    <li class=<?= $selectedcat === $catname ? 'cat-active' : '' ?>><a href="/?cat=<?= $catname ?>"> <?= $catname ?> <span class="small"> (<?= $catnum ?>)</span></a></li>
                <?php endforeach; ?>
                </ul>

                <div class="newsfeed-content">
                    <?php if (!$selectedcat) : ?>
                        <?php foreach ($categories as $cat => $num) : ?>
                            <h2><?= $cat ?></h2>
                            <?php fct_show_category($articlePerCategories, $cat); ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h2><?= $selectedcat ?></h2>
                        <?php fct_show_category($articlePerCategories, $selectedcat); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php require_once './includes/footer.php' ?>
</body>

</html>