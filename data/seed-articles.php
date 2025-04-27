<?php

$articles = json_decode(file_get_contents('./articles.json'), true);

$dns = 'mysql:host=localhost;dbname=blog';
$user = 'root';
$pwd = 'Root10cb49c!';
$connectOk = false;

try {
    $pdo = new PDO($dns, $user, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    $connectOk = true;
} catch (PDOException $e) {
    echo "error : " . $e->getMessage();
}

if ($connectOk) {
    // statement
    $statement = $pdo->prepare('insert into article (title, category, content, image) 
    values (:title, :category, :content, :image)');

    foreach ($articles as $article) {
        $statement->bindValue(':title', $article['title']);
        $statement->bindValue(':category', $article['category']);
        $statement->bindValue(':content', $article['content']);
        $statement->bindValue(':image', $article['image']);
        $statement->execute();
    };
    echo 'Initialisation BDD terminée';
} else {
    echo "L'initialisation de la BDD a échoué";
};
