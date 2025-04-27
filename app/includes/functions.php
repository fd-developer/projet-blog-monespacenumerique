<?php

function fct_header($filedest)
{
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $filedest;
    header("Location: http://$host$uri/$extra");
    exit;
}

function fct_show_category($pArticlePerCategories, $pCat)
{
?>
    <div class="articles-container">'
        <?php foreach ($pArticlePerCategories[$pCat] as $a) : ?>
            <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                <div class="overflow">
                    <div class="image-container" style="background-image: url('<?= $a['image'] ?>')"></div>
                </div>
                <h3><?= $a['title'] ?></h3>
                <?php if ($a['author']) : ?>
                    <div class="article-author">
                        <p><?= $a['firstname'] . ' ' . $a['lastname'] ?></p>
                    </div>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php
}
?>